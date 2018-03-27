<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Friendship extends Model
{
	protected $table = 'friendships';

    protected $fillable = ['requester', 'user_requested', 'status'];

    public $timestamps = true;

}
