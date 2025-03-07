<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;

class CommissionReview extends Model
{
    use HasUlids;
    protected $table = 'commission_review';

    protected $fillable = [
        'commission_id',
        'rating',
        'comment',
    ];

    public function commission()
    {
        return $this->belongsTo(Commission::class, 'commission_id');
    }
}
