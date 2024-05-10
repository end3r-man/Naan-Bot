<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class add_youtube extends Model
{
    use HasFactory;

    protected $table = "user_youtube";

    protected $fillable = [
        'user_id',
        'guild_id',
        'channel_id',
        'channel_link'
    ];
}
