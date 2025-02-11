<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ArtistPortfolio extends Model
{
    protected $table = 'portfolio';

    protected $fillable = [
        'artist_id',
        'portfolio_id',
        'link',
        'status',
    ];

    public function artist()
    {
        return $this->belongsTo(ArtistProfile::class, 'artist_id', 'id');
    }

    public function attachment()
    {
        return $this->hasOne(Attachment::class, 'id', 'portfolio_id');
    }
}
