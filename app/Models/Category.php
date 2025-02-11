<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = 'category';
    protected $fillable = ['name'];

    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'category_tag');
    }

    public function services()
    {
        return $this->hasMany(Service::class);
    }

    public function artworks()
    {
        return $this->hasMany(Artwork::class);
    }

    
}
