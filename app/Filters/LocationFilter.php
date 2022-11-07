<?php

// LocationFilter.php

namespace App\Filters;

class LocationFilter
{
    public function filter($builder, $value)
    {

        $values = explode(",",$value);
        return $builder->whereHas("location",function($query) use($values){
            $query->selectRaw("ST_Distance_Sphere(
                Point($values[1], $values[0]),
                Point(lon, lat)
            ) * ? as distance", [1000])
            ->whereRaw("ST_Distance_Sphere(
                Point($values[1], $values[0]),
                Point(lon, lat)
             ) <  ? ", $values[2]);
        });
    }
}
