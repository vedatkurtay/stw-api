<?php

namespace Tests\Feature;

use App\Http\Controllers\People\PeopleController;
use App\Http\Controllers\Planet\PlanetController;
use App\Http\Controllers\Vehicle\VehicleController;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RouteTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test routes
     *
     * @return void
     */
    public function testRoutes()
    {
        // Create a user
        $user = User::factory()->create();
        $this->actingAs($user, 'sanctum')
        ->getJson('/api/user')
        ->assertOk();

        $routes = [
            ['prefix' => 'people', 'controller' => PeopleController::class],
            ['prefix' => 'planet', 'controller' => PlanetController::class],
            ['prefix' => 'vehicle', 'controller' => VehicleController::class],
        ];

        foreach ($routes as $route) {
            $prefix = $route['prefix'];
            $controller = $route['controller'];

            // Test index route
            $response = $this->get("/api/$prefix");
            $response->assertStatus(200);

            // Test show route with a valid id
            $response = $this->get("/api/$prefix/1");
            $response->assertStatus(200);

            // Test show route with an invalid id
            $response = $this->get("/api/$prefix/1000");
            $response->assertStatus(404);
        }
    }
}
