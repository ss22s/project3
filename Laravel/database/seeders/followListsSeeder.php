<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class followListsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        DB::table('followLists')->truncate();
        Schema::enableForeignKeyConstraints();

        \DB::table('followLists')->insert([
            ['id' => 1,
            'followerID' => 1],
        ]);
    }
}
