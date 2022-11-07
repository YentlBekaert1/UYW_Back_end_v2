<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CategoriesResource extends JsonResource
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
            'name_nl' => $this->name_nl,
            'name_en' => $this->name_en,
            'name_fr' => $this->name_fr,
            'description' => $this->description,
            'description_nl' => $this->description_nl,
            'description_en' => $this->description_en,
            'description_fr' => $this->description_fr,
            'category_image' => $this->category_image,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
