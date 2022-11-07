<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Material extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'name_nl',
        'name_en',
        'name_fr'

    ];

    public function submaterial()
    {
      return $this->hasMany(SubMaterial::class,"material_id");
    }

    public function offers()
    {
        return $this->belongsToMany(Offers::class, 'materials_offers_pivot', 'materials_id', 'offers_id');
    }
}
