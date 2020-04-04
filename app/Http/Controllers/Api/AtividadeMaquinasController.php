<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\AtividadeMaquina;
use App\Models\Maquina;
use Illuminate\Http\Request;

class AtividadeMaquinasController extends Controller
{
    public function index()
    {
        return AtividadeMaquina::all();
    }

    public function store(Request $request)
    {
        $data = [
            'hashcode_maquina' => $request->input('hashcode_maquina'),
            'dataHoraInicio'   => now(),
        ];

        if(Maquina::firstWhere('hashcode', $data['hashcode_maquina'])){
            AtividadeMaquina::create($data);
            return "activity save.";
        } else {
            return "hashcode not found.";
        }
    }

    public function show($id)
    {
        return AtividadeMaquina::firstWhere('id', $id);
    }

    public function update($id)
    {
        $atividade = AtividadeMaquina::firstWhere('id', $id);

        if(!$atividade->dataHoraFim){
            $atividade->dataHoraFim = now();
            $atividade->save();
        }
    }

    public function destroy($id)
    {
        $atividade = AtividadeMaquina::firstWhere('id', $id);
        $atividade->delete();
    }
}
