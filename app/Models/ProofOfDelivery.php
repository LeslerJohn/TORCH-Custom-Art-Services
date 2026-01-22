<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProofOfDelivery extends Model
{
    protected $table = 'proof_of_delivery';

    protected $fillable = [
        'delivery_id',
        'attachment_id',
    ];

    public function delivery()
    {
        return $this->belongsTo(Delivery::class);
    }

    public function attachment()
    {
        return $this->belongsTo(Attachment::class);
    }
}
