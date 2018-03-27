<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BQuestion extends Model
{
    protected $table = 'b_questions';

    protected $fillable = ['id','name','id_post','ans_a','ans_b','ans_c','ans_d','image','created_at'];

    protected $hidden = ['created_at', 'updated_at'];

    public $timestamps = true;

    // Post <=> exam . Exam has many questions
    public function post(){
    	return $this->beLongsTo('App\Post','id_post','id');
    }

}
