<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        $tableName = config('permission.table_names.roles', 'roles');

        if (! Schema::hasColumn($tableName, 'business_id')) {
            Schema::table($tableName, function (Blueprint $table) {
                $table->unsignedInteger('business_id')->nullable()->index();
            });
        }

        $restoreDefaults = ! Schema::hasColumn($tableName, 'is_default');
        if ($restoreDefaults) {
            Schema::table($tableName, function (Blueprint $table) {
                $table->boolean('is_default')->default(false);
            });
        }

        // Only infer ownership from the application's explicit role-name suffix.
        // Global roles and roles without a valid business stay unassigned.
        DB::table($tableName)->orderBy('id')->chunkById(100, function ($roles) use ($tableName, $restoreDefaults) {
            foreach ($roles as $role) {
                if (! preg_match('/^(.+)#([1-9][0-9]*)$/', $role->name, $matches)) {
                    continue;
                }
                $businessId = (int) $matches[2];
                if (! DB::table('business')->where('id', $businessId)->exists()) {
                    continue;
                }
                if ($role->business_id === null) {
                    DB::table($tableName)->where('id', $role->id)->update(['business_id' => $businessId]);
                }
                if ($restoreDefaults && $matches[1] === 'Admin'
                    && ($role->business_id === null || (int) $role->business_id === $businessId)) {
                    DB::table($tableName)->where('id', $role->id)->update(['is_default' => true]);
                }
            }
        });
    }

    public function down()
    {
        // Preserve repaired ownership and columns that may have predated this migration.
    }
};
