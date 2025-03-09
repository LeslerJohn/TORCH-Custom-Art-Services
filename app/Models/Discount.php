<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;

class Discount extends Model
{
    use HasUlids;

    protected $table = 'discount';

    protected $fillable = [
        'artwork_id',
        'type',
        'value',
        'value_type',
        'status',
    ];

    public function artwork()
    {
        return $this->belongsTo(Artwork::class, 'artwork_id', 'id');
    }

    public function getDiscountValueAttribute()
    {
        return $this->value_type === 'percentage' ? $this->value . '%' : '₦' . number_format($this->value, 2);
    }
}
