<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SettingsController extends Controller
{
    public function index()
    {
        $params = [
            'service_template' => json_decode(DB::table('default_templates')->where('name', 'service')->first()->template, true),
        ];

        return view('pages/settings/index', $params);
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
}
