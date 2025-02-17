<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'role',
        'password',
        'is_admin',
        'profile_image_id',
        'cover_image_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function client()
    {
        return $this->hasOne(ClientProfile::class, 'id', 'id');
    }

    public function artist()
    {
        return $this->hasOne(ArtistProfile::class, 'id', 'id');
    }

    public function isArtist()
    {
        return $this->role === 'artist';
    }

    public function profileImage()
    {
        return $this->hasOne(Attachment::class, 'id', 'profile_image_id');
    }

    public function coverImage()
    {
        return $this->hasOne(Attachment::class, 'id', 'cover_image_id');
    }

    public function orders()
    {
        return $this->hasMany(Order::class, 'client_id', 'id');
    }

    public function address()
    {
        return $this->hasOne(Address::class, 'client_id', 'id');
    }
}
