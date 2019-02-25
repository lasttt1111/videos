<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class View extends Model
{
    protected $table = 'views';

    protected $fillable = ['user_id', 'ip', 'video_id'];

    const UPDATED_AT = null;


    public function video(){
        return $this->belongsTo(Video::class, 'video_id', 'id');
    }
}
