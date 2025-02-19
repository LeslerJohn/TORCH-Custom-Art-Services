<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Commission extends Model
{
    protected $table = 'commission';

    protected $fillable = [
        'request_id',
        'delivery_id',
        'deadline',
        'status',
    ];

    public function request()
    {
        return $this->belongsTo(Request::class, 'request_id');
    }

    public function delivery()
    {
        return $this->belongsTo(Delivery::class, 'delivery_id');
    }

    public function drafts()
    {
        return $this->hasMany(Draft::class, 'commission_id');
    }

    public function reviews()
    {
        return $this->hasMany(CommissionReview::class, 'commission_id');
    }
}
