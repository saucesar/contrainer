<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class DockerSwarmController extends Controller
{
    public function index()
    {
        $url = env('DOCKER_HOST');
        $swarm = Http::get("$url/swarm");
        $nodes = Http::get("$url/nodes");

        $params = [
            'swarm' => $swarm->getStatusCode() == 200 ? $swarm->json() : null,
            'nodes' => $nodes->getStatusCode() == 200 ? $nodes->json() : null,
            'manager' => $this->getSwarmManager($nodes),
            'error' => $swarm->getStatusCode() != 200 ? ($swarm->json())['message'] : null,
        ];
        
        return view('pages/docker-swarm/index', $params);
    }

    private function getSwarmManager($nodesJson){
        $nodes = $nodesJson->getStatusCode() == 200 ? $nodesJson->json() : null;
        if(!isset($nodes)){ return null; }
        foreach($nodes as $node){
            if($node['Spec']['Role'] == 'manager' && $node['Spec']['Availability'] == 'active') {
                return $node;
            }
        }
        return null;
    }

    public function swarmInit(Request $request)
    {
        $ip = $request->ip ? $request->ip : 'eth0';

        $params = [
            "ListenAddr" => "0.0.0.0:2377",
            "AdvertiseAddr" => "$ip:2377",
            "DataPathPort" => 4789,
            "DefaultAddrPool" => [
                "10.10.0.0/8",
                "20.20.0.0/8"
            ],
            "SubnetSize" => 24,
            "ForceNewCluster" => false,
        ];
        $url = env('DOCKER_HOST');
        
        $swarmInit = Http::asJson()->post("$url/swarm/init", $params);
        
        if($swarmInit->getStatusCode() == 200) {
            return redirect()->route('docker-swarm.index')->with('success', 'Swarm is Created!');
        } else {
            return redirect()->route('docker-swarm.index')->with('error', ($swarmInit->json())['message']);
        }
    }

    
    public function swarmLeave(Request $request)
    {
        $url = env('DOCKER_HOST');
        
        $swarmLeave = Http::post("$url/swarm/leave?force=1");

        if($swarmLeave->getStatusCode() == 200) {
            return redirect()->route('docker-swarm.index')->with('success', 'You left the swarm!');
        } else {
            return redirect()->route('docker-swarm.index')->with('error', ($swarmLeave->json())['message']);
        }
    }
}
