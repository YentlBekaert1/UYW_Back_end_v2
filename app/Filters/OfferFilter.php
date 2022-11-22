<?php

// OfferFilter.php

namespace App\Filters;

use App\Filters\AbstractFilter;
use Illuminate\Database\Eloquent\Builder;

class OfferFilter extends AbstractFilter
{
    protected $filters = [
        'materials' => MaterialFilter::class,
        'location' => LocationFilter::class,
        'categories' => CategoryFilter::class,
        'query' => QueryFilter::class,
    ];
}

