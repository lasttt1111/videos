<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Link extends Model
{
    protected $table = 'link';

    protected $fillable = ['video_id', 'file_id'];
    
    public function video(){
    	return $this->hasMany(Video::class, 'video_id', 'id');
    }

}
