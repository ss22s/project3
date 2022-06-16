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
            ['UserID' => 1,
            'bookID' => 1001,
            'date' => '2022-01-15 15:25:00',
            'reviewID' => 1]
        ]);
    }
}
