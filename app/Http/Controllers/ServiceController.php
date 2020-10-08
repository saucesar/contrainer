<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class ServiceController extends Controller
{
    public function index()
    {
        $url = env('DOCKER_HOST');
        $services = Http::get("$url/services?insertDefaults=true");

        $params = [
            'services' => $services->getStatusCode() == 200 ? $services->json() : [],
            'error' => $services->getStatusCode() != 200 ? $services->json()['message'] : null,
            'user_services' => $this->arraytoValues(Service::where('user_id', Auth::user()->id)->get(['docker_id'])->toArray()),
        ];

        return view('pages/services/index', $params);
    }

    private function arraytoValues($input)
    {
        $array = [];
        foreach($input as $in){
            $array[] = $in['docker_id'];
        }
        return $array;
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
            Service::create([
                'docker_id' => $createService->json()['ID'],
                'user_id' => Auth::user()->id,
                'name' => str_replace(' ', '', $request->serviceName),
                'port' => intval($request->publishedPort),
            ]);
            return redirect()->route('services.index')->with('success', 'Service has be created!');
        } else {
            return back()->withInput()->with('error', $createService->json()['message']);
        }
    }

    private function getParams($request)
    {
        $data = DB::table('default_templates')->where('name', 'service')->first();
        $service_template = json_decode($data->template, true);
        
        $service_template['TaskTemplate']['RestartPolicy']['Condition'] = $request->restartCondition;
        $service_template['TaskTemplate']['RestartPolicy']['Delay'] = intval($request->restartDelay);
        $service_template['TaskTemplate']['RestartPolicy']['MaxAttempts'] = intval($request->restartMax);
        $service_template['TaskTemplate']['ContainerSpec']['Image'] = $request->imageName;
        $service_template['UpdateConfig']['FailureAction'] = $request->failureAction;
        $service_template['UpdateConfig']['Monitor'] = intval($request->updateMonitor);
        $service_template['UpdateConfig']['MaxFailureRatio'] = intval($request->maxFailureRatio);
        $service_template['UpdateConfig']['Order'] = $request->updateOrder;
        $service_template['Name'] = str_replace(' ', '', $request->serviceName);
        $service_template['Env'] = isset($request->env) ? explode(';', $request->env) : [];
        $service_template['EndpointSpec']['Ports'] = [
            [
                'Protocol' => $request->portProtocol,
                'PublishedPort' => intval($request->publishedPort),
                'TargetPort' => intval($request->targetPort)
            ],
        ];

        $service_template['Labels'] = $this->getLabels($request->labels);
        return $service_template;
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
