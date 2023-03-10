<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Planet extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'diameter',
        'climate',
        'gravity',
        'terrain',
        'surface_water',
        'population',
        'orbital_period',
        'rotation_period',
        'url',
    ];

    public function people()
    {
        return $this->hasMany(People::class);
    }
}
