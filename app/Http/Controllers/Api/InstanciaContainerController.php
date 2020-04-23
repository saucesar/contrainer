<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Container;
use App\Models\InstanciaContainer;
use Illuminate\Http\Request;
use Symfony\Component\Process\Process;

class InstanciaContainerController extends Controller
{
    public function instanciate(Request $request, $id)
    {
        //dd($id);
        dd($request);
        $container = Container::firstWhere('id', $id);
        if($container){
            $process = new Process([$container->command]);
            $process->run();

            return redirect()->route('containers.index')->with('success', 'Container created with sucess!');
        } else{
            return redirect()->route('containers.index')->with('error', 'Problem to create the container!');
        }
    }

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
        $this->validar($request);
        InstanciaContainer::create($request->all());
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
