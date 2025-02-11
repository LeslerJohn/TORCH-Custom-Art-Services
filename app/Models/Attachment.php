<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Attachment extends Model
{
    protected $table = 'attachment';
    protected $fillable = [
        'filename',
        'path',
        'mime_type',
    ];

    public function showcaseImages()
    {
        return $this->hasMany(ShowcaseImage::class, 'attachment_id');
    }
}
