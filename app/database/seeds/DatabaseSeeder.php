<?php

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
        \App\Category::firstOrCreate(['name' => '会議室']);
        \App\Category::firstOrCreate(['name' => 'PC']);
        \App\Category::firstOrCreate(['name' => '机']);
    }
}
