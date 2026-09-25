<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Comments extends Model
{
    //id, user_id, video_id, body, timestamps
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'user_id',
        'video_id',
        'body',
        'comment_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function video()
    {
        return $this->belongsTo(Video::class);
    }

    public function parent()
    {
        return $this->belongsTo(Comments::class, 'comment_id');
    }

    public function replies()
    {
        return $this->hasMany(Comments::class, 'comment_id');
    }
}
