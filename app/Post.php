<?php

namespace App;


use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $table = 'posts';

    protected $fillable = ['id','name','slug','brief','content','image','time_start','time_do','count_views','subcategory_id','author_name','created_at'];

    public $timestamps = true;

    public function subcategory(){
    	return $this->belongsTo('App\SubCategory','subcategory_id','id');
    }
    public function comment(){
    	return $this->hasMany('App\Comment','post_id','id');
    }
    public function author(){
    	return $this->belongsTo('App\User','author_id','id');
    }

    public function question(){
        return $this->hasMany('App\BQuestion','id_post','id');
    }

    public function data(){
        return $this->hasMany('App\BData','id_post','id');
    }
}
