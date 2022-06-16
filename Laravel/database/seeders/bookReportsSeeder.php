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
            ['reviewID' => 1,
            'UserID' => 1,
            'bookID' => 1001,
            'evaluation' => 4,
            'selectedComment' => 2,
            'comment' => 'たぶんよかった。',
            'Open' => 1,
            'created_at' => '2022-01-15 9:15:00']
        ]);
    }
}
