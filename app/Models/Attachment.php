<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;

class Attachment extends Model
{
    use HasUlids;
    protected $table = 'attachment';
    protected $fillable = [
        'filename',
        'path',
        'mime_type',
    ];
}
