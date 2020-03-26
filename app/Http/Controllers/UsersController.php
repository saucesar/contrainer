<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Telefone;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('users.create');
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

        $user = User::create($this->getUserData($request));
        $tel  = Telefone::create($this->getTelefoneData($request, $user));

        return view('users.login');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return view('users.show', ['user' => User::where('id', $id)->first()]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return view('users.edit', ['user' => User::where('id', $id)->first()]);
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

        User::where('id',$id)->update($this->getUserData($request));
        Telefone::where('id', $id)->update($this->getTelefoneData($request));

        return redirect()->route('home.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        User::where('id',$id)->first()->delete();
        return redirect()->route('home.index');
    }

    private function validar(Request $request)
    {
        $this->validate($request, User::$rules, User::$messages);        
        $this->validate($request, Telefone::$rules, Telefone::$messages);        
    }

    private function getUserData(Request $request)
    {   
        return [
            'nome'     => $request->input('nome'),
            'email'    => $request->input('email'),
            'password' => $request->input('password')
        ];
    }

    private function getTelefoneData(Request $request, User $user=null)
    {   
        return [
            'ddi'     => $request->input('ddi'),
            'ddd'     => $request->input('ddd'),
            'numero'  => $request->input('numero'),
            'user_id' => $user->id ?? null,
        ];
    }
}
