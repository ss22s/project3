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
                'comment' => '面白かった！最高です！',
                'Open' => null,
                'created_at' => '2020-01-15 9:15:00'
            ],
            [
                'reviewID' => 2,
                'id' => 1,
                'bookID' => 'FccyEAAAQBAJ',
                'evaluation' => 1,
                'selectedComment' => '5',
                'comment' => '読みやすいと感じました。',
                'Open' => null,
                'created_at' => '2022-01-05 6:15:00'
            ],
            [
                'reviewID' => 3,
                'id' => 1,
                'bookID' => 'FA-dDQAAQBAJ',
                'evaluation' => 3,
                'selectedComment' => '2',
                'comment' => '読んで後悔はしません！おすすめできます！',
                'Open' => 1,
                'created_at' => '2022-03-28 9:15:00'
            ],
            [
                'reviewID' => 4,
                'id' => 1,
                'bookID' => 'xMMeNwAACAAJ',
                'evaluation' => 5,
                'selectedComment' => '2',
                'comment' => '今まで読んできた本の中でも最高でした。ぜひ読んでほしい一冊です。',
                'Open' => null,
                'created_at' => '2022-06-07 15:22:00'
            ],
            [
                'reviewID' => 5,
                'id' => 1,
                'bookID' => 'Y2YPcgAACAAJ',
                'evaluation' =>2,
                'selectedComment' => '5',
                'comment' => '子供の頃に読んでいた本です。懐かしくなって読み直したのですが、思っていたよりもつまらなかったかなという印象。',
                'Open' => null,
                'created_at' => '2022-04-20 9:15:00'
            ],
            [
                'reviewID' => 6,
                'id' => 1,
                'bookID' => 'FccyEAAAQBAJ',
                'evaluation' => 3,
                'selectedComment' => '2',
                'comment' => 'そこそこの分かりやすさはあると思います。とりあえず買ってみて',
                'Open' => null,
                'created_at' => '2022-06-30 9:15:00'
            ],
            [
                'reviewID' => 7,
                'id' => 1,
                'bookID' => 'xMMeNwAACAAJ',
                'evaluation' => 3,
                'selectedComment' => '2',
                'comment' => '良かったです。面白いので読んでみてください！',
                'Open' => null,
                'created_at' => '2003-01-15 9:15:00'
            ],
            [
                'reviewID' => 8,
                'id' => 2,
                'bookID' => 'Y2YPcgAACAAJ',
                'evaluation' => 5,
                'selectedComment' => '2',
                'comment' =>'名作と名高い「となりのトトロ」の感想です。子供だけではなく大人にも愛されるアニメである理由がよくわかりました。私は子供の頃からトトロが大好きでしたが、大人になってから再度見てみると、子供の視点では気付かなかった魅力を見つけることができました。子供も大人も楽しめる、そんな素晴らしいアニメです。どんな人にもおすすめできます！',
                'Open' => null,
                'created_at' => '2022-07-07 15:22:00'
            ],
            [
                'reviewID' => 9,
                'id' => 1,
                'bookID' => 'jfApAQAAMAAJ',
                'evaluation' => 4,
                'selectedComment' => '3,5',
                'comment' =>'かなりオススメの一冊！何度も読み直してしまうほどの面白さです！',
                'Open' => null,
                'created_at' => '2022-10-14 11:22:00'
            ],
            [
                'reviewID' => 10,
                'id' => 1,
                'bookID' => 'ZM9MzQEACAAJ',
                'evaluation' => 1,
                'selectedComment' => '4',
                'comment' =>'微妙かな。もう一度読むことはないと思います。',
                'Open' => 1,
                'created_at' => '2021-06-13 15:22:00'
            ],
            [
                'reviewID' => 11,
                'id' => 1,
                'bookID' => 'ZM9MzQEACAAJ',
                'evaluation' => 4,
                'selectedComment' => '2',
                'comment' =>'素晴らしいです！これは読まないと人生損してます。',
                'Open' => null,
                'created_at' => '2022-04-15 9:15:00'
            ]
        ]);
    }
}
