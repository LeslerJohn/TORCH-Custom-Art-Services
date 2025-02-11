<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    use HasFactory;
    protected $table = 'tag';
    
    protected $fillable = [
        'name',
    ];

    public function artists()
    {
        return $this->belongsToMany(User::class, 'artist_tag', 'tag_id', 'artist_id');
    }
}
