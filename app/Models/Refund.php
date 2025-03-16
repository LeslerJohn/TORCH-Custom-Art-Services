<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;

class Refund extends Model
{
    use HasUlids;
    protected $fillable = [
        'payment_id',
        'commission_id',
        'order_id',
        'client_id',
        'artist_id',
        'amount',
        'reason',
        'refund_method',
        'status',
        'admin_approved',
    ];

    public function payment()
    {
        return $this->belongsTo(Payment::class, 'payment_id');
    }

    public function commission()
    {
        return $this->belongsTo(Commission::class, 'commission_id');
    }

    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }

    public function client()
    {
        return $this->belongsTo(ClientProfile::class, 'client_id');
    }

    public function artist()
    {
        return $this->belongsTo(ArtistProfile::class, 'artist_id');
    }
}
