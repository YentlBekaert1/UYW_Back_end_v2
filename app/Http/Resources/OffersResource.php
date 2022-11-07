<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OffersResource extends JsonResource
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
            'images'=> OfferImagesResource::collection($this->whenLoaded('images')),
            'location'=> $this->location,
            'tags' => $this->tags,
            'category'=> $this->category,
            'approach'=> $this->approache,
            'materials' => $this->materials,
            'submaterials' => $this->submaterials,
            'url'=> $this->url,
            'status'=> $this->status,
            'contact'=> $this->contact,
            'job'=> $this->job,
            'total_likes' => $this->total_likes,
            'total_views' => $this->total_views,
            'user_id'=> $this->user->id,
            'user_name'=> $this->user->name,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
