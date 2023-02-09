<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PlanetResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'diameter' => $this->diameter,
            'climate' => $this->climate,
            'gravity' => $this->gravity,
            'terrain' => $this->terrain,
            'surface_water' => $this->surface_water,
            'population' => $this->population,
            'orbital_period' => $this->orbital_period,
            'rotation_period' => $this->rotation_period,
            'url' => $this->url,
        ];
    }
}
