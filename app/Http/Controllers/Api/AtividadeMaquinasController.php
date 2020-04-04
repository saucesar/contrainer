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
        $hash = $request->input('hashcode_maquina');
        $data = [
            'hashcode_maquina' => $hash,
            'dataHoraInicio'   => now(),
        ];
        
        $machine = Maquina::firstWhere('hashcode', $hash);
        $activity = AtividadeMaquina::firstWhere(['dataHoraFim' => null, 'hashcode_maquina' => $hash]);

        if($machine && !$activity){
            AtividadeMaquina::create($data);

            $machine->disponivel = true;
            $machine->save();

            return "activity save.";
        } else {
            return "hashcode not found.";
        }
    }

    public function show($id)
    {
        return AtividadeMaquina::firstWhere('id', $id);
    }

    public function update(Request $request, $id)
    {
        $hash = $request->input('hashcode_maquina');

        $machine = Maquina::firstWhere('hashcode', $hash);
        $activity = AtividadeMaquina::firstWhere(['dataHoraFim' => null, 'hashcode_maquina' => $hash]);

        if($machine && $activity){
            $activity->dataHoraFim = now();
            $activity->save();

            $machine->disponivel = false;
            $machine->save();
        }
    }

    public function destroy($id)
    {
        $atividade = AtividadeMaquina::firstWhere('id', $id);
        $atividade->delete();
    }
}
