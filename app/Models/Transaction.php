<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use CoenJacobs\EloquentCompositePrimaryKeys\HasCompositePrimaryKey;
class Transaction extends Model
{
    use HasCompositePrimaryKey;

    protected $table = 'video_transactions';

    public $incrementing = false;

    protected $primaryKey = ['video_id', 'user_id'];

    protected $fillable = ['video_id', 'user_id'];

    public function user(){
    	return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function video(){
    	return $this->belongsTo(Video::class, 'video_id', 'id');
    }
}
