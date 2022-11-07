<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class MaterialResource extends JsonResource
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
            'id'=> $this->id,
            'name'=> $this->name,
            //'name_nl' => $this->name_nl,
            //'name_en' => $this->name_en,
            //'name_fr' => $this->name_fr,
            //'submaterials'=> SubMaterialResource::collection($this->whenLoaded('submaterial'))
        ];
    }
}
