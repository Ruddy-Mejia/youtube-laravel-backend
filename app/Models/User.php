<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    protected $fillable = [
        'name',
        'email',
        'password',
        'channel_name',
        'status',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function likedVideos()
    {
        return $this->belongsToMany(Video::class, 'likes')->withTimestamps();
    }

    public function subscriptions()
    {
        return $this->belongsToMany(
            User::class,
            'subscriptions',
            'subscriber_id',
            'channel_id'
        )->withTimestamps();
    }

    public function subscribers()
    {
        return $this->belongsToMany(
            User::class,
            'subscriptions',
            'channel_id',
            'subscriber_id'
        )->withTimestamps();
    }
}
