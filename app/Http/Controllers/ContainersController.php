<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Container;

class ContainersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('containers.create',['programas' => $this->getProgramsList()]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validar($request);

        $dados = $request->all();
        $dados['programas'] = $this->getRequestPrograms($request);

        Container::create($dados);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return view('containers.show',['container' => Container::firstWhere('id', $id)]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return view('containers.edit',['container' => Container::firstWhere('id', $id)]);   
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validar($request);

        $dados = $request->all();
        $dados['programas'] = $this->getRequestPrograms($request);

        $container = Container::firstWhere('id', $id);
        $container->update($dados);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
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
