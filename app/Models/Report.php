<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    protected $table = 'reports';

    protected $fillable = ['user_id', 'video_id', 'message', 'ip', 'is_read'];

    public function user(){
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function video(){
        return $this->belongsTo(Video::class, 'video_id', 'id');
    }
}
