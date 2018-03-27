<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SubCateQuestion extends Model
{

	protected $table = 'sub_cate_questions';

    protected $fillable = ['id','name','slug','id_cate_question','description','created_at'];

    public $timestamps = true;

    public function cate_question() {
    	return $this->belongsTo('App\CateQuestion', 'id_cate_question', 'id');
    }

    public function feed() {
    	return $this->hasMany('App\Feed', 'id_sub_cate_question', 'id');
    }

}
