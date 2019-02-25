<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use CoenJacobs\EloquentCompositePrimaryKeys\HasCompositePrimaryKey;
class Subscriber extends Model
{
    use HasCompositePrimaryKey;
	
    protected $table = 'subscribers';

    protected $primaryKey = ['user_id', 'subscriber_id'];

    protected $fillable = ['user_id', 'subscriber_id'];

    public function user(){
    	return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function subscriber(){
    	return $this->belongsTo(User::class, 'subscriber_id', 'id');
    }
}
