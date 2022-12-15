<?php

namespace App\Http\Resources;

use App\Models\Offers;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\App;

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
        $linked_offers_array = $this->linked_offers()->with('images','location','materials','submaterials')->get();

        $items_with_same_tag = [];
        foreach( $this->tags as $tag){

            $tags_offers = Offers::whereHas("tags",function($query) use($tag){
                    $query->where("id","=", $tag->id);
            })->where("id", "!=", $this->id)->with('images','location','materials','submaterials')->get();

            if($tags_offers){
                array_push($items_with_same_tag, $tags_offers);
            }
        }

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
            'images'=> $this->images->sortBy('position')->values()->all(),
            'location'=> $this->location,
            'tags' => $this->tags,
            'categories_id'=> $this->category->id,
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
            'linked_offers' => OffersResource::collection($linked_offers_array),
            'offers_with_same_tag' => $items_with_same_tag,
            'user_id'=> $this->user->id,
            'user_name'=> $this->user->name,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
