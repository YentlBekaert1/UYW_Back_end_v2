<?php

namespace App\Http\Resources;

use App\Models\Offers;
use Illuminate\Http\Resources\Json\JsonResource;

class LocationsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $properties = new OffersLocationResource($this->whenLoaded('offer'));

        $geometry = json_encode(array("type"=>"Point","coordinates"=>[strval($this->lon), strval($this->lat)]));


        return [
            "type" => "Feature",
            "geometry" => json_decode($geometry),
            'properties' => $properties,
            // 'id'=> $this->id,
            // 'lat'=> $this->lat,
            // 'lon' => $this->lon,
            // 'street' => $this->street,
            // 'number' => $this->number,
            // 'postal' => $this->postal,
            // 'city' => $this->city,
            // 'country' => $this->country,

        ];

    }
}
