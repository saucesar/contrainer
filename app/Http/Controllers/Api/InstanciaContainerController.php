<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ConsoleOut;
use App\Models\InstanciaContainer;
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

    public function execInTerminal(Request $request, $containerId)
    {
        $newTab = ($request->newTab == '1');

        $url = env('DOCKER_HOST');

        $data = [
            'Cmd' => [
                $request->command,
            ],
            'AttachStdin' => true,
            'AttachStdout' => true,
            'AttachStderr' => true,
        ];

        $response = Http::asJson()->post("$url/containers/$containerId/exec", $data);
        $id = $response->json()['Id'];

        $response = Http::asJson()->post("$url/exec/$id/start", ['Detach' => false, 'Tty' => false]);

        dd($response);

        $data = [
            'docker_id' => $containerId,
            'command' => $request->command,
            //'out' => $process->getOutput(),
            //'status' => $process->isSuccessful(),
        ];
        ConsoleOut::create($data);

        if ($newTab) {
            return redirect()->route('container.terminalTab', $containerId)->with('success', 'Command executed with sucess!');
        } else {
            return redirect()->back()->with('success', 'Command executed with sucess!');
        }
    }

    public function store(Request $request)
    {
        try {
            $url = env('DOCKER_HOST');

            $data = $this->setDefaultDockerParams($request->all());
            $this->pullImage($url, $data['Image']);
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
        $response = Http::delete("$url/containers/$id");

        if ($response->getStatusCode() == 204) {
            $instancia = InstanciaContainer::firstWhere('docker_id', $id);
            $instancia->delete();

            return redirect()->route('instance.index')->with('success', 'Container deleted with sucess!');
        } else {
            return redirect()->route('instance.index')->with('error', 'Fail, Container not delete!');
        }
    }

    private function setDefaultDockerParams(array $data)
    {
        $data['RestartPolicy'] = ['name' => 'always'];
        $data['Memory'] = $data['Memory'] ? intval($data['Memory']) : 0;

        $data['Env'] = $data['envVariables'] ? explode(';', $data['envVariables']) : [];
        array_pop($data['Env']); // Para remover string vazia no ultimo item do array, evitando erro na criação do container.

        $data['HostConfig'] = ['PublishAllPorts' => true];

        return $data;
    }

    private function pullImage($url, $image)
    {
        $response = Http::post("$url/images/create?fromImage=$image&tag=latest");

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
            $data['dataHora_finalizado'] = null;

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
