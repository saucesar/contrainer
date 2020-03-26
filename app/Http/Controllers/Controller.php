<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function index()
    {
        return view('home.index');
    }

    public function login()
    {
        return view('users.login', ['title' => 'Login']);
    }

    public function autenticar(Request $request)
    {
        $lembrar = ($request->input('lembrar') == "true");

        if(Auth::attempt(['email' => $request->input('email'), 'password' => $request->input('password')], $lembrar)){
            return view('home.index', ['title' => 'Dashboard']);
        } else{
            return view('users.login', ['message' => 'Login/Senha Invalido(s)!']);
        }
    }
}
