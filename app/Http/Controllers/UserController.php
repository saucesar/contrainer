<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Requests\UserRequest;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(User $model)
    {
        return view('users.index', ['users' => $model->paginate(15)]);
    }

    public function create()
    {
        return view('users.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => ['required', 'min:3'],
            'email' => ['required', 'email', 'unique:users'],
            'password' => [$this->route()->user ? 'nullable' : 'required', 'confirmed', 'min:6'],
            'phone' => ['required', 'min:11', 'numeric']
        ]);

        $user = User::create($request->all());

        return view('users.login');
    }

    public function show($id)
    {
        return view('users.show', ['user' => User::where('id', $id)->first()]);
    }

    public function edit($id)
    {
        return view('users.edit', ['user' => User::where('id', $id)->first(), 'title' => 'User Profile']);
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => ['required', 'min:3'],
            'email' => ['required', 'email'],
            'phone' => ['required', 'min:11', 'numeric'],
            'category_id' => 'required|numeric',
        ]);

        $user = User::firstWhere('id', $id);
        $result = $user->update($request->all());

        if ($result) {
            return redirect()->back()->with('success', 'User updated!');
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
