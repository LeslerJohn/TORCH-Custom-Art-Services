<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ArtistAgreement extends Model
{
    protected $table = 'artist_agreement';

    protected $fillable = [
        'artist_id',
        'attachment_id',
        'status',
    ];

    public function artist()
    {
        return $this->belongsTo(ArtistProfile::class, 'artist_id');
    }

    public function attachment()
    {
        return $this->belongsTo(Attachment::class, 'attachment_id');
    }
}
