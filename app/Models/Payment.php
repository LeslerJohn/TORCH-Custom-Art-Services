<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasUlids;
    protected $fillable = [
        'client_id',
        'commission_id',
        'order_id',
        'amount',
        'payment_method',
        'transaction_id',
        'status',
    ];

    public function client()
    {
        return $this->belongsTo(ClientProfile::class, 'client_id');
    }

    public function commission()
    {
        return $this->belongsTo(Commission::class, 'commission_id');
    }

    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }
}
