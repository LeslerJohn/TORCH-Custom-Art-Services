<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;

class ServiceImage extends Model
{
    protected $table = 'service_image';
    protected $fillable = [
        'service_id',
        'attachment_id',
    ];

    public function service()
    {
        return $this->belongsTo(Service::class, 'service_id', 'id');
    }

    public function attachment()
    {
        return $this->belongsTo(Attachment::class, 'attachment_id', 'id');
    }
}
