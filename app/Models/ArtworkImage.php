<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;

class ArtworkImage extends Model
{
    protected $table = 'artwork_image';

    protected $fillable = [
        'artwork_id',
        'attachment_id',
    ];

    public function artwork()
    {
        return $this->belongsTo(Artwork::class);
    }

    public function attachment()
    {
        return $this->belongsTo(Attachment::class);
    }
}
