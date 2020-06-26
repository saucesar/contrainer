<?php

namespace App\Http\Controllers;

use App\Models\InstanciaContainer;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class MyContainersController extends Controller
{
    public function instanceIndex()
    {
        $params = [
            'mycontainers' => InstanciaContainer::where('user_id', Auth::user()->id)->get(),
            'dockerHost' => env('DOCKER_HOST'),
        ];

        return view('pages/my-containers/my_containers', $params);
    }

    public function terminalNewTab($id)
    {
        $container = InstanciaContainer::firstWhere('docker_id', $id);

        $params = [
            'mycontainer' => $container,
            'socketParams' => json_encode([
                'dockerHost' => env('DOCKER_HOST_WS'),
                'container_id' => $id,
            ]),
        ];

        return view('pages/my-containers/my_containers_terminal_tab', $params);
    }

    public function show($id)
    {
        $url = env('DOCKER_HOST');
        $processesResponse = Http::get("$url/containers/$id/top");
        $detailsResponse = Http::get("$url/containers/$id/json");

        $params = [
            'mycontainer' => InstanciaContainer::firstWhere('docker_id', $id),
            'processes' => $processesResponse->json(),
            'details' => $detailsResponse->json(),
        ];

        return view('pages/my-containers/my_containers_details', $params);
    }
}
