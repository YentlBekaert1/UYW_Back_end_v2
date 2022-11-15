<?php

// CategoryFilter.php

namespace App\Filters;

class CategoryFilter
{
    public function filter($builder, $value)
    {
        $values = explode(",", $value);
        //dump($value);
        $i = 0;
        foreach($values as $val){
            $builder->where('categories_id', $val);
        };
        return $builder;


    }
}
