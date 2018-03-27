<?php

namespace App;

use Illuminate\Support\Facades\Hash;
use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

use App\Traits\Follow;

class User extends Authenticatable
{
    /**
     * Laravel Passport
     */
    use HasApiTokens, Notifiable;

    /**
     * Trait Friendable
     */
    // use Friendable; Chỉ sử dụng cho Kết bạn. Ở đây dùng Follow
    
    use Follow;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table="users";
    protected $fillable = [
         'id','username', 'name','email','status','point','level', 'gpa','avatar','info','confirmation_code','gender','created_at'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
    public $timestamps = true;

    public function comment() {
        return $this->hasMany('App\Comment','user_id','id');
    }
    public function post() {
        return $this->hasMany('App\Post','author_id','id');
    }
    public function bdata() {
        return $this->hasMany('App\BData','id_user','id');
    }

    public function findForPassport($username) {
        return $this->where('level','=', '1')->where('username', $username)->orWhere('email', $username)->first();
    }

    public function feed() {
        return $this->hasMany('App\Feed', 'id_user', 'id');
    }

    public function comment_feed() {
        return $this->hasMany('App\CommentFeed', 'id_user', 'id');
    }

    public function like_feed() {
        return $this->hasMany('App\LikeFeed', 'id_user', 'id');
    }
}
