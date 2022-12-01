<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\App;

class SubMaterialResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $locale = App::currentLocale();
        $name = $this->name;
        if($locale == "en"){
            $name = $this->name_en;
        }
        if($locale == "nl"){
            $name = $this->name_nl;
        }
        if($locale == "fr"){
            $name = $this->name_fr;
        }
        
        return [
            'id'=> $this->id,
            'name'=> $name,
            'material_id'=> $this->material_id,
        ];
    }
}
