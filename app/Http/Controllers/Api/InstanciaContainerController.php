<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ConsoleOut;
use App\Models\InstanciaContainer;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Symfony\Component\Process\Process;

class InstanciaContainerController extends Controller
{
    public function playStop($container_id)
    {
        $instancia = InstanciaContainer::where('container_docker_id', $container_id)->first();
        
        if($instancia->dataHora_finalizado){
            $cmd = "docker start $container_id";
            $dataHora_fim = null;
        } else {
            $cmd = "docker stop $container_id";
            $dataHora_fim = now();
        }

        try{
            $process_pull = new Process(explode(" ", $cmd));
            $process_pull->mustRun();

            $instancia->dataHora_finalizado = $dataHora_fim;
            $instancia->save();
    
            return redirect()->route('instance.index')->with('success', 'Container created with sucess!');
        } catch(Exception $e) {
            return redirect()->route('instance.index')->with('error', "Fail to stop the container! $e");
        }
    }

    public function execInTerminal(Request $request, $containerId)
    {
        $cmd = "docker exec -i $containerId $request->command";
        $process = Process::fromShellCommandline($cmd);
        $process->run();
        $data = [
            'containerDockerId' => $containerId,
            'command'           => $request->command,
            'out'               => $process->getOutput(),
            'status'            => $process->isSuccessful()
        ];
        ConsoleOut::create($data);
        
        return redirect()->route('instance.index')->with('success', 'Command executed with sucess!');
    }

    public function store(Request $request)
    {
        try{
            $params = [
                'imageId' => $request->id,
                'userId'  => $request->user_id,
            ];

            Artisan::call("create:container", $params);
            return redirect()->route('instance.index')->with('success', 'Container creation is running!');
        } catch(Exception $e) {
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
        $instancia = InstanciaContainer::firstWhere('id', $id);
        $instancia->delete();
        return redirect()->route('instance.index')->with('success', 'Container created with sucess!');
    }

    private function validar(Request $request)
    {
        $this->validate($request, InstanciaContainer::$rules);
    }
}
