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
            ['bookID' => 'Y2YPcgAACAAJ',
            'book' => 'となりのトトロ',
            'author' => '不明',
            'ISBN' => 9784196695813,
            'categories' => 'Animation (Cinematography)'],
        ]);

        \DB::table('books')->insert([
            ['bookID' => 'xMMeNwAACAAJ',
            'book' => 'カラフル',
            'author' => '森絵都',
            'ISBN' => 9784167741013,
            'categories' => 'Fantasy fiction'],
        ]);

        \DB::table('books')->insert([
            ['bookID' => 'jfApAQAAMAAJ',
            'book' => 'ハリーポッターと賢者の石',
            'author' => 'J.K. ローリング',
            'ISBN' => 9784915512377,
            'categories' => '不明'],
        ]);

        \DB::table('books')->insert([
            ['bookID' => 'FccyEAAAQBAJ',
            'book' => 'かんたん合格 基本情報技術者過去問題集 令和3年度下期',
            'author' => '株式会社ノマド・ワークス',
            'ISBN' => 9784295011538,
            'categories' => 'Computers'],
        ]);

        \DB::table('books')->insert([
            ['bookID' => 'FLc9zwEACAAJ',
            'book' => 'Myojo LIVE!',
            'author' => '不明',
            'ISBN' => 9784081023509,
            'categories' => '不明'],
        ]);

        \DB::table('books')->insert([
            ['bookID' => 'FA-dDQAAQBAJ',
            'book' => 'カードキャプターさくら　クリアカード編（１）',
            'author' => 'ＣＬＡＭＰ',
            'ISBN' => 9784063930993,
            'categories' => 'Comics & Graphic Novels'],
        ]);

        \DB::table('books')->insert([
            ['bookID' => 'ZM9MzQEACAAJ',
            'book' => 'わたしの美しい庭',
            'author' => '凪良ゆう',
            'ISBN' => 9784591164853,
            'categories' => '不明'],
        ]);
    }
}
