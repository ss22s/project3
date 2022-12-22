<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class usersTableSeeder extends Seeder
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
        Schema::enableForeignKeyConstraints();

        \DB::table('users')->insert([
            ['id' => 1,
            'name' => 'タロ',
            'email' => 'taro@aaa.com',
            'password' => bcrypt('taro12345'),
            'exit' => null],
        ]);

        \DB::table('users')->insert([
            ['id' => 2,
            'name' => 'タマ',
            'email' => 'tama@aaa.com',
            'password' => bcrypt('tama12345'),
            'exit' => null],
        ]);

        \DB::table('users')->insert([
            ['id' => 3,
            'name' => 'ポチ',
            'email' => 'pochi@aaa.com',
            'password' => bcrypt('pochi12345'),
            'exit' => null],
        ]);
    }
}
