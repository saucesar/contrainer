<?php

namespace App\Http\Controllers;

use App\Models\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ImagesController extends Controller
{
    public function index()
    {
        $data = [
            'images' => Image::paginate(10),
            'isAdmin' => Auth::user()->isAdmin(),
            'user_id' => Auth::user()->id,
            'title' => 'Images',
        ];

        return view('pages/images/images', $data);
    }

    public function create()
    {
        return view('pages/images/images_new');
    }

    public function store(Request $request)
    {
        $this->validar($request);

        if (Auth::user()->isAdmin()) {
            Image::create($request->all());

            return redirect()->route('images.index')->with('success', 'Container created!!!');
        } else {
            return redirect()->route('images.index')->with('error', 'User not have permition for this!!!');
        }
    }

    public function edit($id)
    {
        return view('pages/images/images_edit', ['image' => Image::firstWhere('id', $id)]);
    }

    public function update(Request $request, $id)
    {
        $this->validar($request);
        if (Auth::user()->isAdmin()) {
            $container = Image::firstWhere('id', $id);
            $container->update($request->all());
        }

        return redirect()->route('images.index')->with('success', 'Container updated!!!');
    }

    public function destroy($id)
    {
        $container = Image::firstWhere('id', $id);

        $container->delete();

        return redirect()->route('images.index')->with('success', 'Container deleted!!!');
    }

    private function validar(Request $request)
    {
        $this->validate($request, [
            'name' => ['required'],
            'description' => ['required '],
            'fromImage' => ['required '],
            'tag' => ['required '],
        ]);
    }
}
