<?php

namespace App\Http\Controllers\Api\Resources\Owner;

// use Illuminate\Http\Resources\Json\ResourceCollection;
use App\Http\Controllers\Api\Resources\Venue\VenueResource;
use Illuminate\Http\Resources\Json\JsonResource;

class OwnerResource extends JsonResource
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        // return parent::toArray($request);  //working, will return all fields
        return [
            'id' => $this->id,
            'first_name' => $this->resource->getRawOriginal('first_name'),  // Laravel 12  fix//->getOriginal('first_name'), //$this->getOriginal('first_name'), //ignore accessor
            'last_name' => $this->last_name,
            'confirmed' => $this->confirmed,
            'venues' => VenueResource::collection($this->venues), // hasMany relation (it also includes Many to Many relation 'equipments' inside \App\Http\Api\V1\Resources\Venues\VenueResource)
            'status' => 'success',
        ];
    }
}
