<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasUlids;
    protected $table = 'order';
    protected $fillable = [
        'client_id',
        'total',
        'delivery_id',
        'status'
    ];

    public function client()
    {
        return $this->belongsTo(ClientProfile::class, 'client_id');
    }

    public function delivery()
    {
        return $this->belongsTo(Delivery::class, 'delivery_id');
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class, 'order_id');
    }

    public function reviews()
    {
        return $this->hasMany(OrderReview::class, 'order_id');
    }

    public function refund()
    {
        return $this->hasOne(Refund::class, 'order_id');
    }

    public function payment()
    {
        return $this->hasOne(Payment::class, 'order_id');
    }

    public function payout()
    {
        return $this->hasOneThrough(Payout::class, Payment::class, 'order_id', 'payment_id', 'id', 'id');
    }
}
