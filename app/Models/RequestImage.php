<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;

class RequestImage extends Model
{
    protected $table = 'request_image';

    protected $fillable = [
        'request_id',
        'attachment_id',
    ];

    public function request()
    {
        return $this->belongsTo(Request::class, 'request_id');
    }

    public function attachment()
    {
        return $this->belongsTo(Attachment::class, 'attachment_id');
    }
}
