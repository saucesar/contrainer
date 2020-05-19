<?php

namespace App\Console\Commands;

use App\Console\ContainerCreateThread;
use Illuminate\Console\Command;

class CreateContainer extends Command
{
    protected $signature = 'create:container {imageId}{userId}';

    protected $description = 'Command to create a new instace of container image passed.';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $params = [
            'imageId' => $this->argument('imageId'),
            'userId'  => $this->argument('userId'),
        ];
        
        $thread = new ContainerCreateThread();
        $thread->run($params);
    }
}
