<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Maquina;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\UserRequest;

class UserController extends Controller
{
    public function machines()
    {
        $user = Auth::user();
        $machines = Maquina::where('user_id', $user->id)->orderby('id')->paginate(5);

        return view('pages.user.user_machines', ['machines' => $machines, 'user_name' => $user->name]);
    }

    public function index(User $model)
    {
        return view('users.index', ['users' => $model->paginate(15)]);
    }

    public function create()
    {
        return view('users.create');
    }

    public function store(UserRequest $request)
    {
        $this->validate($request, $request->rules());

        $user = User::create($request->all());

        return view('users.login');
    }

    public function show($id)
    {
        return view('users.show', ['user' => User::where('id', $id)->first()]);
    }

    public function edit($id)
    {
        return view('users.edit', ['user' => User::where('id', $id)->first()]);
    }

    public function update(UserRequest $request, $id)
    {
        $this->validate($request, $request->rules());

        $user = User::firstWhere('id', $id);
        $result = $user->update($request->all());

        if ($result) {
            return redirect()->route('home.index');
        } else {
            return redirect()->back()->withInput();
        }
    }

    public function destroy($id)
    {
        $user = User::firstWhere('id', $id);
        $result = $user->delete();

        if ($result) {
            return redirect()->route('home.index');
        } else {
            return redirect()->back();
        }
    }
}
