<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Container;

class ContainersController extends Controller
{

    public function index()
    {
        return view('pages/containers/containers',['containers' => Container::all()]);
    }

    public function create()
    {
        return view('containers.create',['programas' => $this->getProgramsList()]);
    }

    public function store(Request $request)
    {
        $this->validar($request);

        $dados = $request->all();
        $dados['programas'] = $this->getRequestPrograms($request);

        Container::create($dados);
    }

    public function show($id)
    {
        return view('containers.show',['container' => Container::firstWhere('id', $id)]);
    }

    public function edit($id)
    {
        return view('containers.edit',['container' => Container::firstWhere('id', $id)]);   
    }

    public function update(Request $request, $id)
    {
        $this->validar($request);

        $dados = $request->all();
        $dados['programas'] = $this->getRequestPrograms($request);

        $container = Container::firstWhere('id', $id);
        $container->update($dados);
    }

    public function destroy($id)
    {
        $container = Container::firstWhere('id', $id);

        if($container->delete()){

        } else{

        }
    }

    private function validar(Request $request)
    {
        $this->validate($request, Container::$rules, Container::$messages);
    }

    private function getProgramsList()
    {
        return ['MYSQL', 'POSTGRES', 'NGINX', 'PHP'];
    }

    private function getRequestPrograms(Request $request)
    {
        $str = "";

        foreach($this->getProgramsList() as $program){
            if($program == $request->input($program)){
                $str .= $program;
                $str .= ',';
            }
        }

        return $str;
    }
}
