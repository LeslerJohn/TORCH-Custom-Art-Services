<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use HasUlids;
    protected $table = 'address';
    protected $fillable = [
        'client_id',
        'street',
        'barangay',
        'zip_code',
        'house_number',
    ];

    public function client()
    {
        return $this->belongsTo(ClientProfile::class, 'client_id');
    }
}
