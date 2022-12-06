<?php

// LocationFilter.php

namespace App\Filters;

class LocationsLocationFilter
{
    public function filter($builder, $value)
    {

        $values = explode(",",$value);
        //dd($values);
        return $builder->whereHas("offer",function($query) use($values){
            $query->whereHas("location",function($query) use($values){
                $query->selectRaw("ST_Distance_Sphere(
                    Point($values[1], $values[0]),
                    Point(lon, lat)
                ) * ? as distance", [1000])
                ->whereRaw("ST_Distance_Sphere(
                    Point($values[1], $values[0]),
                    Point(lon, lat)
                 ) <  ? ", $values[2]);
            });
        });
    }
}
