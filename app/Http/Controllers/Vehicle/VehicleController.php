<?php

namespace App\Http\Controllers\Vehicle;

use App\Http\Controllers\Controller;
use App\Http\Resources\VehicleResource;
use App\Models\Vehicle;
use Illuminate\Http\Request;

class VehicleController extends Controller
{

    public function index()
    {
        return VehicleResource::collection(Vehicle::all());
    }

    public function show($id)
    {
        return new VehicleResource(Vehicle::findOrFail($id));
    }
}
