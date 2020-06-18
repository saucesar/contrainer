<?php

namespace App\Http\Controllers;

use App\Models\ConsoleOut;
use Illuminate\Http\Request;
use App\Models\Container;
use Illuminate\Support\Facades\Auth;
use App\Models\InstanciaContainer;
use Illuminate\Support\Facades\Http;

class ContainersController extends Controller
{
    public function instanceIndex()
    {
        $params = [
            'mycontainers' => InstanciaContainer::where('user_id', Auth::user()->id)->get(),
            'consoleOuts' => ConsoleOut::where('created_at', '<', now())->orderBy('created_at', 'desc')->take(100)->get(),
            'dockerHost' => env('DOCKER_HOST'),
        ];

        return view('pages/my-containers/my_containers', $params);
    }

    public function index()
    {
        $data = [
            'containers' => Container::all(),
            'isAdmin' => Auth::user()->isAdmin(),
            'user_id' => Auth::user()->id,
        ];

        return view('pages/containers/containers', $data);
    }

    public function create()
    {
        return view('pages/containers/containers_new');
    }

    public function store(Request $request)
    {
        $this->validar($request);
        $container = null;

        if (Auth::user()->isAdmin()) {
            $container = Container::create($request->all());
        }

        return redirect()->route('containers.index')->with('success', 'Container created!!!');
    }

    public function show($id)
    {
        $url = env('DOCKER_HOST');
        $processesResponse = Http::get("$url/containers/$id/top");
        $detailsResponse = Http::get("$url/containers/$id/json");

        $params = [
            'mycontainer' => InstanciaContainer::firstWhere('docker_id', $id),
            'newTab' => false,
            'consoleOuts' => ConsoleOut::where('docker_id', $id)->orderBy('created_at', 'desc')->take(20)->get(),
            'processes' => $processesResponse->json(),
            'details' => $detailsResponse->json(),
        ];
        //dd($params['details']);

        return view('pages/my-containers/my_containers_details', $params);
    }

    public function edit($id)
    {
        return view('pages/containers/containers_edit', ['container' => Container::firstWhere('id', $id)]);
    }

    public function update(Request $request, $id)
    {
        $this->validar($request);
        if (Auth::user()->isAdmin()) {
            $container = Container::firstWhere('id', $id);
            $container->update($request->all());
        }

        return redirect()->route('containers.index')->with('success', 'Container updated!!!');
    }

    public function destroy($id)
    {
        $container = Container::firstWhere('id', $id);

        $container->delete();

        return redirect()->route('containers.index')->with('success', 'Container deleted!!!');
    }

    public function terminalNewTab($id)
    {
        $container = InstanciaContainer::firstWhere('docker_id', $id);
        $outs = ConsoleOut::where('docker_id', $container->docker_id)->orderBy('created_at', 'desc')->take(100)->get();

        return view('pages/my-containers/my_containers_terminal_tab', ['mycontainer' => $container, 'outs' => $outs]);
    }

    public function configureContainer(Request $request)
    {
        $params = [
            'image' => Container::firstWhere('id', $request->image_id),
            'user' => Auth::user()->name,
            'user_id' => Auth::user()->id,
        ];

        return view('pages/containers/containers_config', $params);
    }

    private function validar(Request $request)
    {
        $this->validate($request, [
            'name' => ['required'],
            'description' => ['required '],
            'command_pull' => ['required'],
        ]);
    }
}
