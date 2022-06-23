<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class booksSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        DB::table('books')->truncate();
        Schema::enableForeignKeyConstraints();

        \DB::table('books')->insert([
            ['bookID' => 1001,
            'book' => 'となりのトトロ',
            'auther' => 'スタジオジブリ',
            'genre' => '児童書'],
        ]);
    }
}
