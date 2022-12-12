<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class FaqResource extends JsonResource
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
            'title' => $this->title,
            'description' => $this->description,
            'title_nl' => $this->title_nl,
            'description_nl' => $this->description_nl,
            'title_en' => $this->title_en,
            'description_en' => $this->description_en,
            'title_fr' => $this->title_fr,
            'description_fr' => $this->description_fr,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
