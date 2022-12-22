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
                'id' => 1,
                'bookID' => 'Y2YPcgAACAAJ',
                'evaluation' => 4,
                'selectedComment' => '2',
                'comment' => 'たぶんよかった。',
                'Open' => null,
                'created_at' => '2022-01-15 9:15:00'
            ],
            [
                'reviewID' => 2,
                'id' => 1,
                'bookID' => 'FccyEAAAQBAJ',
                'evaluation' => 1,
                'selectedComment' => '5',
                'comment' => 'よくなかった。',
                'Open' => null,
                'created_at' => '2021-02-05 6:15:00'
            ],
            [
                'reviewID' => 3,
                'id' => 1,
                'bookID' => 'FA-dDQAAQBAJ',
                'evaluation' => 3,
                'selectedComment' => '2',
                'comment' => '普通',
                'Open' => 1,
                'created_at' => '2019-11-28 9:15:00'
            ],
            [
                'reviewID' => 4,
                'id' => 1,
                'bookID' => 'xMMeNwAACAAJ',
                'evaluation' => 5,
                'selectedComment' => '2',
                'comment' => '最高だった。',
                'Open' => null,
                'created_at' => '2022-04-15 9:15:00'
            ],
            [
                'reviewID' => 5,
                'id' => 1,
                'bookID' => 'Y2YPcgAACAAJ',
                'evaluation' =>1,
                'selectedComment' => '5',
                'comment' => '二度と読まない。',
                'Open' => null,
                'created_at' => '2022-06-30 9:15:00'
            ],
            [
                'reviewID' => 6,
                'id' => 1,
                'bookID' => 'FccyEAAAQBAJ',
                'evaluation' => 4,
                'selectedComment' => '2',
                'comment' => '普通。まあまあ',
                'Open' => null,
                'created_at' => '2022-04-20 9:15:00'
            ],
            [
                'reviewID' => 7,
                'id' => 1,
                'bookID' => 'xMMeNwAACAAJ',
                'evaluation' => 3,
                'selectedComment' => '2',
                'comment' => 'よかった。',
                'Open' => null,
                'created_at' => '2003-01-15 9:15:00'
            ],
            [
                'reviewID' => 8,
                'id' => 2,
                'bookID' => 'Y2YPcgAACAAJ',
                'evaluation' => 1,
                'selectedComment' => '2',
                'comment' =>'名作と名高い「となりのトトロ」の感想です。子供だけではなく大人にも愛されるアニメである理由がよくわかりました。私は子供の頃からトトロが大好きでしたが、大人になってから再度見てみると、子供の視点では気付かなかった魅力を見つけることができました。子供も大人も楽しめる、そんな素晴らしいアニメです。どんな人にもおすすめできます！',
                'Open' => null,
                'created_at' => '2022-07-07 15:22:00'
            ],
            [
                'reviewID' => 9,
                'id' => 1,
                'bookID' => 'jfApAQAAMAAJ',
                'evaluation' => 1,
                'selectedComment' => '3,5',
                'comment' =>'おもしろい',
                'Open' => null,
                'created_at' => '2022-10-14 11:22:00'
            ],
            [
                'reviewID' => 10,
                'id' => 1,
                'bookID' => 'ZM9MzQEACAAJ',
                'evaluation' => 1,
                'selectedComment' => '4',
                'comment' =>'kawaii',
                'Open' => 1,
                'created_at' => '2021-07-07 15:22:00'
            ],
            [
                'reviewID' => 11,
                'id' => 1,
                'bookID' => 'FLc9zwEACAAJ',
                'evaluation' => 1,
                'selectedComment' => '2',
                'comment' =>'yeah',
                'Open' => null,
                'created_at' => '2021-04-13 15:22:00'
            ]
        ]);
    }
}
