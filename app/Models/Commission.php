<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;

class Commission extends Model
{
    use HasUlids;
    protected $table = 'commission';

    protected $fillable = [
        'request_id',
        'delivery_id',
        'deadline',
        'status',
        'is_extended',
        'extended_deadline',
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

    public function payments()
    {
        return $this->hasMany(Payment::class, 'commission_id');
    }

    public function refund()
    {
        return $this->hasOne(Refund::class, 'commission_id');
    }

    public function extension()
    {
        return $this->hasOne(Extension::class, 'commission_id');
    }
}
