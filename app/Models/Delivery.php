<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;

class Delivery extends Model
{
    use HasUlids;
    protected $table = 'delivery';
    protected $fillable = [
        'address_id',
        'expected_delivery',
        'status',
    ];

    public function address()
    {
        return $this->belongsTo(Address::class, 'address_id');
    }

    public function proofs()
    {
        return $this->hasMany(ProofOfDelivery::class, 'delivery_id');
    }
}
