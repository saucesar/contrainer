<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'Admin  admin',
            'email' => 'admin@nuvem.com',
            'password' => bcrypt('123456'),
            'phone' => '8799998888',
            'user_type' => 'admin',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('maquinas')->insert([
            'cpu_utilizavel' => 30,
            'ram_utilizavel' => 1024,
            'hashcode' => '$2y$10$meLLu4qZwa9GXlGSB9/KLu/KDT.ayLqTAFKbtxP/qQpieyFe2.wUW',
            'user_id' => 1,
            'ip' => '1.1.1.1',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('atividade_maquinas')->insert([
            'hashcode_maquina' => '$2y$10$meLLu4qZwa9GXlGSB9/KLu/KDT.ayLqTAFKbtxP/qQpieyFe2.wUW',
            'dataHoraInicio' => now(),
            'last_notification' => now(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('containers')->insert([
            'name' => 'nginx',
            'description' => 'Nginx (pronounced "engine-x") is an open source
                               reverse proxy server for HTTP, HTTPS, SMTP, POP3, and IMAP
                               protocols, as well as a load balancer, HTTP cache, and a web
                               server (origin server).',
            'programs' => '',
            'command_pull' => 'docker pull nginx',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $this->call([UsersTableSeeder::class]);
    }
}
