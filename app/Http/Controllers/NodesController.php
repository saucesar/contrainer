<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class NodesController extends Controller
{
    public function index()
    {
        $url = env('DOCKER_HOST');
        $nodes = Http::get("$url/nodes");

        $params = [
            'nodes' => $nodes->getStatusCode() == 200 ? $nodes->json() : [],
        ];

        return view('pages/docker-swarm/nodes', $params);
    }
}
