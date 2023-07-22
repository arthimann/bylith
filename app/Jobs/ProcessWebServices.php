<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\WebService;
use Illuminate\Support\Facades\Http;
use App\Repositories\WebServiceProvider;
use Illuminate\Support\Facades\Config;

class ProcessWebServices implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public const ENTITY_ID = 'id';
    public const ENTITY_PATH = 'path';

    public bool $failOnTimeout = false;
    public int $timeout = 0;

    /**
     * Execute the job.
     * @param WebServiceProvider $webServiceProvider
     * @return void
     */
    public function handle(WebServiceProvider $webServiceProvider): void
    {
        $entities = WebService::all();
        foreach ($entities as $entity) {
            try {
                $response = Http::connectTimeout(Config::get('webservices.timeout'))
                    ->retry(Config::get('webservices.retry'))
                    ->get($entity->getAttributeValue(self::ENTITY_PATH));

                if ($response->successful()) {
                    $this->createRecord($entity, $webServiceProvider::SUCCESS_STATUS);
                } else {
                    $this->createRecord($entity, $webServiceProvider::ERROR_STATUS);
                }
            } catch (\Throwable) {
                $this->createRecord($entity, $webServiceProvider::ERROR_STATUS);
            }
        }
    }

    /**
     * Create new record
     * @param $entity
     * @param WebServiceProvider $webServiceProvider
     * @return void
     */
    private function createRecord($entity, WebServiceProvider $webServiceProvider): void
    {
        $entity->history()->create([
            'web_service_id' => $entity->getAttributeValue(self::ENTITY_ID),
            'status_id' => $webServiceProvider::SUCCESS_STATUS,
        ]);
    }
}
