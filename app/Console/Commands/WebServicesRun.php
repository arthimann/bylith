<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Repositories\WebServiceProvider;

class WebServicesRun extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:web-services-run';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Run web services check manually.';

    /**
     * Execute the console command.
     */
    public function handle(WebServiceProvider $webServiceProvider)
    {
        $this->info($this->description);
        try {
            $this->info('The process is started');
            $webServiceProvider->execute();
            $this->info('The process queued successfully');
        } catch (\Throwable $exception) {
            $this->error('The process is failed');
            $this->error($exception->getMessage());
        }
    }
}
