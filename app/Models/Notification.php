<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $table = 'notifications';

    public function video()
    {
        return $this->belongsTo(Video::class, 'video_id', 'id');
    }
}
