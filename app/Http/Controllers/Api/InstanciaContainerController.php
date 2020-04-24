<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Container;
use App\Models\InstanciaContainer;
use App\Models\Maquina;
use Exception;
use Illuminate\Http\Request;
use Symfony\Component\Process\Process;

class InstanciaContainerController extends Controller
{

    public function index()
    {
        //
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        try{
            $container = Container::findOrFail($request->id);

            $process_pull = new Process(explode(" ", $container->command_pull));
            $process_pull->mustRun();
            $out_pull = $process_pull->getOutput();

            $process_run = new Process(explode(" ", $container->command_run));
            $process_run->mustRun();
            $container_id = substr($process_run->getOutput(), 0, -1);;

            $data = [
                'hashcode_maquina'     => Maquina::first()->hashcode,
                'container_docker_id'  => $container_id,
                'user_id'              => $request->user_id,
                'dataHora_instanciado' => now(),
                'dataHora_finalizado'  => null
            ];
            
            InstanciaContainer::create($data);
            
            session(['success' => 'Container created with sucess!']);
            return redirect()->route('containers.index',['success' => 'Container created with sucess!']);
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
        //
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
    }

    private function validar(Request $request)
    {
        $this->validate($request, InstanciaContainer::$rules);
    }
}
