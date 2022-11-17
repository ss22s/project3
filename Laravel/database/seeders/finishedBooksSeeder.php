<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class finishedBooksSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        DB::table('finishedBooks')->truncate();
        Schema::enableForeignKeyConstraints();

        \DB::table('finishedBooks')->insert([
            ['id' => 1,
            'bookID' => 1001,
            'date' => '2022-01-15 15:25:00',
            'reviewID' => 1,
            'delete' => null]
        ]);

        \DB::table('finishedBooks')->insert([
            ['id' => 2,
            'bookID' => 1006,
            'date' => '2022-02-15 11:54:00',
            'reviewID' => 3,
            'delete' => 1]
        ]);

        \DB::table('finishedBooks')->insert([
            ['id' => 1,
            'bookID' => 1005,
            'date' => '2022-03-18 16:24:00',
            'reviewID' => null,
            'delete' => null]
        ]);

        \DB::table('finishedBooks')->insert([
            ['id' => 3,
            'bookID' => 1002,
            'date' => '2022-03-23 13:54:00',
            'reviewID' => 2,
            'delete' => null]
        ]);

        \DB::table('finishedBooks')->insert([
            ['id' => 1,
            'bookID' => 1003,
            'date' => '2021-03-18 16:24:00',
            'reviewID' => null,
            'delete' => null]
        ]);

        \DB::table('finishedBooks')->insert([
            ['id' => 1,
            'bookID' => 1002,
            'date' => '2022-05-08 10:20:00',
            'reviewID' => null,
            'delete' => null]
        ]);

        \DB::table('finishedBooks')->insert([
            ['id' => 1,
            'bookID' => 1004,
            'date' => '2020-09-13 12:00:00',
            'reviewID' => null,
            'delete' => null]
        ]);

        \DB::table('finishedBooks')->insert([
            ['id' => 1,
            'bookID' => 1006,
            'date' => '2021-12-24 00:00:00',
            'reviewID' => null,
            'delete' => null]
        ]);
    }
}
