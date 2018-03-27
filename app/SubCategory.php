<?php

namespace App;


use Cviebrock\EloquentSluggable\SluggableScopeHelpers;

use Illuminate\Database\Eloquent\Model;

class SubCategory extends Model
{
    protected $table = 'sub_categories';

    protected $fillable = ['id','name','slug','category_id','description','created_at'];

    public $timestamps = true;

    public function category(){
    	return $this->belongsTo('App\Category','category_id','id');
    }
    public function post(){
        return $this->hasMany('App\Post','subcategory_id','id');
    }
}
