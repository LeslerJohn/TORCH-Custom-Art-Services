<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;

class ArtistPayment extends Model
{
    use HasUlids;
    protected $table = 'artist_payment';
    protected $fillable = [
        'artist_id',
        'payment_method',
        'account_number',
        'account_name',
    ];

    public function artist()
    {
        return $this->belongsTo(ArtistProfile::class, 'artist_id');
    }
}
