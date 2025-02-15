<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CartItem extends Model
{
    protected $table = 'cart_item';
    protected $fillable = [
        'cart_id',
        'artwork_id'
    ];

    public function cart()
    {
        return $this->belongsTo(Cart::class, 'cart_id');
    }

    public function artwork()
    {
        return $this->belongsTo(Artwork::class, 'artwork_id');
    }
}
