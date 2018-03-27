<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CateQuestion extends Model
{

	protected $table = 'cate_questions';

    protected $fillable = ['id','name','slug','description','created_at'];

    public $timestamps = true;

    public function sub_cate_question() {

    	return $this->hasMany('App\SubCateQuestion', 'id_cate_question', 'id');

    }
}
