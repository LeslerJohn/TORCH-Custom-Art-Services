<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Delivery extends Model
{
    protected $table = 'delivery';
    protected $fillable = [
        'contact_number',
        'address_id',
        'expected_delivery',
        'status',
    ];

    public function address()
    {
        return $this->belongsTo(Address::class, 'address_id');
    }
}
