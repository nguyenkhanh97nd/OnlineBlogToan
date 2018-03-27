<?php

namespace App;


use Cviebrock\EloquentSluggable\SluggableScopeHelpers;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{


    protected $table = 'categories';

    protected $fillable = ['id','name','slug','description','created_at'];

    public $timestamps = true;

    // category has many subcategories
    public function subcategory(){
    	return $this->hasMany('App\SubCategory','category_id','id');
    }

    // Category has many posts
    public function post(){
    	return $this->hasManyThrough('App\Post','App\SubCategory','category_id','subcategory_id','id');
    }
}
