<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Container;
use App\Models\InstanciaContainer;
use Exception;
use Symfony\Component\Process\Process;
use App\Models\Maquina;

class CreateContainer extends Command
{
    protected $signature = 'create:container {imageId}{userId}';

    protected $description = 'Command to create a new instace of container image passed.';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {

        $containerImage = Container::findOrFail($this->argument('imageId'));
        
        $bar = $this->output->createProgressBar(2);
        $bar->start();
        $bar->display();

        $cmd = "$containerImage->command_pull && $containerImage->command_run";

        $process = Process::fromShellCommandline($cmd);
        $process->mustRun();
        $bar->advance();

        if($process->isSuccessful()){
            $this->info("Image $containerImage->name successfully downloaded/updated.");
            
            $out = explode("\n", $process->getOutput());    
            $dockerIdIndex = count($out) -2;
            $container_id = $out[$dockerIdIndex];

            $data = [
                'hashcode_maquina'     => Maquina::first()->hashcode,
                'container_docker_id'  => $container_id,
                'user_id'              => intval($this->argument('userId')),
                'dataHora_instanciado' => now(),
                'dataHora_finalizado'  => null
            ];
            
            $bar->advance();

            InstanciaContainer::create($data);
            $this->info("Container created, id: $container_id");
        } else {
            $this->error('Failed to download the image!');
        }

        $bar->finish();
    }
}
