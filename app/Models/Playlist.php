<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Playlist extends Model
{
    protected $table = 'playlists';

    protected $hidden = ['id', 'pivot', 'user_id'];

    protected $fillable = ['user_id', 'title', 'alias', 'privacy', 'image'];

    public function scopeFindAlias($query, $alias){
        //return $query->whereRaw('binary `alias` = ? ', [$alias]);
        return $query->where('alias', $alias);
    }

    public function scopeSearch($query, $search, bool $privateSearch = false){
        //$search = Api::escapeSql($search);
        $search = str_replace(['\\', '%', '_'], ['\\\\', '\%', '\_'], $search);
        $query->where(function($query) use($search){
                        $query->where('title', 'like', "%$search%");
                        $query->orWhere('alias', 'like', "%$search%");
                    })
                ->orderBy('created_at', 'desc');
        return $privateSearch ? $query : $query->where('privacy', 0);
    }

    public function user(){
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function video(){
        return $this->belongsToMany(Video::class, 'playlist_video', 'playlist_id', 'video_id')
                    ->withPivot('position')
                    ->orderBy('position', 'asc'); 
    }

    protected static function boot() {
        parent::boot();
        static::observe(\App\Observers\PlaylistObserver::class);
    }
}
