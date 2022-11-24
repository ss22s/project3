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
            'author' => 'スタジオジブリ',
            'genre' => '児童書'],
        ]);

        \DB::table('books')->insert([
            ['bookID' => 1002,
            'book' => 'カラフル',
            'author' => '森絵都',
            'genre' => '児童書'],
        ]);

        \DB::table('books')->insert([
            ['bookID' => 1003,
            'book' => 'ハリーポッターと賢者の石',
            'author' => 'J・K・ローリング',
            'genre' => '児童書'],
        ]);

        \DB::table('books')->insert([
            ['bookID' => 1004,
            'book' => '基本情報技術者過去問題集',
            'author' => '技術評論社',
            'genre' => '問題集'],
        ]);

        \DB::table('books')->insert([
            ['bookID' => 1005,
            'book' => 'Myojo',
            'author' => '集英社',
            'genre' => '雑誌'],
        ]);

        \DB::table('books')->insert([
            ['bookID' => 1006,
            'book' => 'カードキャプターさくら',
            'author' => 'CLAMP',
            'genre' => '少女漫画'],
        ]);

        \DB::table('books')->insert([
            ['bookID' => 1007,
            'book' => 'わたしの美しい庭',
            'author' => '凪良ゆう',
            'genre' => '小説・文芸'],
        ]);
    }
}
