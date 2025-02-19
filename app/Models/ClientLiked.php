<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClientLiked extends Model
{
    protected $table = 'client_liked';

    protected $fillable = [
        'client_id',
        'artwork_id',
    ];

    public function client()
    {
        return $this->belongsTo(User::class, 'client_id');
    }

    public function artwork()
    {
        return $this->belongsTo(Artwork::class, 'artwork_id');
    }
}
