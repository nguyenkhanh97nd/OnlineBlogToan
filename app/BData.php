<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BData extends Model
{
    protected $table = 'b_datas';

    protected $fillable = ['id','status','submit','id_post','id_user','ans_data','time_started','time_did','point_exam'];

    public $timestamps = true;

    // Author of post
    public function post(){
    	return $this->beLongsTo('App\Post','id_post','id');
    }
    // Data test exam of user
    public function user(){
    	return $this->beLongsTo('App\User','id_user','id');
    }

}
