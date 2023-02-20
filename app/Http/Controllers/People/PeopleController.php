<?php

namespace App\Http\Controllers\People;

use App\Http\Controllers\Controller;
use App\Http\Resources\PersonResource;
use App\Models\People;

class PeopleController extends Controller
{
    public function index()
    {
        return PersonResource::collection(People::all());
    }

    public function show(People $people)
    {
        return new PersonResource(People::findOrFail($people->id));
    }
}
