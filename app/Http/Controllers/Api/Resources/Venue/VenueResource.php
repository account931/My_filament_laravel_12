<?php

namespace App\Http\Controllers\Api\Resources\Venue;

// use Illuminate\Http\Resources\Json\ResourceCollection;
use App\Http\Controllers\Api\Resources\Equipment\EquipmentResource;
use App\Models\Venue;
use Illuminate\Http\Resources\Json\JsonResource;

class VenueResource extends JsonResource
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
            'venue_name' => $this->venue_name,
            'address' => $this->address,
            'location' => $this->location,  // type "Point, uses getter getLocationAttribute in model/Venue to return array of coordinates
            'active' => $this->active,
            'equipments' => EquipmentResource::collection($this->equipments), // add many to Many relation ($this->equipments)
            'status' => 'success',
        ];
    }
}
