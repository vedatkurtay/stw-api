<?php

namespace App\Console\Commands;

use App\Models\People;
use App\Models\Planet;
use App\Models\Vehicle;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class SynchronizeStarWarsData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sync-star-wars-data';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sync data from Star Wars API to database';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    private const BASE_URL = 'https://swapi.dev/api/';
    private const MODELS = [People::class, Planet::class, Vehicle::class];

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $this->info('Sync data from API to database is starting...');

        foreach (self::MODELS as $model) {
            $resourceName = Str::of($model)->classBasename()->lower()->plural()->value();

            $url = Str::of($model)
                ->classBasename()
                ->lower()
                ->plural()
                ->prepend('/')
                ->prepend(self::BASE_URL)
                ->value();

            $this->syncResourceData($url, $resourceName, $model);
        }

        $this->info('Data synchronized successfully!');

        return 0;
    }

    /**
     * Sync data for a given resource URL.
     */
    private function syncResourceData(string $url, string $resourceName, string $modelClass): void
    {
        $currentPage = Http::get($url);
        $totalSynced = 0;
        while ($currentPage) {
            $results = $currentPage->json()['results'];
            $this->info('Syncing '.count($results)." $resourceName...");

            Log::info("$resourceName sync is starting...");
            foreach ($results as $result) {
                $modelClass::updateOrCreate(
                    ['name' => $result['name']],
                    array_merge($result, ['url' => $result['url']])
                );
            }
            Log::info("$resourceName sync is finished");

            $totalSynced += count($results);

            if (! $currentPage->json()['next']) {
                break;
            }
            $currentPage = Http::get($currentPage->json()['next']);
        }

        $this->info("Synced $totalSynced $resourceName.");
    }
}
