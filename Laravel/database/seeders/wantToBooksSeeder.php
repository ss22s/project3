<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class wantToBooksSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        DB::table('wantToBooks')->truncate();
        Schema::enableForeignKeyConstraints();

        \DB::table('wantToBooks')->insert([
            ['UserID' => 1,
            'bookID' => 1000,
            'registered_at' => '2022-01-11 13:10:00',
            'finished' => null],
        ]);
    }
}