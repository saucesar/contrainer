<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ServiceController extends Controller
{
    public function index()
    {
        $url = env('DOCKER_HOST');
        $services = Http::get("$url/services")->json();

        return view('pages/services/index', ['services' => $services]);
    }

    public function create()
    {
        return view('pages/services/create');
    }

    public function store(Request $request)
    {   
        $request->validate(['serviceName' => 'required|min:5', 'imageName' => 'required']);

        $data = [
            'Name' => $request->serviceName,
            'TaskTemplate' => [
                'ContainerSpec' => [
                    'Image' => $request->imageName,
                    'User' => isset($request->user) ? $request->user : 'user' ,
                    'Args' => explode(' ',$request->args),
                    'Nameservers' => isset($request->dnsNameServers) ? explode(';', $request->dnsNameServers): ['8.8.8.8'],
                    'Search' => [ $request->dnsSearch],
                    'Options' => [ $request->dnsOptions],
                    'TTY' => true,
                    'OpenStdin' => true,
                ],
                'Resources' => [
                    'Limits' => [
                        'MemoryBytes' => 104857600,//equivale a 100MB
                    ],
                ],
                'RestartPolicy' => [
                    "Condition" => "any",
                    "Delay" => 50000000000,
                    "MaxAttempts" => 0,
                ]
            ],
            'Mode' => [
                'Replicated' => [
                    'Replicas' => 2,
                ],
            ],
            'UpdateConfig' => [
                'Parallelism' => 1,
                'FailureAction' => 'pause',
                'Monitor' => 5000000000,
                'MaxFailureRatio' => 0,
                "Order" => "stop-first",
            ],
            'EndpointSpec' => [
                'Ports' => $this->getPorts($request->ports),
            ],
            'Labels' => $this->getLabels($request->labels),
        ];

        $url = env('DOCKER_HOST');
        $createService = Http::asJson()->post("$url/services/create", $data);

        if($createService->getStatusCode() == 201) {
            return redirect()->route('services.index')->with('success', 'Service has be created!');
        } else {
            dd($createService->json());
        }
    }

    private function getPorts($ports)
    {
        $array = [];
        if(isset($ports)){
            foreach(explode(';', $ports) as $port){
                $portData = explode(',', $port);
                $array[] = [
                    'Protocol' => $portData[0],
                    'PublishedPort' => intval($portData[1]),
                    'TargetPort' => intval($portData[2]),
                ];
            }
        }

        return count($array) > 0 ? $array : null;
    }

    private function getLabels($labels)
    {
        $array = [];
        if(isset($label)){
            foreach(explode(';', $labels) as $label){
                $labelData = explode(':', $label);
                $array[$labelData[0]] = $labelData[1];
            }
        }
        
        return count($array) > 0 ? $array : null;
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        $url = env('DOCKER_HOST');
        $deleteService = Http::delete("$url/services/$id");
        
        if($deleteService->getStatusCode() == 200){
            return redirect()->route('services.index');
        } else {
            dd($deleteService->json());
        }
    }
}
