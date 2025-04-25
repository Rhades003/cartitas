<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens; 


class User extends Authenticatable
{
    use Notifiable;
    use HasApiTokens;
   

    protected $fillable = ['name', 'email', 'password', 'admin'];
    protected $hidden = ['password', 'remember_token'];
    protected $casts = ['admin' => 'boolean'];

    public function decks()
    {
        return $this->hasMany(Deck::class);
    }
}
