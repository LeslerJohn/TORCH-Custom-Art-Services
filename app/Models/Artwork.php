<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Artwork extends Model
{
    protected $table = 'artwork';

    protected $fillable = [
        'artist_id',
        'category_id',
        'title',
        'description',
        'medium',
        'dimension',
        'price',
        'stock',
        'is_showcase',
        'status',
    ];

    public function images()
    {
        return $this->hasMany(ArtworkImage::class);
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'artwork_tag');
    }

    public function artist()
    {
        return $this->belongsTo(ArtistProfile::class, 'artist_id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }


}
