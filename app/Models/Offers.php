<?php

namespace App\Models;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Filters\OfferFilter;
use Illuminate\Database\Eloquent\Builder as EloquentBuilder;

class Offers extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'description',
        'user_id',
        'categories_id',
        'approaches_id',
        'url',
        'contact',
        'job',
        'status',
        'total_likes',
        'total_views'

    ];

    protected $casts = [
        'description' => 'array'
    ];

    public function getTitleUpperCaseAttribute(){
        return strtoupper($this->title);
    }

    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }

    public function users_favorites()
    {
        return $this->belongsToMany(User::class, 'offers_user_favorites_pivot', 'offers_id', 'user_id');
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'tags_offers_pivot', 'offers_id', 'tag_id');
    }

    public function images()
    {
      return $this->hasMany(OfferImage::class,"offer_id");
    }

    public function location()
    {
      return $this->hasOne(Locations::class,"offers_id");
    }

    public function category()
    {
        return $this->belongsTo(Categories::class,'categories_id');
    }

    public function approache()
    {
        return $this->belongsTo(Approach::class,'approaches_id');
    }

    public function materials()
    {
        return $this->belongsToMany(Material::class, 'materials_offers_pivot', 'offers_id', 'materials_id');
    }

    public function submaterials()
    {
        return $this->belongsToMany(SubMaterial::class, 'sub_materials_offers_pivot', 'offers_id', 'sub_materials_id');
    }

    public function scopeFilter(EloquentBuilder $builder, $request)
    {
        return (new OfferFilter($request))->filter($builder);
    }

}
