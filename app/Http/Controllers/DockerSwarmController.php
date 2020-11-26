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
            'swarm' => $swarm->getStatusCode() == 200 ? $swarm->json() : [],
            'manager' => $this->getSwarmManager($nodes),
            'error' => $swarm->getStatusCode() != 200 ? ($swarm->json())['message'] : null,
        ];
        
        return view('pages/docker-swarm/index', $params);
    }

    private function getSwarmManager($nodesJson){
        $nodes = $nodesJson->getStatusCode() == 200 ? $nodesJson->json() : null;
        if(!isset($nodes)){ return null; }
        foreach($nodes as $node){
            $isManager = $node['Spec']['Role'] == 'manager';
            $isActive = $node['Spec']['Availability'] == 'active';
            $isLeader = isset($node['ManagerStatus']['Leader']) && $node['ManagerStatus']['Leader'];

            if($isManager && $isActive && $isLeader) {
                return $node;
            }
        }
        return null;
    }

    public function swarmInit(Request $request)
    {
        $ip = $request->ip;

        $params = [
            "ListenAddr" => "0.0.0.0:2377",
            "AdvertiseAddr" => "$ip:2377",
            "DataPathPort" => 4789,
            /*"DefaultAddrPool" => [
                "10.10.0.0/32",
                "20.20.0.0/32"
            ],*/
            //"SubnetSize" => 32,
            "ForceNewCluster" => true,
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