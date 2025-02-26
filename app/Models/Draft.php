<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;

class Draft extends Model
{
    use HasUlids;
    protected $table = 'draft';

    protected $fillable = [
        'commission_id',
        'description',
        'attachment_id',
    ];

    public function commission()
    {
        return $this->belongsTo(Commission::class, 'commission_id');
    }

    public function attachment()
    {
        return $this->belongsTo(Attachment::class, 'attachment_id');
    }
}
