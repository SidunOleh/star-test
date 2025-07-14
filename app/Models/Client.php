<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Client extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'email',
        'password',
    ];

    protected $casts = [
        'password' => 'hashed',
    ];

    public function cartItems(): HasMany
    {
        return $this->hasMany(CartItem::class);
    }
}
