<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class bookReportsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        DB::table('bookReports')->truncate();
        Schema::enableForeignKeyConstraints();

        \DB::table('bookReports')->insert([
            [
                'reviewID' => 1,
                'UserID' => 1,
                'bookID' => 1001,
                'evaluation' => 4,
                'selectedComment' => 2,
                'comment' => 'たぶんよかった。',
                'Open' => 1,
                'created_at' => '2022-01-15 9:15:00'
            ],

            [
                'reviewID' => 2,
                'UserID' => 1,
                'bookID' => 1002,
                'evaluation' => 3,
                'selectedComment' => 2,
                'comment' => '最高。',
                'Open' => 1,
                'created_at' => '2021-11-15 4:15:00'
            ],

            [
                'reviewID' => 3,
                'UserID' => 1,
                'bookID' => 1004,
                'evaluation' => 1,
                'selectedComment' => 2,
                'comment' => 'イマイチだった。',
                'Open' => 1,
                'created_at' => '2022-04-15 9:00:00'
            ],
        ]);
    }
}
