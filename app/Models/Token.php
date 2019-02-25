<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Token extends Model
{
    protected $table = 'user_tokens';

    protected $fillable = ['payload', 'user_id', 'api_id', 'expires_at'];

    protected $casts = [
    	'expires_at' => 'datetime'
    ];

    public function user(){
    	return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
