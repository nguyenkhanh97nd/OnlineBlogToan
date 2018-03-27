<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CommentFeed extends Model
{
    protected $table = 'comment_feeds';

    protected $fillable = ['id','id_user','id_feed','content','created_at'];

    public $timestamps = true;

    // Comment of feed (id)
    public function feed(){
    	return $this->belongsTo('App\Feed','id_feed','id');
    }

    // Comment of user (id)
    public function user(){
    	return $this->belongsTo('App\User','id_user','id');
    }
}
