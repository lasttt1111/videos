<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'avatar', 'cover', 'name', 'alias', 'id', 'email', 'password'
    ];

    protected $hidden = ['password'];
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    /*protected $hidden = [
        'password', 'remember_token', 'id'
    ];*/

    protected $table = 'users';

    public function video(){
    	return $this->hasMany(Video::class, 'user_id');
    }

    public function subscribers(){
        //return $this->hasMany(Subscriber::class, 'user_id', 'id');
        return $this->belongsToMany(User::class, 'subscribers', 'user_id', 'subscriber_id');
    }

    public function subscription(){
        return $this->belongsToMany(User::class, 'subscribers', 'subscriber_id', 'user_id');
    }

    public function playlist(){
        return $this->hasMany(Playlist::class, 'user_id', 'id');
    }

    public function setPasswordAttribute($value){
        $this->attributes['password'] = \Hash::make($value);
    }

    public function scopeFindAlias($query, $alias){
        //return $query->whereRaw('binary `alias` = ? ', [$alias]);
        return $query->where('alias', $alias);
    }

    public function scopeInfo($query){
        return $query->addSelect(['id', 'alias', 'name', 'avatar']);
    }

    public function scopeSearch($query, $search){
        $search = str_replace(['\\', '%', '_'], ['\\\\', '\%', '\_'], $search);
        return $query->where(function ($query) use ($search){
            $query->where('alias', 'like', "%$search%");
            $query->orWhere('name', 'like',  "%$search%");
        });
    }
}
