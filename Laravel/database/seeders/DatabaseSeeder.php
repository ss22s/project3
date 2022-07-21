<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        $this->call(usersTableSeeder::class);
        $this->call(MyPagesSeeder::class);
        $this->call(wantToBooksSeeder::class);
        $this->call(bookReportsSeeder::class);
        $this->call(finishedBooksSeeder::class);
        $this->call(followListsSeeder::class);
        $this->call(booksSeeder::class);
    }
}
