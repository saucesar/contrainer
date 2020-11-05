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
        $tasks = Http::get("$url/tasks?desired-state=running");
        $services = Http::get("$url/services");

        $params = [
            'nodes' => $nodes->getStatusCode() == 200 ? $nodes->json() : [],
            'tasks' => $tasks->getStatusCode() == 200 ? $tasks->json() : [],
            'services' => $this->changeId($services),
            'dockerHost' => env('DOCKER_HOST'),
        ];
        
        return view('pages/docker-swarm/nodes', $params);
    }

    public function updateNode(Request $request, $id, $version)
    {
        $url = env('DOCKER_HOST');
        
        $update = Http::asJson()->post("$url/nodes/$id/update?version=$version", $request->except(['_token', '_method']));

        if($update->getStatusCode() == 200){
            return redirect()->back()->with('success', 'Node updated!');
        } else {
            return redirect()->back()->with('error', $update->json()['message']);
        }
    }

    public function destroyNode($id)
    {
        $url = env('DOCKER_HOST');

        $delete = Http::delete("$url/nodes/$id?force=true");

        if($delete->getStatusCode() == 200){
            return redirect()->back()->with('success', 'Node removed!');
        } else {
            return redirect()->back()->with('error', $delete->json()['message']);
        }
    }

    private function changeId($services)
    {
        $array = $services->getStatusCode() == 200 ? $services->json() : [];
        
        foreach($array as $item){
            $array[$item['ID']] = $item;
        }

        return $array;
    }
}
