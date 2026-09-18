<?php

namespace Tests\Feature;

use Database\Seeders\DatabaseSeeder;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class DatabaseSeederTest extends TestCase
{
    public function test_reseeding_restores_missing_defaults_without_overwriting_existing_records(): void
    {
        config(['database.default' => 'sqlite', 'database.connections.sqlite.database' => ':memory:', 'cache.default' => 'array']);
        DB::purge('sqlite');
        Schema::create('business', function (Blueprint $table): void {
            $table->increments('id');
        });
        foreach (['2017_11_21_064540_create_barcodes_table.php', '2017_07_05_071953_create_currencies_table.php'] as $file) {
            $migration = require database_path('migrations/'.$file);
            $migration->up();
        }
        Schema::create('permissions', function (Blueprint $table): void {
            $table->increments('id');
            $table->string('name');
            $table->string('guard_name');
            $table->timestamps();
            $table->unique(['name', 'guard_name']);
        });
        $this->seed(DatabaseSeeder::class);
        $counts = [];
        foreach (['barcodes', 'currencies', 'permissions'] as $table) {
            $counts[$table] = DB::table($table)->count();
        }
        DB::table('barcodes')->where('id', 1)->update(['name' => 'Custom label']);
        DB::table('currencies')->where('id', 1)->update(['symbol' => 'Custom symbol']);
        DB::table('barcodes')->where('id', 6)->delete();
        DB::table('currencies')->where('id', 134)->delete();
        DB::table('permissions')->where('name', 'user.view')->delete();

        $this->seed(DatabaseSeeder::class);
        $this->seed(DatabaseSeeder::class);

        foreach ($counts as $table => $count) {
            $this->assertDatabaseCount($table, $count);
        }
        $this->assertDatabaseHas('barcodes', ['id' => 1, 'name' => 'Custom label']);
        $this->assertDatabaseHas('barcodes', ['id' => 6, 'name' => 'Continuous Rolls - 31.75mm x 25.4mm']);
        $this->assertDatabaseHas('currencies', ['id' => 1, 'symbol' => 'Custom symbol']);
        $this->assertDatabaseHas('currencies', ['id' => 134, 'code' => 'BDT']);
        $this->assertDatabaseHas('permissions', ['name' => 'user.view', 'guard_name' => 'web']);
        DB::disconnect('sqlite');
    }
}
