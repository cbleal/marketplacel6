<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     * 
     * Permitem criar dados para as tabelas para fazermos testes das aplicações
     *
     * @return void
     */
    public function run()
    {
        $this->call(UsersTableSeeder::class);
      
    }
}
