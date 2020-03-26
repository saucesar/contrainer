<?php

namespace App\Http\Controllers;

use App\Models\Maquina;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MaquinasController extends Controller
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
        //
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
        $maquina = Maquina::create($this->getData($request));

        if($maquina){
            return redirect()->route('home.index');
        } else{
            return redirect()->back()->withInput();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return view('maquinas.show', ['maquina' =>  Maquina::firstWhere('id', $id)]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return view('maquinas.edit', ['maquina' =>  Maquina::firstWhere('id', $id)]);
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
        $maquina = Maquina::firstWhere('id', $id);
        $maquina->update($this->getData($request));

        if($maquina){
            return redirect()->route('home.index');
        } else{
            return redirect()->back()->withInput();
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
        $maquina = Maquina::firstWhere('id',$id);
        if($maquina->delete()){
            return redirect()->route('home.index');
        } else{ 
            return redirect()->route('maquinas.show',['maquina' => $maquina]);
        }
    }

    private function validar(Request $request)
    {
        $this->validate($request, Maquina::$rules, Maquina::$messages);
    }

    private function getUserId()
    {
        return Auth::user()->id;
    }

    private function getData(Request $request)
    {
        $data = [
            'cpu_utilizavel' => $request->input('cpu_utilizavel'),
            'ram_utilizavel' => $request->input('cpu_utilizavel'),
            'user_id'        => $this->getUserId(),
        ];

        $data['hashcode'] = $this->getHashCode($data);

        return $data;
    }

    private function getHashCode($data)
    {
        $hash = "";

        foreach($data as $d){
            $hash .= $d;
        }

        return $hash;
    }
}
