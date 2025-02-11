<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServiceTag extends Model
{
    protected $table = 'service_tag';
    protected $fillable = [
        'service_id',
        'tag_id',
    ];
    
    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    public function tag()
    {
        return $this->belongsTo(Tag::class);
    }
}
