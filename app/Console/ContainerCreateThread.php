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

        $cmd_run = 'docker run -d ';
        if ($params['external-port']) {
            $cmd_run .= $params['external-port'];
            $cmd_run .= ' ';
        }
        if ($params['ip']) {
            $cmd_run .= '--ip=';
            $cmd_run .= '"';
            $cmd_run .= $params['ip'];
            $cmd_run .= '"';
            $cmd_run .= ' ';
        }
        if ($params['add-host']) {
            $cmd_run .= '--add-host=';
            $cmd_run .= '"';
            $cmd_run .= $params['add-host'];
            $cmd_run .= '"';
            $cmd_run .= ' ';
        }
        if ($params['dns']) {
            $cmd_run .= '--dns=';
            $cmd_run .= $params['dns'];
            $cmd_run .= ' ';
        }
        if ($params['envVariables']) {
            $variables = explode(';', $params['envVariables']);
            foreach ($variables as $var) {
                $cmd_run .= '-e ';
                $cmd_run .= $var;
            }
            $cmd_run .= $params['dns'];
            $cmd_run .= ' ';
        }

        $cmd_run .= ' --restart=always ';
        $cmd_run .= $containerImage->name;
        $cmd = "$containerImage->command_pull && $cmd_run";

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
