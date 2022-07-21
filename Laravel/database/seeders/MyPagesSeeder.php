<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class MyPagesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        DB::table('MyPages')->truncate();
        Schema::enableForeignKeyConstraints();

        \DB::table('MyPages')->insert([
            ['id' => 1,
            'favoriteBook' => '苦しかったときの話をしようか',
            'favoriteAuthor' => '森岡毅',
            'freeText' => 'Hello!'],
        ]);

        \DB::table('MyPages')->insert([
            ['id' => 2,
            'favoriteBook' => 'となりのトトロ',
            'favoriteAuthor' => '宮崎駿',
            'freeText' => 'TOTORO!'],
        ]);

        \DB::table('MyPages')->insert([
            ['id' => 3,
            'favoriteBook' => 'おいしいごはんが食べられますように',
            'favoriteAuthor' => '高瀬隼子',
            'freeText' => 'お腹すいた'],
        ]);
    }
}