<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $table = 'comments';

    protected $fillable = ['id','user_id', 'post_id','exp_id','content','created_at'];

    public $timestamps = true;

    // Comment of post (id)
    public function post(){
    	return $this->belongsTo('App\Post','post_id','id');
    }

    // Comment of user (id)
    public function user(){
    	return $this->belongsTo('App\User','user_id','id');
    }
}
