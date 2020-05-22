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

        $containerImage = Container::findOrFail($params['image_id']);

        $cmd = "$containerImage->command_pull && $containerImage->command_run";

        $process = Process::fromShellCommandline($cmd);
        $process->setTimeout(null);
        $process->start();
        $process->wait();

        if ($process->isSuccessful()) {
            $out = explode("\n", $process->getOutput());
            $dockerIdIndex = count($out) - 2;

            $params['hashcode_maquina'] = Maquina::first()->hashcode;
            $params['docker_id'] = $out[$dockerIdIndex];
            $params['dataHora_instanciado'] = now();
            $params['dataHora_finalizado'] = null;

            //dd($params);
            InstanciaContainer::create($params);
            $this->cleanup();
        }
    }
}
