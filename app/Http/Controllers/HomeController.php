<?php

namespace App\Http\Controllers;

use App\Models\Maquina;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
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
        return view('dashboard', ['totalTime' => Maquina::totalTimeAllMachines(2), 'isAdmin' => Auth::user()->isAdmin()]);
    }
}
