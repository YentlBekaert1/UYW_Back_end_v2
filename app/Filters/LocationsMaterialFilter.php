<?php

// MaterialFilter.php

namespace App\Filters;

class LocationsMaterialFilter
{
    public function filter($builder, $value)
    {
        $values = explode(",", $value);
        return $builder->whereHas("offer",function($query) use($values){
            $query->whereHas("materials",function($query) use($values){
                $query->whereIn('id', $values);
            });
        });
    }
}
