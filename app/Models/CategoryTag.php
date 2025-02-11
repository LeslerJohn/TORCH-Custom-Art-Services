<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CategoryTag extends Model
{
    protected $table = 'category_tag';
    protected $fillable = ['category_id', 'tag_id'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function tag()
    {
        return $this->belongsTo(Tag::class);
    }
}
