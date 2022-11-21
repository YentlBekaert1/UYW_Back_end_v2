<?php

// CategoryFilter.php

namespace App\Filters;

class LocationsCategoryFilter
{
    public function filter($builder, $value)
    {
        $values = explode(",", $value);
        return $builder->whereHas("offer",function($query) use($values){
            foreach($values as $val){
                $query->where('categories_id', $val);
            };
        });
    }
}
