<?php

namespace App\Http\Controllers\Planet;

use App\Http\Controllers\Controller;
use App\Http\Resources\PlanetResource;
use App\Models\Planet;

class PlanetController extends Controller
{
    public function index()
    {
        return PlanetResource::collection(Planet::all());
    }

    public function show(Planet $planet)
    {
        return new PlanetResource(Planet::findOrFail($planet->id));
    }
}
