<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LikeFeed extends Model
{
    protected $table = 'like_feeds';

    protected $fillable = ['id','id_user','id_feed','status'];

    public $timestamps = true;

    // Comment of post (id)
    public function feed(){
    	return $this->belongsTo('App\Feed','id_feed','id');
    }

    // Comment of user (id)
    public function user(){
    	return $this->belongsTo('App\User','id_user','id');
    }
}
