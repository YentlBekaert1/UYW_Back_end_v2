<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'name_nl',
        'name_en',
        'name_fr'
    ];

    public function offers()
    {
        return $this->belongsToMany(Offers::class, 'tags_offers_pivot', 'tag_id', 'offers_id');
    }
}
