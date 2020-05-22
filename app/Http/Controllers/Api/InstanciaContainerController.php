<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ConsoleOut;
use App\Models\InstanciaContainer;
use Exception;
use Illuminate\Http\Request;
use Symfony\Component\Process\Process;
use App\Console\ContainerCreateThread;

class InstanciaContainerController extends Controller
{
    public function playStop($container_id)
    {
        $instancia = InstanciaContainer::where('docker_id', $container_id)->first();

        if ($instancia->dataHora_finalizado) {
            $cmd = "docker start $container_id";
            $dataHora_fim = null;
        } else {
            $cmd = "docker stop $container_id";
            $dataHora_fim = now();
        }

        try {
            $process = Process::fromShellCommandline($cmd);
            $process->mustRun();

            $instancia->dataHora_finalizado = $dataHora_fim;
            $instancia->save();

            return redirect()->route('instance.index')->with('success', 'Container created with sucess!');
        } catch (Exception $e) {
            return redirect()->route('instance.index')->with('error', "Fail to stop the container! $e");
        }
    }

    public function execInTerminal(Request $request, $containerId)
    {
        $newTab = $request->newTab == '1' ? true : false;

        $cmd = "docker exec -i $containerId $request->command";
        $process = Process::fromShellCommandline($cmd);
        $process->run();
        $data = [
            'docker_id' => $containerId,
            'command' => $request->command,
            'out' => $process->getOutput(),
            'status' => $process->isSuccessful(),
        ];
        ConsoleOut::create($data);

        if ($newTab) {
            return redirect()->route('container.terminalTab', $containerId)->with('success', 'Command executed with sucess!');
        } else {
            return redirect()->back()->with('success', 'Command executed with sucess!');
        }
    }

    public function store(Request $request)
    {
        try {
            //Artisan::call("create:container", $params);
            $thread = new ContainerCreateThread();
            $thread->setPreforkWait(true);
            $thread->run($request->all());

            return redirect()->route('instance.index')->with('success', 'Container creation is running!');
        } catch (Exception $e) {
            return  $e->getMessage();
        }
    }

    public function show($id)
    {
        return InstanciaContainer::firstWhere('id', $id);
    }

    public function edit($id)
    {
        $instancia = InstanciaContainer::firstWhere('id', $id);

        $instancia->dataHora_finalizado = now();
        $instancia->save();

        return redirect()->route('instance.index')->with('success', 'Container created with sucess!');
    }

    public function update(Request $request, $id)
    {
        $this->validar($request);
        $instancia = InstanciaContainer::firstWhere('id', $id);
        $instancia->update($request->all());
    }

    public function destroy($id)
    {
        $cmd = "docker rm $id -f";
        $process = Process::fromShellCommandline($cmd);
        $process->run();

        if ($process->isSuccessful()) {
            $instancia = InstanciaContainer::firstWhere('docker_id', $id);
            $instancia->delete();

            return redirect()->route('instance.index')->with('success', 'Container deleted with sucess!');
        } else {
            return redirect()->route('instance.index')->with('error', 'Fail, Container not delete!');
        }
    }

    private function validar(Request $request)
    {
        $this->validate($request, InstanciaContainer::$rules);
    }
}
