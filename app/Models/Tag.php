<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    use HasFactory, HasUlids;
    protected $table = 'tag';
    
    protected $fillable = [
        'name',
    ];

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'category_tag', 'tag_id', 'category_id');
    }

    public function artists()
    {
        return $this->belongsToMany(User::class, 'artist_tag', 'tag_id', 'artist_id');
    }
}
