<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    protected $table = 'video';

    protected $hidden = ['user_id', 'password', 'pivot', 'category_id'];

    protected $fillable = ['title', 'alias', 'description', 'category_id', 'privacy', 'image', 'password', 'link', 'user_id', 'label', 'language', 'price'];

    protected $appends = ['has_password'];


    protected static function boot() {
        parent::boot();
        static::observe(\App\Observers\VideoObserver::class);
    }

    public function getHasPasswordAttribute(){
        return isset($this->attributes['password']) ? 1 : 0;
    }

    public function setPasswordAttribute($value){
        if (empty($value)){
            $this->attributes['password'] = null;
            return;
        }
        $this->attributes['password'] = \Hash::make($value);
    }

    public function setDescriptionAttribute($value){
        //$this->attributes['description'] = htmlspecialchars($value);
        //Xử lí tấn công khi in, không phải khi lưu
        $this->attributes['description'] = $value;
    }

    public function user(){
    	return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function reactions(){
    	return $this->hasMany(VideoReaction::class, 'video_id');
    }

    public function category(){
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }

    public function tags(){
        return $this->belongsToMany(Tag::class, 'video_tags', 'video_id', 'tag_id');
    }

    public function comments(){
        return $this->hasMany(Comment::class, 'video_id');
    }

    public function scopeFindAlias($query, $alias){
        //return $query->whereRaw('binary `alias` = ? ', [$alias]);
        return $query->where('alias', $alias);
    }

    public function scopeCommonSelect($query, array $appends = []){
        $select = array_merge([
            'id', 'title', 'alias', 'image', 'views', 
            'created_at', 'password', 'price', 'user_id',
            'description', 'label'
        ], $appends);

        return $query->select($select);
    }

    public function playlists(){
        return $this->belongsToMany(Playlist::class, 'playlist_video', 'video_id', 'playlist_id'); 
    }

    public function scopeSearch($query, $search, bool $privateSearch = false){
        //$search = Api::escapeSql($search);
        $search = str_replace(['\\', '%', '_'], ['\\\\', '\%', '\_'], $search);
        $query->where(function($query) use($search){
                        $query->where('title', 'like', "%$search%");
                        $query->orWhere('alias', 'like', "%$search%");
                        $query->orWhere('description', 'like', "%$search%");
                    })
                ->orderBy('created_at', 'desc');
        return $privateSearch ? $query : $query->where('privacy', 0);
    }

    //public function get
}
