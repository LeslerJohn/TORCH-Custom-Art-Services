<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory, HasUlids;
    protected $table = 'category';
    protected $fillable = ['name'];

    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'category_tag', 'category_id', 'tag_id');
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
