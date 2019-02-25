<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    protected $table = 'tags';

    protected $fillable = ['alias', 'title'];

    public function video()
    {
        return $this->belongsToMany(Video::class, 'video_tags', 'tag_id', 'video_id');
    }

    public function scopeFindAlias($query, $alias){
        //return $query->whereRaw('binary `alias` = ? ', [$alias]);
        return $query->where('alias', $alias);
    }

    public function scopeSearch($query, $search){
        //$search = Api::escapeSql($search);
        $search = str_replace(['\\', '%', '_'], ['\\\\', '\%', '\_'], $search);
        return $query->where(function($query) use($search){
                    $query->where('alias', 'like', "%$search%");
                    $query->orWhere('title', 'like', "%$search%");
        });

    }

    protected static function boot() {
        parent::boot();
        static::observe(\App\Observers\TagObserver::class);
    }
}
