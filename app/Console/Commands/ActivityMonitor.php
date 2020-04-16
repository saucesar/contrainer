<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\AtividadeMaquina;

class ActivityMonitor extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ActivityMonitor:startMonitoring';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command to monitor machine activity on the network.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $minutes = 1;
        $activities = AtividadeMaquina::where('dataHoraFim', null)->get();

        foreach($activities as $activity){
            $elapsedTime = strtotime(now()) - strtotime($activity->last_notification);
            
            if($elapsedTime > ($minutes*60)){
                $activity->dataHoraFim = now();
                $activity->save();
            }
        }
    }
}
