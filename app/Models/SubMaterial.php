<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubMaterial extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'name_nl',
        'name_en',
        'name_fr',
        'material_id'
    ];

    public function material()
    {
      return $this->belongsTo(Materials::class);
    }

    public function offers()
    {
        return $this->belongsToMany(Offers::class, 'sub_materials_offers_pivot', 'sub_materials_id', 'offers_id');
    }
}
