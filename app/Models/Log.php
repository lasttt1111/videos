<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    protected $table = 'logs';

    protected $fillable = ['user_id', 'level', 'ip', 'message', 'url'];

    const UPDATED_AT = null;

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function scopeSearch($query, $search)
    {
        $search = str_replace(['\\', '%', '_'], ['\\\\', '\%', '\_'], $search);
        return $query->where(function($query) use($search){
                    $query->where('url', 'like', "%$search%");
                    $query->orWhere('message', 'like', "%$search%");
                    $query->orWhere('ip', 'like', "%$search%");
        });
    }
}
