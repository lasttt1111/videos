<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $table = 'comments';

    protected $hidden = ['user_id', 'video_id'];

    protected $fillable = ['user_id', 'video_id', 'content'];

    public function replies(){
        return $this->hasMany(Reply::class, 'comment_id', 'id');
    }

    public function user(){
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function scopeFromVideo($query, $video_id){
        return $query->where('video_id', $video_id);
    }

    public function scopeWithCountReply($query){
        return $query->withCount('replies');
    }

    public function setContentAttribute($value){
        $this->attributes['content'] = htmlspecialchars($value);
    }
}
