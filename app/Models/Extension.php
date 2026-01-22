<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;

class Extension extends Model
{
    use HasUlids;

    protected $table = 'extension';

    protected $fillable = [
        'commission_id',
        'artist_id',
        'status',
        'reason',
        'attachment_id',
    ];

    public function commission()
    {
        return $this->belongsTo(Commission::class, 'commission_id');
    }

    public function attachment()
    {
        return $this->hasOne(Attachment::class, 'id', 'attachment_id');
    }

    public function artist()
    {
        return $this->belongsTo(ArtistProfile::class, 'artist_id');
    }
}
