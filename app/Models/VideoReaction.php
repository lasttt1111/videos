<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use CoenJacobs\EloquentCompositePrimaryKeys\HasCompositePrimaryKey;
class VideoReaction extends Model
{
    use HasCompositePrimaryKey;
    protected $table = 'video_reactions';

    public $incrementing = false;

    protected $primaryKey = ['video_id', 'user_id'];

    protected $fillable = ['user_id', 'video_id', 'reaction'];

    public function video(){
    	return $this->belongsTo(Video::class, 'video_id', 'id');
    }

    public function user(){
    	return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
