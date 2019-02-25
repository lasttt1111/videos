<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    protected $table = 'images';

    public $incrementing = false;

    protected $fillable = ['id', 'link', 'deletehash', 'api', 'user_id'];

    public function user(){
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
