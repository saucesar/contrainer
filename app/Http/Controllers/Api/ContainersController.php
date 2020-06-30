<?php

namespace App\Http\Controllers\Api;

use Exception;
use App\Models\Image;
use App\Models\Maquina;
use App\Models\Container;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

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
            Http::post($host);

            $instancia->dataHora_finalizado = $dataHora_fim;
            $instancia->save();

            return redirect()->route('instance.index')->with('success', 'Container created with sucess!');
        } catch (Exception $e) {
            return redirect()->route('instance.index')->with('error', "Fail to stop the container! $e");
        }
    }

    public function index()
    {
        $params = [
            'mycontainers' => Container::where('user_id', Auth::user()->id)->paginate(10),
            'dockerHost' => env('DOCKER_HOST'),
            'title' => 'My Containers',
        ];

        return view('pages/my-containers/my_containers', $params);
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
        $processesResponse = Http::get("$url/containers/$id/top");
        $detailsResponse = Http::get("$url/containers/$id/json");

        $params = [
            'mycontainer' => Container::firstWhere('docker_id', $id),
            'processes' => $processesResponse->json(),
            'details' => $detailsResponse->json(),
        ];

        return view('pages/my-containers/my_containers_details', $params);
    }

    public function store(Request $request)
    {
        try {
            $url = env('DOCKER_HOST');
            $data = $this->setDefaultDockerParams($request->all());
            $this->pullImage($url, Image::find($data['image_id']));
            $this->createContainer($url, $data);

            return redirect()->route('instance.index')->with('success', 'Container creation is running!');
        } catch (Exception $e) {
            return  $e->getMessage();
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

        $responseStop = Http::post("$url/containers/$id/stop");
        if ($responseStop->getStatusCode() == 204 || $responseStop->getStatusCode() == 304) {
            $responseDelete = Http::delete("$url/containers/$id");
            if ($responseDelete->getStatusCode() == 204) {
                $instancia = Container::firstWhere('docker_id', $id);
                $instancia->delete();

                return redirect()->route('instance.index')->with('success', 'Container deleted with sucess!');
            } else {
                dd($responseDelete->json());

                return redirect()->route('instance.index')->with('error', 'Fail, Container not delete!');
            }
        } else {
            dd($responseStop->json());
        }
    }

    private function setDefaultDockerParams(array $data)
    {
        $data['Image'] = Image::find($data['image_id'])->fromImage;
        $data['Memory'] = $data['Memory'] ? intval($data['Memory']) : 0;

        $data['Env'] = $data['envVariables'] ? explode(';', $data['envVariables']) : [];
        array_pop($data['Env']); // Para remover string vazia no ultimo item do array, evitando erro na criação do container.

        $data['AttachStdin'] = true;
        $data['AttachStdout'] = true;
        $data['AttachStderr'] = true;
        $data['OpenStdin'] = true;
        $data['StdinOnce'] = false;
        $data['Tty'] = true;

        $data['Entrypoint'] = [
            '/bin/bash',
        ];

        $data['HostConfig'] = [
            'PublishAllPorts' => true,
            'Privileged' => true,
            'RestartPolicy' => [
                'name' => 'always',
            ],
            'Binds' => [
                '/var/run/docker.sock:/var/run/docker.sock',
                '/tmp:/tmp',
             ],
        ];

        return $data;
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

    private function validar(Request $request)
    {
        $this->validate($request, Container::$rules);
    }
}
