<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

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
            'name' => 'Admin Admin',
            'email' => 'admin@material.com',
            'password' => Hash::make('secret'),
            'phone' => '8799998888',
            'user_type' => 'normal',
            'category_id' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }


}