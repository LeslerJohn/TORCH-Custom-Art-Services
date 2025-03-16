<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasUlids;
    protected $table = 'cart';
    protected $fillable = [
        'client_id',
    ];

    public function client()
    {
        return $this->belongsTo(ClientProfile::class, 'client_id');
    }

    public function items()
    {
        return $this->hasMany(CartItem::class, 'cart_id');
    }

    public function itemCount()
    {
        return $this->items()
            ->whereHas('artwork', function ($query) {
                $query->where('status', 'sale');
            });
    }
}
