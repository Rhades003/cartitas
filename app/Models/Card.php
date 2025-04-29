<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Card extends Model
{
    protected $fillable = [
        'title', 'mana_cost', 'type', 'pasive', 'stats', 'img',
        'title_2', 'mana_cost_2', 'type_2', 'pasive_2', 'stats_2', 'doble'
    ];

    public function offers()
    {
        return $this->belongsToMany(Offer::class, 'cards_offers', "id_card", "id_offer");
    }

    public function decks()
    {
        return $this->belongsToMany(Deck::class, 'decks_cards');
    }
}