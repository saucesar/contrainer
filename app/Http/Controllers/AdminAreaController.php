<?php

namespace App\Http\Controllers;

use App\Models\Image;
use App\Models\Container;
use App\Models\Maquina;
use App\Models\User;
use App\Models\UserCategory;
use Illuminate\Support\Facades\Auth;

class AdminAreaController extends Controller
{
    private const PAGE_LIMITE = 10;

    public function index()
    {
        if(!Auth::user()){
            return redirect()->route('login');
        }
        $params = [
            'machines' => Maquina::paginate($this::PAGE_LIMITE),
            'users' => User::orderBy('id')->paginate($this::PAGE_LIMITE),
            'containers' => Container::paginate($this::PAGE_LIMITE),
            'dockerHost' => env('DOCKER_HOST'),
            'numberOfMach' => Maquina::all()->count(),
            'inActivity' => Maquina::where('disponivel', true)->count(),
            'images' => Image::paginate($this::PAGE_LIMITE),
            'isAdmin' => Auth::user()->isAdmin(),
            'registeredToday' => User::whereYear('created_at', date('Y'))->whereMonth('created_at', date('m'))->whereDay('created_at', date('d'))->count(),
            'registeredMonth' => User::whereYear('created_at', date('Y'))->whereMonth('created_at', date('m'))->count(),
            'instacesOfeachImage' => $this->getInstacesOfEachImage(),
            'graficDataUsers' => $this->getGraficDataUsers(),
            'graficDataMachines' => $this->getGraficDataMachines(),
            'imagesLabel' => $this->getImagesLabels(),
            'graficDataImages' => $this->getInstacesCountImages(),
            'title' => 'Admin Area',
            'categories' => UserCategory::all(),
        ];

        return view('pages/admin/index', $params);
    }

    public function machines()
    {
        if (Auth::user()->isAdmin()) {
            return view('pages/admin/machines', ['machines' => Maquina::orderBy('id')->paginate(10)]);
        } else {
            return redirect()->back()->with('error', 'User not Authorized!!!');
        }
    }

    public function getGraficDataUsers()
    {
        return json_encode([
            User::whereYear('created_at', date('Y'))->whereMonth('created_at', date('1'))->count(),
            User::whereYear('created_at', date('Y'))->whereMonth('created_at', date('2'))->count(),
            User::whereYear('created_at', date('Y'))->whereMonth('created_at', date('3'))->count(),
            User::whereYear('created_at', date('Y'))->whereMonth('created_at', date('4'))->count(),
            User::whereYear('created_at', date('Y'))->whereMonth('created_at', date('5'))->count(),
            User::whereYear('created_at', date('Y'))->whereMonth('created_at', date('6'))->count(),
            User::whereYear('created_at', date('Y'))->whereMonth('created_at', date('7'))->count(),
            User::whereYear('created_at', date('Y'))->whereMonth('created_at', date('8'))->count(),
            User::whereYear('created_at', date('Y'))->whereMonth('created_at', date('9'))->count(),
            User::whereYear('created_at', date('Y'))->whereMonth('created_at', date('10'))->count(),
            User::whereYear('created_at', date('Y'))->whereMonth('created_at', date('11'))->count(),
            User::whereYear('created_at', date('Y'))->whereMonth('created_at', date('12'))->count(),
        ]);
    }

    public function getGraficDataMachines()
    {
        return json_encode([
            Maquina::whereYear('created_at', date('Y'))->whereMonth('created_at', date('1'))->count(),
            Maquina::whereYear('created_at', date('Y'))->whereMonth('created_at', date('2'))->count(),
            Maquina::whereYear('created_at', date('Y'))->whereMonth('created_at', date('3'))->count(),
            Maquina::whereYear('created_at', date('Y'))->whereMonth('created_at', date('4'))->count(),
            Maquina::whereYear('created_at', date('Y'))->whereMonth('created_at', date('5'))->count(),
            Maquina::whereYear('created_at', date('Y'))->whereMonth('created_at', date('6'))->count(),
            Maquina::whereYear('created_at', date('Y'))->whereMonth('created_at', date('7'))->count(),
            Maquina::whereYear('created_at', date('Y'))->whereMonth('created_at', date('8'))->count(),
            Maquina::whereYear('created_at', date('Y'))->whereMonth('created_at', date('9'))->count(),
            Maquina::whereYear('created_at', date('Y'))->whereMonth('created_at', date('10'))->count(),
            Maquina::whereYear('created_at', date('Y'))->whereMonth('created_at', date('11'))->count(),
            Maquina::whereYear('created_at', date('Y'))->whereMonth('created_at', date('12'))->count(),
        ]);
    }

    public function users()
    {
        if (Auth::user()->isAdmin()) {
            $users = User::orderBy('id')->paginate(10);
            $params = [
                'users' => $users,
                'machinesCount' => $this->getMachinesCount($users),
                'imagesCount' => $this->getInstanceImagesCount($users),
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

    public function getInstanceImagesCount($users)
    {
        $array = [];

        foreach ($users as $user) {
            $array[$user->id] = Container::where('user_id', $user->id)->count();
        }

        return $array;
    }

    private function getInstacesOfEachImage()
    {
        $images = Image::all();

        $array = [];

        foreach ($images as $container) {
            $array[$container->id] = Container::where('image_id', $container->id)->get()->count();
        }

        return $array;
    }

    private function getInstacesCountImages()
    {
        $images = Image::all();

        $array = [];

        foreach ($images as $image) {
            $array[] = Container::where('image_id', $image->id)->get()->count();
        }

        return json_encode($array);
    }

    public function getImagesLabels()
    {
        $array = [];
        foreach (Image::all() as $image) {
            $array[] = $image->name;
        }

        return json_encode($array);
    }
}
