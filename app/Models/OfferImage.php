<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OfferImage extends Model
{
    use HasFactory;

    protected $fillable = [
        'filename',
        'position',
        'offer_id'
      ];

      public function offer()
      {
        return $this->belongsTo(Offers::class);
      }
}
