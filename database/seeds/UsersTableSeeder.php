<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'nome' => 'Admin Admin',
            'email' => 'admin@material.com',
            'password' => Hash::make('secret'),
            'tipo_usuario' => 'normal',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }


}