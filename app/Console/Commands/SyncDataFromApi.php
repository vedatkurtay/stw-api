<?php

namespace App\Console\Commands;

use App\Models\People;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;
use App\Models\Person;
use App\Models\Planet;
use App\Models\Vehicle;
use Illuminate\Support\Facades\Log;

class SyncDataFromApi extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sync:data-from-api';

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

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        // Sync data from API to database is starting
        $this->info('Sync data from API to database is starting...');

        // get data of people resource
        $currentPage = Http::get('https://swapi.dev/api/people/');
        while ($currentPage) {
            $people = $currentPage->json()['results'];
            // Syncing people information...
            $this->info('Syncing ' . count($people) . ' people...');

            Log::info('People sync is starting...');
            foreach ($people as $person) {
                People::updateOrCreate(
                    ['name' => $person['name']],
                    [
                        'name' => $person['name'],
                        'height' => $person['height'],
                        'mass' => $person['mass'],
                        'hair_color' => $person['hair_color'],
                        'skin_color' => $person['skin_color'],
                        'eye_color' => $person['eye_color'],
                        'birth_year' => $person['birth_year'],
                        'gender' => $person['gender'],
                        'homeworld' => $person['homeworld'],
                    ]
                );
            }
            Log::info('People sync is finished');

            // check if there's a next page of results
            if (!$currentPage->json()['next']) {
                break;
            }
            $currentPage = Http::get($currentPage->json()['next']);
        }

        // get data of planet resource
        $currentPage = Http::get('https://swapi.dev/api/planets/');
        while ($currentPage) {
            $planets = $currentPage->json()['results'];
            // Syncing planet information...
            $this->info('Syncing ' . count($planets) . ' planet...');

            Log::info('Planet sync is starting...');
            foreach ($planets as $planet) {
                Planet::updateOrCreate(
                    ['name' => $planet['name']],
                    [
                        'name' => $planet['name'],
                        'rotation_period' => $planet['rotation_period'],
                        'orbital_period' => $planet['orbital_period'],
                        'diameter' => $planet['diameter'],
                        'climate' => $planet['climate'],
                        'gravity' => $planet['gravity'],
                        'terrain' => $planet['terrain'],
                        'surface_water' => $planet['surface_water'],
                        'population' => $planet['population'],
                        'url' => $planet['url'],
                    ]
                );
            }
            Log::info('Planet sync is finished');

            // check if there's a next page of results
            if (!$currentPage->json()['next']) {
                break;
            }
            $currentPage = Http::get($currentPage->json()['next']);
        }

        // get data of vehicle resource
        $currentPage = Http::get('https://swapi.dev/api/vehicles/');
        while ($currentPage) {
            $vehicles = $currentPage->json()['results'];
            // Syncing vehicle information...
            $this->info('Syncing ' . count($vehicles) . ' vehicle...');

            Log::info('Vehicle sync is starting...');
            foreach ($vehicles as $vehicle) {
                Vehicle::updateOrCreate(
                    ['name' => $vehicle['name']],
                    [
                        'name' => $vehicle['name'],
                        'model' => $vehicle['model'],
                        'manufacturer' => $vehicle['manufacturer'],
                        'cost_in_credits' => $vehicle['cost_in_credits'],
                        'length' => $vehicle['length'],
                        'max_atmosphering_speed' => $vehicle['max_atmosphering_speed'],
                        'crew' => $vehicle['crew'],
                        'passengers' => $vehicle['passengers'],
                        'cargo_capacity' => $vehicle['cargo_capacity'],
                        'consumables' => $vehicle['consumables'],
                        'vehicle_class' => $vehicle['vehicle_class'],
                        'url' => $vehicle['url'],
                    ]
                );
            }
            Log::info('Planet sync is finished');

            // check if there's a next page of results
            if (!$currentPage->json()['next']) {
                break;
            }
            $currentPage = Http::get($currentPage->json()['next']);
        }

        $this->info('Data synchronized successfully!');
    }
}

