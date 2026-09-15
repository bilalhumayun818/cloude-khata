<?php

namespace Tests\Feature;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class RepairRolesSchemaTest extends TestCase
{
    public function test_repairs_missing_columns_without_cross_business_assignment()
    {
        config(['database.default' => 'sqlite', 'database.connections.sqlite.database' => ':memory:']);
        DB::purge('sqlite');
        Schema::create('business', function (Blueprint $table) {
            $table->increments('id');
        });
        Schema::create('roles', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
        });
        DB::table('business')->insert([['id' => 3], ['id' => 4]]);
        foreach (['Admin#3', 'Cashier#4', 'superadmin', 'Admin#999'] as $name) {
            DB::table('roles')->insert(['name' => $name]);
        }

        $migration = require database_path('migrations/2026_09_15_000001_restore_business_columns_on_roles_table.php');
        $migration->up();
        $this->assertEquals(3, DB::table('roles')->where('name', 'Admin#3')->value('business_id'));
        $this->assertEquals(1, DB::table('roles')->where('name', 'Admin#3')->value('is_default'));
        $this->assertEquals(4, DB::table('roles')->where('name', 'Cashier#4')->value('business_id'));
        $this->assertNull(DB::table('roles')->where('name', 'superadmin')->value('business_id'));
        $this->assertNull(DB::table('roles')->where('name', 'Admin#999')->value('business_id'));

        DB::table('roles')->where('name', 'Admin#3')->update(['business_id' => 4, 'is_default' => false]);
        $migration->up();
        $this->assertEquals(4, DB::table('roles')->where('name', 'Admin#3')->value('business_id'));
        $this->assertEquals(0, DB::table('roles')->where('name', 'Admin#3')->value('is_default'));
        $this->assertEquals(4, DB::table('roles')->count());
        DB::disconnect('sqlite');
    }
}
