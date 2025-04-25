<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Offer extends Model
{
    protected $fillable = ['expansion', 'seller', 'quality', 'price', 'quantity', 'BCN'];

    public function cards()
    {
        return $this->belongsToMany(Card::class, 'cards_offers');
    }
}