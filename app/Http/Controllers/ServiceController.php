<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ServiceController extends Controller
{
    public function index()
    {
        $url = env('DOCKER_HOST');
        $services = Http::get("$url/services");
        $params = [
            'services' => $services->getStatusCode() == 200 ? $services->json() : [],
            'error' => $services->getStatusCode() != 200 ? $services->json()['message'] : null,
        ];

        return view('pages/services/index', $params);
    }

    public function create()
    {
        return view('pages/services/create');
    }

    public function store(Request $request)
    {   
        $request->validate(['serviceName' => 'required|min:5', 'imageName' => 'required']);

        $url = env('DOCKER_HOST');
        $createService = Http::asJson()->post("$url/services/create", $this->getParams($request));

        if($createService->getStatusCode() == 201) {
            return redirect()->route('services.index')->with('success', 'Service has be created!');
        } else {
            dd($createService->json());
        }
    }

    private function getParams($request)
    {
        $data = [
            'Name' => $request->serviceName,
            'TaskTemplate' => [
                'ContainerSpec' => [
                    'Image' => $request->imageName,
                    'Env' => isset($request->env) ? explode(';', $request->env) : [],
                    'DNSConfig' => [
                        'Nameservers' => isset($request->dnsNameServers) ? explode(';', $request->dnsNameServers) : ['8.8.8.8', '1.1.1.1'],
                        'Search' => isset($request->dnsSearch) ? explode(';', $request->dnsSearch) : [],
                        'Options' => isset($request->dnsOptions) ? $request->dnsOptions : ["timeout:3"],
                    ],
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
                ],
                'ForceUpdate' => 0,
                'Runtime' => 'container',
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
                'Ports' => [
                    [
                        'Protocol' => $request->portProtocol,
                        'PublishedPort' => intval($request->publishedPort),
                        'TargetPort' => intval($request->targetPort)
                    ],
                ],
            ],
            'Labels' => $this->getLabels($request->labels),
        ];

        return $data;
    }

    private function getLabels($labels)
    {
        $array = [];

        if(isset($labels)){
            $labelsArray = explode(';', $labels);
            array_pop($labelsArray);

            foreach($labelsArray as $label){
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
        $url = env('DOCKER_HOST');
        $service = Http::get("$url/services/$id");
        
        if($service->getStatusCode() == 200){
            $ports = [];
            if(isset($service->json()['Endpoint']['Ports'])){
                foreach($service->json()['Endpoint']['Ports'] as $port){
                    $ports[] = $port['Protocol'].','.$port['PublishedPort'].','.$port['TargetPort'];
                }
                return view('pages/services/edit', [ 'service' => $service->json(), 'ports' => implode(';', $ports)]);
            } else {
                return view('pages/services/edit', [ 'service' => $service->json()]);
            }
        } else {
            dd($service->json());
        }
    }

    public function update(Request $request, $id)
    {
        $request->validate(['serviceName' => 'required|min:5', 'imageName' => 'required']);
        
        $url = env('DOCKER_HOST');
        $service = Http::get("$url/services/$id");
        $version = null;
        if($service->getStatusCode() == 200){
            $version = $service->json()['Version']['Index'];
            $name = $service->json()['Spec']['Name'];
        } else {
            dd($service->json());
        }
        
        $createService = Http::asJson()->post("$url/services/$id/update?version=$version", $this->getParams($request));

        if($createService->getStatusCode() == 200) {
            return redirect()->route('services.index')->with('success', "The Service $name has be updated!");
        } else {
            dd($createService->json());
        }
    }

    public function destroy($id)
    {
        $url = env('DOCKER_HOST');
        $deleteService = Http::delete("$url/services/$id");
        
        if($deleteService->getStatusCode() == 200){
            return redirect()->route('services.index')->with('success', 'Service has been deleted!');
        } else {
            dd($deleteService->json());
        }
    }
}
