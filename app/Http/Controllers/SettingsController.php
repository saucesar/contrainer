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
            'cont_labels' => $this->getLabels($cont_decode['Labels']),
            'serv_labels' => $this->getLabels($serv_decode['Labels']),
        ];

        return view('pages/settings/index', $params);
    }

    private function getLabels($array)
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
        $container_template = json_decode(DB::table('default_templates')->where('name', 'container')->first()->template, true);

        DB::table('default_templates')->where('name', 'container')->update(['template' => json_encode($container_template)]);

        return back()->with('success', 'Container Template Updated!');
    }
}
