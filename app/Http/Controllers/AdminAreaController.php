<?php

namespace App\Http\Controllers;

use App\Models\Container;
use App\Models\InstanciaContainer;
use App\Models\Maquina;

class AdminAreaController extends Controller
{
    public function index()
    {
        $params = [
            'numberOfMach' => Maquina::all()->count(),
            'numberOfCont' => Container::all()->count(),
            'containers'   => Container::all(),
            'instacesOfeachImage' => $this->getInstacesOfEachImage(),
            'inActivity'   => Maquina::where('disponivel', true)->get()->count()
        ];
        return view('pages/admin/index', $params);
    }

    private function getInstacesOfEachImage()
    {
        $containers = Container::all();

        $array = [];
        
        foreach($containers as $container){
            $array[$container->id] = InstanciaContainer::where('image_id', $container->id)->get()->count();
        }

        return $array;

    }
}
