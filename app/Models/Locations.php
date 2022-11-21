<?php

namespace App\Models;

use App\Filters\LocationsFilter;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder as EloquentBuilder;

class Locations extends Model
{
    use HasFactory;

    protected $fillable = [
        'offers_id',
        'lat',
        'lon',
        'street',
        'number',
        'postal',
        'city',
        'country',
    ];

    public function offer()
    {
        return $this->belongsTo(Offers::class,"offers_id");
    }

    public function scopeFilter(EloquentBuilder $builder, $request)
    {
        return (new LocationsFilter($request))->filter($builder);
    }
}
