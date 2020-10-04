<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Image;
use App\Models\Maquina;
use App\Models\Container;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;

class ContainersController extends Controller
{
    public function playStop($container_id)
    {
        $instancia = Container::where('docker_id', $container_id)->first();
        $url = env('DOCKER_HOST');

        if ($instancia->dataHora_finalizado) {
            $host = "$url/containers/$container_id/start";
            $dataHora_fim = null;
        } else {
            $host = "$url/containers/$container_id/stop";
            $dataHora_fim = now();
        }

        try {
            $response = Http::post($host);

            $instancia->dataHora_finalizado = $dataHora_fim;
            $instancia->save();
            
            $message = isset($dataHora_fim) ? 'Container has be stoped!' : 'Container has be started!';

            if($response->getStatusCode() == 204 || $response->getStatusCode() == 304){
                return back()->with('success', $message);
            } else {
                return back()->with('error', $response->json()['message']);
            }
        } catch (Exception $e) {
            return back()->with('error', "Fail to stop the container! $e");
        }
    }

    public function index()
    {
        $user = Auth::user();
        if(!isset($user)){
            return redirect()->route('login');
        }
        $containers = Container::where('user_id', Auth::user()->id)->paginate(10);
        $this->checkActiveStatus($containers);

        $params = [
            'mycontainers' => $containers,
            'dockerHost' => env('DOCKER_HOST'),
            'title' => 'My Containers',
            'images' => Image::all(),
        ];

        return view('pages/my-containers/my_containers', $params);
    }

    private function checkActiveStatus($containers)
    {
        $url = env('DOCKER_HOST');

        foreach($containers as $container){
            $details = Http::get("$url/containers/$container->docker_id/json");

            $container->dataHora_finalizado = $details->getStatusCode() == 200 && $details->json()['State']['Running'] ? null : now();
            $container->save();
        }
    }

    public function terminalNewTab($id)
    {
        $container = Container::firstWhere('docker_id', $id);

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
        $processes = Http::get("$url/containers/$id/top");
        $details = Http::get("$url/containers/$id/json");

        $params = [
            'mycontainer' => Container::firstWhere('docker_id', $id),
            'processes' => ($processes->getStatusCode() == 200 ? $processes->json() : []),
            'details' => $details->getStatusCode() == 200 ? $details->json() : [],
        ];

        return view('pages/my-containers/my_containers_details', $params);
    }

    public function configureContainer(Request $request)
    {
        $params = [
            'image' => Image::firstWhere('id', $request->image_id),
            'user' => Auth::user()->name,
            'user_id' => Auth::user()->id,
        ];

        return view('pages/my-containers/containers_config', $params);
    }

    public function store(Request $request)
    {
        try{
            $request->validate([
                'nickname' => 'required|min:5|unique:containers',
                'IPAddress' => 'nullable|ipv4',
                'IPPrefixLen' => 'nullable|ipv4',
            ]);
            
            $url = env('DOCKER_HOST');
                
            $data = $this->setDefaultDockerParams($request->all());
            $this->pullImage($url, Image::find($data['image_id']));
            $this->createContainer($url, $data);

            return redirect()->route('containers.index')->with('success', 'Container creation is running!');
        } catch(Exception $e){
            return redirect()->route('containers.index')->with('error', $e->getMessage())->withInput();
        }
    }

    public function edit($id)
    {
        return view('pages/my-containers/my_containers_edit', ['container' => Container::firstWhere('docker_id', $id)]);
    }

    public function update(Request $request, $id)
    {
        if ($request->nickname) {
            $instancia = Container::firstWhere('docker_id', $id);
            $instancia->update($request->all());

            return redirect()->route('containers.index')->with('success', 'Container updated!!!');
        } else {
            return redirect()->route('containers.index')->with('error', "Nickname can't be blank!!!");
        }
    }

    public function destroy($id)
    {
        $url = env('DOCKER_HOST');
        $responseDelete = Http::delete("$url/containers/$id?force=1");
        if($responseDelete->getStatusCode() == 204 || $responseDelete->getStatusCode() == 404) {
            $instancia = Container::firstWhere('docker_id', $id);
            isset($instancia) ? $instancia->delete() : '';

            return back()->with('success', 'Container deleted with sucess!');
        } else {
            return back()->with('error', $responseDelete->json()['message']);
        }
    }

    private function setDefaultDockerParams(array $data)
    {
        $template = json_decode(DB::table('default_templates')->where('name', 'container')->first()->template, true);
        $template['nickname'] = $data['nickname'];
        $template['Hostname'] = $data['nickname'];
        $template['image_id'] = $data['image_id'];
        $template['Image'] = Image::find($data['image_id'])->fromImage;
        $template['user_id'] = Auth::user()->id;

        $template['Env'] = $data['envVariables'] ? explode(';', $data['envVariables']) : [];
        array_pop($template['Env']);// Para remover string vazia no ultimo item do array, evitando erro na criação do container.
        $template['HostConfig']['NetworkMode'] = $data['NetworkMode'];
        $template['HostConfig']['Memory'] = $data['Memory'] ? intval($data['Memory']) : 0;
        $template['HostConfig']['PublishAllPorts'] = isset($data['external-port']);
        
        return $template;
    }

    private function pullImage($url, Image $image)
    {
        $uri = "images/create?fromImage=$image->fromImage&tag=$image->tag";
        $image->fromSrc ? $uri .= "&fromSrc=$image->fromSrc" : $uri;
        $image->repo ? $uri .= "&repo=$image->repo" : $uri;
        $image->message ? $uri .= "&message=$image->message" : $uri;

        $response = Http::post("$url/$uri");

        if ($response->getStatusCode() != 200) {
            dd($response->json());
        }
    }

    private function createContainer($url, $data)
    {
        $response = Http::asJson()->post("$url/containers/create", $data);

        if ($response->getStatusCode() == 201) {
            $container_id = $response->json()['Id'];
            $response = Http::asJson()->post("$url/containers/$container_id/start");

            $data['hashcode_maquina'] = Maquina::first()->hashcode;
            $data['docker_id'] = $container_id;
            $data['dataHora_instanciado'] = now();
            $data['dataHora_finalizado'] = $response->getStatusCode() == 204 ? null : now();

            Container::create($data);
        } else {
            dd($response->json());
        }
    }
}