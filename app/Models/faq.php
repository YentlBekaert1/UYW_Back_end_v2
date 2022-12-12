<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class faq extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'description',
        'title_nl',
        'description_nl',
        'title_fr',
        'description_fr',
        'title_en',
        'description_en',
    ];



}
