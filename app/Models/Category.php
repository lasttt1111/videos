<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = 'categories';

    protected $fillable = ['alias', 'title', 'image'];

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
    
    public function video(){
        return $this->hasMany(Video::class, 'category_id', 'id');
    }
}
