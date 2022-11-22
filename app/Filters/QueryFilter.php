<?php

// MaterialFilter.php

namespace App\Filters;

class QueryFilter
{
    public function filter($builder, $value)
    {

        return $builder->where("title","LIKE","%{$value}%")
        ->orWhere(function($query) use($value) {
            $query->whereHas("materials",function($query) use($value){
                $query->where("name","LIKE","%{$value}%");
            });
        })
        ->orWhere(function($query) use($value) {
            $query->whereHas("submaterials",function($query) use($value){
                $query->where("name","LIKE","%{$value}%");
            });
        })
        ->orWhere(function($query) use($value) {
            $query->whereHas("tags",function($query) use($value){
                $query->where("name","LIKE","%{$value}%");
            });
        })
        ->orWhere(function($query) use($value) {
            $query->whereHas("location",function($query) use($value){
                $query->where("street","LIKE","%{$value}%")
                      ->orWhere("city","LIKE","%{$value}%")
                      ->orWhere("country","LIKE","%{$value}%");
            });
        });
    }

}
