<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;

class Payout extends Model
{
    use HasUlids;
    protected $fillable = [
        'artist_id',
        'payment_id',
        'amount',
        'payout_method',
        'status',
        'transaction_id',
    ];

    public function artist()
    {
        return $this->belongsTo(ArtistProfile::class, 'artist_id');
    }

    public function payment()
    {
        return $this->belongsTo(Payment::class, 'payment_id');
    }
}
