<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Video extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title',
        'views',
        'duration',
        'description',
        'thumbnail_path',
        'user_id',
        'status',
        'is_published',
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'video_categories')->withTimestamps();
    }

    //antes usado para migraciones ...?
    // public function likes()
    // {
    //     return $this->belongsToMany(User::class, 'likes')->withTimestamps();
    // }
    
    // public function likes()
    // {
    //     return $this->hasMany(Likes::class);
    // }
    public function likedBy()
    {
        return $this->belongsToMany(User::class, 'likes')->withTimestamps();
    }

    public function comments()
    {
        return $this->hasMany(Comments::class);
    }
}
