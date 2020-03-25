<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
        DB::table('users')->insert([
            'nome'         => 'Admin  admin',
            'email'        => 'admin@nuvem.com',
            'password'     => bcrypt('123456'),
            'tipo_usuario' => 'admin',
            'created_at'   => now(),
            'updated_at'   => now()
        ]);
    }
}
