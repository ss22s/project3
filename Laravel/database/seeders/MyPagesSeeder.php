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
        DB::table('users')->truncate();
        DB::table('MyPages')->truncate();
        Schema::enableForeignKeyConstraints();

        \DB::table('users')->insert([
            [
                'UserID' => 1,
                'name' => 'タロ',
                'email' => 'aaa@bbb.com',
                'pass' => '12345',
                'exit' => null
            ],
            [
                'UserID' => 2,
                'name' => 'シロ',
                'email' => '222@bbb.com',
                'pass' => '22222',
                'exit' => null
            ],
            [
                'UserID' => 3,
                'name' => 'タオ',
                'email' => '333@bbb.com',
                'pass' => '33333',
                'exit' => null
            ],
        ]);

        \DB::table('MyPages')->insert([
            [
                'UserID' => 1,
                'favoriteBook' => '苦しかったときの話をしようか',
                'favoriteAuthor' => '森岡毅',
                'freeText' => 'Hello!'
            ],
        ]);
    }
}
