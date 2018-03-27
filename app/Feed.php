<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Feed extends Model
{
	protected $table = 'feeds';

    protected $fillable = ['id', 'name', 'slug', 'point_feed', 'id_user', 'id_sub_cate_question', 'content', 'status'];

    public $timestamps = true;

    public function user() {
    	return $this->belongsTo('App\User', 'id_user', 'id');
    }

    public function like_feed() {
    	return $this->hasMany('App\LikeFeed', 'id_feed', 'id');
    }

    public function comment_feed() {
    	return $this->hasMany('App\CommentFeed', 'id_feed', 'id');
    }

    public function sub_cate_question() {
        return $this->belongsTo('App\SubCateQuestion', 'id_sub_cate_question', 'id');
    }

}
