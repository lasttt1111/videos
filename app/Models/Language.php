<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Language extends Model
{
    protected $table = 'languages';

    public $incrementing = false;

    public $primaryKey = 'id';

    protected $fillable = ['id', 'name'];

    public function scopeSearch($query, $search){
        //$search = Api::escapeSql($search);
        $search = str_replace(['\\', '%', '_'], ['\\\\', '\%', '\_'], $search);
        return $query->where(function($query) use($search){
                    $query->where('id', 'like', "%$search%");
                    $query->orWhere('name', 'like', "%$search%");
        });

    }

}
