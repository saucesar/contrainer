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
        $this->call([UserCategorySeeder::class]);

        DB::table('users')->insert([
            'name' => 'Admin  admin',
            'email' => 'admin@nuvem.com',
            'password' => bcrypt('123456'),
            'phone' => '8799998888',
            'user_type' => 'admin',
            'category_id' => 1,
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

        DB::table('images')->insert([
            'name' => 'Nginx:latest',
            'description' => 'Nginx (pronounced "engine-x") is an open source
                              reverse proxy server for HTTP, HTTPS, SMTP, POP3, and IMAP
                              protocols, as well as a load balancer, HTTP cache, and a web
                              server (origin server).',
            'fromImage' => 'nginx',
            'tag' => 'latest',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('default_templates')->insert([
            'name' => 'service',
            'template' => json_encode([
                'Name' => 'SERVICE_NAME',
                'TaskTemplate' => [
                    'ContainerSpec' => [
                        'Image' => 'IMAGE_NAME',
                        'Env' => [],
                        'DNSConfig' => [
                            'Nameservers' => ['8.8.8.8'],
                            'Search' =>  [],
                            'Options' => ["timeout:3"],
                        ],
                        'TTY' => true,
                        'OpenStdin' => true,
                    ],
                    'Resources' => [
                        'Limits' => [
                            'MemoryBytes' => 104857600,//equivale a 100MB
                        ],
                    ],
                    'RestartPolicy' => [
                        "Condition" => "any",
                        "Delay" => 50000000000,
                        "MaxAttempts" => 0,
                    ],
                    'ForceUpdate' => 0,
                    'Runtime' => 'container',
                ],
                'Mode' => [
                    'Replicated' => [
                        'Replicas' => 2,
                    ],
                ],
                'UpdateConfig' => [
                    'Parallelism' => 1,
                    'FailureAction' => 'pause',
                    'Monitor' => 5000000000,
                    'MaxFailureRatio' => 0,
                    "Order" => "stop-first",
                ],
                'EndpointSpec' => [
                    'Ports' => [
                        [
                            'Protocol' => 'tcp',
                            'PublishedPort' => 1111,
                            'TargetPort' => 80
                        ],
                    ],
                ],
                'Labels' => [],
            ])
        ]);

        DB::table('default_templates')->insert([
            'name' => 'container',
            'template' => json_encode([
                "nickname" => "NICKNAME",
                "Labels" => [
                    'app.name' => 'cloud-project',
                ],
                "Hostname"=> null,
                "Domainname" => "cloud",
                "Dns" => [],
                "DnsOptions" => [],
                "DnsSearch"=> [],
                "IPAddress" => '',
                "IPPrefixLen" => 0,
                "MacAddress" => "",
                "Memory" => 0,
                "NetworkMode" => "bridge",
                "Image" => "IMAGE_NAME",
                "Env" => [],
                "AttachStdin" =>true,
                "AttachStdout" => true,
                "AttachStderr" => true,
                "OpenStdin" => true,
                "StdinOnce" => false,
                "Tty" =>true,
                "Entrypoint"=> [
                    "/bin/bash",
                ],
                "HostConfig" => [
                    "PublishAllPorts" => true,
                    "Privileged" => true,
                    "RestartPolicy" => [
                        "name" => "always",
                    ],
                    "NetworkMode" => "bridge",
                    "Binds" => [
                        "/var/run/docker.sock:/var/run/docker.sock",
                        "/tmp:/tmp",
                    ],
                ],
            ])
        ]);

        DB::table('default_templates')->insert([
            'name' => 'volume_driver',
            'template' => json_encode([
                "Name"=> 'VOLUME_NAME',
                "Labels"=> [
                    'container.name' => 'CONTAINER_NAME',
                ],
                "Driver" => "lvm",
                "DriverOpts" => [
                    'size' => 'VOLUME_SIZE',
                    'keyfile' => 'PATH_TO_KEY',
                ],
            ])
        ]);

        $this->call([UsersTableSeeder::class]);
    }
}
