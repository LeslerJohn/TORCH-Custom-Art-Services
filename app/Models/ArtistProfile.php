<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ArtistProfile extends Model
{
    /** @use HasFactory<\Database\Factories\ArtistProfileFactory> */
    use HasFactory, HasUlids;

    protected $table = 'artist_profile';
    protected $fillable = [
        'id',
        'location',
        'gender',
        'username',
        'birthdate',
        'bio',
        'max_commissions',
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

    public function services()
    {
        return $this->hasMany(Service::class, 'artist_id', 'id');
    }

    public function artworks()
    {
        return $this->hasMany(Artwork::class, 'artist_id', 'id');
    }

    public function categories()
    {
        return $this->hasManyThrough(Category::class, Service::class, 'artist_id', 'id', 'id', 'category_id');
    }

    public function portfolio()
    {
        return $this->hasOne(ArtistPortfolio::class, 'artist_id', 'id');
    }

    public function discounts()
    {
        return $this->hasManyThrough(Discount::class, Artwork::class, 'artist_id', 'artwork_id', 'id', 'id');
    }

    public function payouts()
    {
        return $this->hasMany(Payout::class, 'artist_id', 'id');
    }
}
