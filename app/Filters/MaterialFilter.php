<?php

// MaterialFilter.php

namespace App\Filters;

class MaterialFilter
{
    public function filter($builder, $value)
    {
        $values = explode(",", $value);
        return $builder->whereHas("materials",function($query) use($values){

            $query->whereIn('id', $values);

    });
    }

}
