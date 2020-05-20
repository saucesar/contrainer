<?php

namespace App\Console;

use Aza\Components\Thread\Thread;
use App\Models\Container;
use Symfony\Component\Process\Process;
use App\Models\InstanciaContainer;
use App\Models\Maquina;

class ContainerCreateThread extends Thread
{
    public function setPreforkWait($value)
    {
        $this->preforkWait = $value;
    }

    public function process()
    {
        $params = $this->getParam(0);

        $containerImage = Container::findOrFail($params['imageId']);

        $cmd = "$containerImage->command_pull && $containerImage->command_run";
        /*
        $process = Process::fromShellCommandline($cmd);
        $process->setTimeout(null);
        $process->start();
        $process->wait();

        if($process->isSuccessful()){
            
            $out = explode("\n", $process->getOutput());    
            $dockerIdIndex = count($out) -2;
            $container_id = $out[$dockerIdIndex];

            $data = [
                'hashcode_maquina'     => Maquina::first()->hashcode,
                'container_docker_id'  => $container_id,
                'user_id'              => intval($params['userId']),
                'dataHora_instanciado' => now(),
                'dataHora_finalizado'  => null
            ];

            InstanciaContainer::create($data);

            return $process->getOutput();
        }*/
        $str = shell_exec($cmd);

        $out = explode("\n", $str);
        $dockerIdIndex = count($out) -2;
        $container_id = $out[$dockerIdIndex];

        $data = [
            'hashcode_maquina'     => Maquina::first()->hashcode,
            'docker_id'            => $container_id,
            'user_id'              => intval($params['userId']),
            'image_id'             => intval($params['imageId']),
            'dataHora_instanciado' => now(),
            'dataHora_finalizado'  => null
        ];
        InstanciaContainer::create($data);
        $this->cleanup();
        return $str;
    }
}