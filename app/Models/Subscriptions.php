<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subscriptions extends Model
{
    //id, subscriber_id, channel_id, timestamps (unique pair)
    use HasFactory;
    protected $fillable = [
        'subscriber_id',
        'channel_id',
    ];
}
