<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $table = 'service';
    protected $fillable = [
        'artist_id',
        'category_id',
        'price_rate',
        'rush_price_rate',
        'timeframe',
        'status',
    ];

    public function images()
    {
        return $this->hasMany(ServiceImage::class, 'service_id', 'id');
    }

    public function tags()
    {
        return $this->belongstoMany(Tag::class, 'service_tag', 'service_id', 'tag_id');
    }

    public function artist()
    {
        return $this->belongsTo(ArtistProfile::class, 'artist_id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }
}
