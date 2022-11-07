<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categories extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'name_nl',
        'name_en',
        'name_fr',
        'description',
        'description_nl',
        'description_en',
        'description_fr',
        'category_image'
    ];

}
