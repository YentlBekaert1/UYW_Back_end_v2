<?php

// OfferFilter.php

namespace App\Filters;

use App\Filters\AbstractFilter;
use Illuminate\Database\Eloquent\Builder;

class LocationsFilter extends AbstractFilter
{
    protected $filters = [
        'categories' => LocationsCategoryFilter::class,
        'materials' => LocationsMaterialFilter::class
    ];
}

