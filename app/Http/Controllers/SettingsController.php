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
        dd($request->all());
    }
}
