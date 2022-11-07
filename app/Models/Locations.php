<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
}
