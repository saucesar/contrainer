<?php

namespace App\Http\Controllers;

use App\Models\AtividadeMaquina;
use Illuminate\Http\Request;

class AtividadeMaquinasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return AtividadeMaquina::all();
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
        AtividadeMaquina::create($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return AtividadeMaquina::firstWhere('id', $id);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update($id)
    {
        $atividade = AtividadeMaquina::firstWhere('id', $id);

        if(!$atividade->dataHoraFim){
            $atividade->dataHoraFim = now();
            $atividade->save();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $atividade = AtividadeMaquina::firstWhere('id', $id);
        $atividade->delete();
    }

    private function validar(Request $request)
    {
        $this->validate($request, AtividadeMaquina::$rules, AtividadeMaquina::$messages);
    }
}
