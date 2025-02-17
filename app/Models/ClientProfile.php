<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClientProfile extends Model
{
    use HasFactory;
    protected $table = 'client_profile';

    protected $fillable = [
        'id',
        'rating',
        'is_suspended',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id');
    }

    public function requests()
    {
        return $this->hasMany(Request::class, 'client_id');
    }

    public function cart()
    {
        return $this->hasOne(Cart::class, 'client_id');
    }

    public function getCartCount()
    {
        return $this->cart()->items()->count();
    }

}
