<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\InstanciaContainer;
use App\Models\Container;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\Maquina;

class InstanciaContainerController extends Controller
{
    public function playStop($container_id)
    {
        $instancia = InstanciaContainer::where('docker_id', $container_id)->first();
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

    public function store(Request $request)
    {
        try {
            $url = env('DOCKER_HOST');
            $data = $this->setDefaultDockerParams($request->all());
            $this->pullImage($url, Container::find($data['image_id']));
            $this->createContainer($url, $data);

            return redirect()->route('instance.index')->with('success', 'Container creation is running!');
        } catch (Exception $e) {
            return  $e->getMessage();
        }
    }

    public function edit($id)
    {
        $instancia = InstanciaContainer::firstWhere('id', $id);

        $instancia->dataHora_finalizado = now();
        $instancia->save();

        return redirect()->route('instance.index')->with('success', 'Container created with sucess!');
    }

    public function update(Request $request, $id)
    {
        $this->validar($request);
        $instancia = InstanciaContainer::firstWhere('id', $id);
        $instancia->update($request->all());
    }

    public function destroy($id)
    {
        $url = env('DOCKER_HOST');

        $responseStop = Http::post("$url/containers/$id/stop");
        if ($responseStop->getStatusCode() == 204 || $responseStop->getStatusCode() == 304) {
            $responseDelete = Http::delete("$url/containers/$id");
            if ($responseDelete->getStatusCode() == 204) {
                $instancia = InstanciaContainer::firstWhere('docker_id', $id);
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
        $data['Image'] = Container::find($data['image_id'])->fromImage;
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

    private function pullImage($url, Container $image)
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

            InstanciaContainer::create($data);
        } else {
            dd($response->json());
        }
    }

    private function validar(Request $request)
    {
        $this->validate($request, InstanciaContainer::$rules);
    }
}
