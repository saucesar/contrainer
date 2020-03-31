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
            'name'         => 'Admin  admin',
            'email'        => 'admin@nuvem.com',
            'password'     => bcrypt('123456'),
            'phone' => '8799998888',
            'user_type' => 'admin',
            'created_at'   => now(),
            'updated_at'   => now()
        ]);

        DB::table('maquinas')->insert([
            'cpu_utilizavel'         => 30,
            'ram_utilizavel'        => 1024,
            'hashcode'     => 'ascde',
            'user_id' => 1,
            'created_at'   => now(),
            'updated_at'   => now()
        ]);

        DB::table('atividade_maquinas')->insert([
            'hashcode_maquina'         => 'ascde',
            'dataHoraInicio'        => now(),
            'created_at'   => now(),
            'updated_at'   => now()
        ]);

        
        $this->call([UsersTableSeeder::class]);
    }
}
