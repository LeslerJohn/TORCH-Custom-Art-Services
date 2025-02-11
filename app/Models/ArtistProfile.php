<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ArtistProfile extends Model
{
    /** @use HasFactory<\Database\Factories\ArtistProfileFactory> */
    use HasFactory;

    protected $table = 'artist_profile';
    protected $fillable = [
        'id',
        'phone_number',
        'location',
        'gender',
        'username',
        'birthdate',
        'bio',
        'status',
        'is_suspended',
        'rating',
        'available',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id', 'id');
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'artist_tag', 'artist_id', 'tag_id');
    }

    public function portfolio()
    {
        return $this->hasOne(ArtistPortfolio::class, 'artist_id', 'id');
    }
}
