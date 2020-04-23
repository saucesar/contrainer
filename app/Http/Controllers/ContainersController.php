<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Container;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\Process\Process;

class ContainersController extends Controller
{
    public function index()
    {
        return view('pages/containers/containers',['containers' => Container::all(), 'isAdmin' => Auth::user()->isAdmin()]);
    }

    public function create()
    {
        return view('pages/containers/containers_new');
    }

    public function store(Request $request)
    {
        $this->validar($request);
        $container = null;

        if( Auth::user()->isAdmin()){
            $container = Container::create($request->all());
        }
        
        if($container) {
            return redirect()->route('containers.index');
        } else {
            return redirect()->back()->withInput();
        }
    }

    public function show($id)
    {
        return view('containers.show',['container' => Container::firstWhere('id', $id)]);
    }

    public function edit($id)
    {
        return view('pages/containers/containers_edit',['container' => Container::firstWhere('id', $id)]);   
    }

    public function update(Request $request, $id)
    {
        $this->validar($request);
        if(Auth::user()->isAdmin()){
            $container = Container::firstWhere('id', $id);
            $container->update($request->all());
        }
        return redirect()->route('containers.index');
    }

    public function destroy($id)
    {
        $container = Container::firstWhere('id', $id);

        $container->delete();
        return redirect()->route('containers.index');
    }

    private function validar(Request $request)
    {
        $this->validate($request, [
            'name' => ['required'],
            'description' => ['required '],
            'command' => ['required'],
        ]);
    }
}
