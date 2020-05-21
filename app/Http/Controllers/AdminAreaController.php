<?php

namespace App\Http\Controllers;

use App\Models\Container;
use App\Models\InstanciaContainer;
use App\Models\Maquina;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AdminAreaController extends Controller
{
    public function index()
    {
        $params = [
            'numberOfMach' => Maquina::all()->count(),
            'inActivity' => Maquina::where('disponivel', true)->get()->count(),
            'numberOfCont' => Container::all()->count(),
            'containers' => Container::all(),
            'numberOfUsers' => User::all()->count(),
            'registeredToday' => User::whereYear('created_at', date('Y'))->whereMonth('created_at', date('m'))->whereDay('created_at', date('d'))->count(),
            'registeredMonth' => User::whereYear('created_at', date('Y'))->whereMonth('created_at', date('m'))->count(),
            'instacesOfeachImage' => $this->getInstacesOfEachImage(),
        ];

        return view('pages/admin/index', $params);
    }

    public function machines()
    {
        if (Auth::user()->isAdmin()) {
            return view('pages/admin/machines', ['machines' => Maquina::all()]);
        } else {
            return redirect()->back()->with('error', 'User not Authorized!!!');
        }
    }

    public function users()
    {
        if (Auth::user()->isAdmin()) {
            $users = User::all()->sortBy('id');
            $params = [
                'users' => $users,
                'machinesCount' => $this->getMachinesCount($users),
                'containersCount' => $this->getInstanceContainersCount($users),
            ];

            return view('pages/admin/users', $params);
        } else {
            return redirect()->back()->with('error', 'User not Authorized!!!');
        }
    }

    public function getMachinesCount($users)
    {
        $array = [];

        foreach ($users as $user) {
            $array[$user->id] = Maquina::where('user_id', $user->id)->count();
        }

        return $array;
    }

    public function getInstanceContainersCount($users)
    {
        $array = [];

        foreach ($users as $user) {
            $array[$user->id] = InstanciaContainer::where('user_id', $user->id)->count();
        }

        return $array;
    }

    private function getInstacesOfEachImage()
    {
        $containers = Container::all();

        $array = [];

        foreach ($containers as $container) {
            $array[$container->id] = InstanciaContainer::where('image_id', $container->id)->get()->count();
        }

        return $array;
    }
}
