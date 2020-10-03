<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SettingsController extends Controller
{
    public function index()
    {
        $serv = DB::table('default_templates')->where('name', 'service')->first()->template;
        $cont = DB::table('default_templates')->where('name', 'container')->first()->template;
        $cont_decode = json_decode($cont, true);
        $serv_decode = json_decode($serv, true);

        $params = [
            'service_template' => $serv_decode,
            'container_template' => $cont_decode,
            'service_template_json' => $serv,
            'container_template_json' => $cont,
            'cont_labels' => $this->toStringLabels($cont_decode['Labels']),
            'serv_labels' => $this->toStringLabels($serv_decode['Labels']),
        ];

        return view('pages/settings/index', $params);
    }

    private function toStringLabels($array)
    {
        $labels = '';
        
        foreach(array_keys($array) as $key){
            $labels = $labels.$key.':'.$array[$key].';';
        }
        return $labels;
    }

    public function phpinfo()
    {
        return view('pages/settings/phpinfo');
    }

    public function updateServiceTemplate(Request $request)
    {
        $service_template = json_decode(DB::table('default_templates')->where('name', 'service')->first()->template, true);
        
        $service_template['TaskTemplate']['ContainerSpec']['DNSConfig']['Nameservers'] = explode(';', $request->dnsNameservers);
        $service_template['TaskTemplate']['ContainerSpec']['TTY'] = isset($request->tty);
        $service_template['TaskTemplate']['ContainerSpec']['OpenStdin'] = isset($request->openStdin);
        $service_template['TaskTemplate']['Resources']['Limits']['MemoryBytes'] = $request->memoryBytes * 1024 * 1024;
        $service_template['TaskTemplate']['RestartPolicy']['Condition'] = $request->restartCondition;
        $service_template['TaskTemplate']['RestartPolicy']['Delay'] = intval($request->restartDelay);
        $service_template['TaskTemplate']['RestartPolicy']['MaxAttempts'] = intval($request->restartMax);
        $service_template['Mode']['Replicated']['Replicas'] = intval($request->replicas);
        $service_template['UpdateConfig']['FailureAction'] = $request->failureAction;
        $service_template['UpdateConfig']['Monitor'] = intval($request->updateMonitor);
        $service_template['UpdateConfig']['MaxFailureRatio'] = intval($request->maxFailureRatio);
        $service_template['UpdateConfig']['Order'] = $request->updateOrder;

        DB::table('default_templates')->where('name', 'service')->update(['template' => json_encode($service_template)]);

        return back()->with('success', 'Service Template Updated!');
    }

    public function updateContainerTemplate(Request $request)
    {
        $request->validate($this->rules());

        $container_template = json_decode(DB::table('default_templates')->where('name', 'container')->first()->template, true);

        $container_template['Domainname'] = str_replace(' ', '', $request->Domainname);
        $container_template['Labels'] = $this->labelsToArray($request->Labels);
        $container_template['Dns'] = $this->removeBlanck(explode(';', $request->dns));
        $container_template['DnsOptions'] = $this->removeBlanck(explode(';', $request->dnsOptions));
        $container_template['IPAddress'] = $request->IPAddress;
        $container_template['IPPrefixLen'] = intval($request->IPPrefixLen);
        $container_template['MacAddress'] = $request->MacAddress;
        $container_template['Memory'] = $request->Memory;
        $container_template['Env'] = $this->removeBlanck(explode(';', $request->env));
        $container_template['AttachStdin'] = isset($request->AttachStdin);
        $container_template['AttachStdout'] = isset($request->AttachStdout);
        $container_template['AttachStderr'] = isset($request->AttachStderr);
        $container_template['OpenStdin'] = isset($request->OpenStdin);
        $container_template['StdinOnce'] = isset($request->StdinOnce);
        $container_template['Tty'] = isset($request->Tty);
        $container_template['HostConfig']['PublishAllPorts'] = isset($request->PublishAllPorts);
        $container_template['HostConfig']['Privileged'] = isset($request->Privileged);
        $container_template['NetworkMode'] = $request->NetworkMode;
        $container_template['Entrypoint'] = $this->removeBlanck(explode(';', $request->Entrypoint));
        $container_template['HostConfig']['RestartPolicy']['name'] = $request->RestartPolicy;
        $container_template['HostConfig']['Binds'] = $this->removeBlanck(explode(';', $request->Binds));
        $container_template['HostConfig']['NetworkMode'] = $request->NetworkMode;

        DB::table('default_templates')->where('name', 'container')->update(['template' => json_encode($container_template)]);

        return back()->with('success', 'Container Template Updated!');
    }

    private function removeBlanck($array)
    {
        return $array[count($array)-1] == '' ? array_diff($array, ['']) : $array;
    }

    private function labelsToArray($labels)
    {
        $labels_array = [];
        $array = explode(';', $labels);

        foreach($array as $label){
            if($label != ''){
                $temp = explode(':', $label);
                $labels_array[$temp[0]] = $temp[1];
            }
        }

        return $labels_array;
    }

    private function rules()
    {
        return [
            'Domainname' => 'nullable|min:3',
            'IPAddress' => 'nullable|ipv4',
            'IPPrefixLen' => 'numeric',
            'MacAddress' => 'nullable|regex:/^([a-fA-F0-9]{2}:){5}[a-fA-F0-9]{2}$/',
            'Memory' => 'numeric',
            'NetworkMode' => 'in:bridge,host,none',
            'RestartPolicy' => 'nullable|in:always,unless-stopped,on-failure',
        ];
    }
}
