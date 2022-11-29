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
            ['bookISBN' => 9784196695813,
            'book' => 'となりのトトロ',
            'author' => 'スタジオジブリ',
            'genre' => '児童書'],
        ]);

        \DB::table('books')->insert([
            ['bookISBN' => 9784167741013,
            'book' => 'カラフル',
            'author' => '森絵都',
            'genre' => '児童書'],
        ]);

        \DB::table('books')->insert([
            ['bookISBN' => 9784863893313,
            'book' => 'ハリーポッターと賢者の石',
            'author' => 'J・K・ローリング',
            'genre' => '児童書'],
        ]);

        \DB::table('books')->insert([
            ['bookISBN' => 9784295011538,
            'book' => 'かんたん合格 基本情報技術者過去問題集 令和3年度下期',
            'author' => '株式会社ノマド・ワークス',
            'genre' => '問題集'],
        ]);

        \DB::table('books')->insert([
            ['bookISBN' => 9784081023509,
            'book' => 'Myojo LIVE!',
            'author' => '集英社',
            'genre' => '雑誌'],
        ]);

        \DB::table('books')->insert([
            ['bookISBN' => 9784063930993,
            'book' => 'カードキャプターさくらクリアカード編 1',
            'author' => 'CLAMP',
            'genre' => '少女漫画'],
        ]);

        \DB::table('books')->insert([
            ['bookISBN' => 9784591164853,
            'book' => 'わたしの美しい庭',
            'author' => '凪良ゆう',
            'genre' => '小説・文芸'],
        ]);
    }
}
