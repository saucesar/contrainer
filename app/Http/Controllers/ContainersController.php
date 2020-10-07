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
            'container_template' => json_decode(DB::table('default_templates')->where('name', 'container')->first()->template, true),
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
            $url = env('DOCKER_HOST');
                
            $data = $this->setDefaultDockerParams($request);

            $this->pullImage($url, Image::find($data['image_id']));

            return $this->createContainer($url, $data);
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

    private function setDefaultDockerParams($request)
    {
        $template = json_decode(DB::table('default_templates')->where('name', 'container')->first()->template, true);
        $template['nickname'] = $request->nickname;
        $template['Hostname'] = $request->nickname;
        $template['image_id'] = $request->image_id;
        $template['Image'] = Image::find($request->image_id)->fromImage;
        $template['user_id'] = Auth::user()->id;

        $template['Env'] = $this->extractArray($request->EnvKeys, $request->EnvValues, '=', true);
        $template['HostConfig']['Memory'] = intval($request->Memory);

        $template['Domainname'] = str_replace(' ', '', $request->Domainname);
        $template['Labels'] = $this->extractLabels($request);
        $template['Dns'] = [$request->dns];
        $template['DnsOptions'] = $this->removeNull($request->dnsOptions);
        $template['IPAddress'] = $request->IPAddress;
        $template['IPPrefixLen'] = intval($request->IPPrefixLen);
        $template['Memory'] = intval($request->Memory);
        $template['Env'] = $this->extractArray($request->EnvKeys, $request->EnvValues, '=',true);
        $template['AttachStdin'] = isset($request->AttachStdin);
        $template['AttachStdout'] = isset($request->AttachStdout);
        $template['AttachStderr'] = isset($request->AttachStderr);
        $template['OpenStdin'] = isset($request->OpenStdin);
        $template['StdinOnce'] = isset($request->StdinOnce);
        $template['Tty'] = isset($request->Tty);
        $template['HostConfig']['PublishAllPorts'] = isset($request->PublishAllPorts);
        $template['HostConfig']['Privileged'] = isset($request->Privileged);
        $template['NetworkMode'] = $request->NetworkMode;
        $template['Entrypoint'] = [$request->Entrypoint];
        $template['HostConfig']['RestartPolicy']['name'] = $request->RestartPolicy;
        $template['HostConfig']['Binds'] = $this->extractArray($request->BindSrc, $request->BindDest, ':');
        $template['HostConfig']['NetworkMode'] = $request->NetworkMode;

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
            return redirect()->route('containers.index')->with('success', 'Container creation is running!');
        } else {
            return back()->with('error', $response->json()['message']);
        }
    }

    private function extractArray($keys, $values, $separator = '=', $upper = false)
    {
        $array = [];

        for($i = 0; $i < count($keys); $i++){
            if(isset($keys[$i]) && $values[$i]){
                $val = $keys[$i].$separator.$values[$i];
                $array[] = $upper ? strtoupper($val) : $val;
            }
        }

        return $array;
    }

    private function extractLabels($request)
    {
        $labelKeys = $request->LabelKeys;
        $labelValues = $request->LabelValues;
        
        $labels = [];

        for($i = 0; $i < count($labelKeys); $i++){
            if(isset($labelKeys[$i]) && isset($labelValues[$i])){
                $labels[$labelKeys[$i]] = $labelValues[$i];
            }
        }
        
        return $labels;
    }

    private function removeNull($array, $index = 0)
    {
        unset($array[$index]);
        return $array;
    }
}