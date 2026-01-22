<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;

class Request extends Model
{
    use HasUlids;
    protected $table = 'request';

    protected $fillable = [
        'client_id',
        'total_price',
        'description',
        'height',
        'width',
        'unit',
        'quantity',
        'order_type',
        'deadline',
        'service_id',
        'status',
    ];

    public function client()
    {
        return $this->belongsTo(ClientProfile::class, 'client_id');
    }

    public function service()
    {
        return $this->belongsTo(Service::class, 'service_id');
    }

    public function images()
    {
        return $this->hasMany(RequestImage::class, 'request_id', 'id');
    }

    public function commissions()
    {
        return $this->hasMany(Commission::class, 'request_id');
    }

    public function payment()
    {
        return $this->hasOne(Payment::class, 'request_id');
    }

    public function payout()
    {
        return $this->hasOneThrough(Payout::class, Payment::class, 'request_id', 'payment_id', 'id', 'id');
    }
}
