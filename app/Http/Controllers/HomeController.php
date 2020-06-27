<?php

namespace App\Http\Controllers;

use App\Models\Container;
use App\Models\Maquina;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $params = [
            'machines' => Maquina::where('user_id', Auth::user()->id)->get(),
            'containers' => Container::where('user_id', Auth::user()->id)->get(),
            'isAdmin' => Auth::user()->isAdmin(),
        ];
        //dd($params['containers']);

        return view('dashboard', $params);
    }
}
