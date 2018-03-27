<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

use JWTAuth;
use App\User;
use Mail;


class SettingController extends Controller
{
    
    public function apiClientSettingName(Request $request) {

    	$this->validate($request,[
            'name' => 'required|max:40',
        ],[
            'name.required' => 'Cần nhập tên',
            'name.max' => 'Tên không quá 40 kí tự'
        ]);

    	$token = JWTAuth::getToken();
        $current_user = JWTAuth::toUser($token);

        $update = User::where('id', $current_user->id)->first();
        $update->name = $request->name;
        $update->save();

    	return response()->json([
    		'success' => true
    	]);

    }

    public function apiClientSettingInfo(Request $request) {

    	$this->validate($request,[
            'info' => 'required|max:200',
        ],[
            'info.required' => 'Cần điền giới thiệu',
            'info.max' => 'Giới thiệu bản thân không quá 200 ký tự'
        ]);
        $token = JWTAuth::getToken();
        $current_user = JWTAuth::toUser($token);

        $update = User::where('id', $current_user->id)->first();
        $update->info = $request->info;
        $update->save();
        
        return response()->json([
    		'success' => true
    	]);
    }

    public function apiClientSettingAvatar(Request $request) {
        
        $token = JWTAuth::getToken();
        $user = JWTAuth::toUser($token);

        if($request->avatar) {
            $exploded = explode(',', $request->avatar);
            $decoded = base64_decode($exploded[1]);

            $extension = str_contains($exploded[0], 'jpeg') ? 'jpg' : 'png';

            $username = $user->username;
            $name = str_random(4)."_".$username.'.'.$extension;
            while(file_exists("upload/users/".$name)){
                $name = str_random(4)."_".$username.'.'.$extension;
            }
            $path = 'upload/users/'.$name;

            if($user->avatar && file_exists('upload/users/'.$user->avatar)) {
                unlink('upload/users/'.$user->avatar);
            }

            file_put_contents($path, $decoded);

            $user->avatar = $name;
        }
        $user->save();

        return response()->json([
            'success' => true
        ]);
    }

    public function apiClientSettingPassword(Request $request) {

        $this->validate($request,[
            'cur_pwd' => 'required|min:6',
            'new_pwd' => 'required|min:6',
        ],[
            'cur_pwd.required' => 'Nhập mật khẩu hiện tại',
            'cur_pwd.min' => 'Mật khẩu hiện tại quá ngắn',
            'new_pwd.required' => 'Nhập mật khẩu mới',
            'new_pwd.min' => 'Mật khẩu tối thiểu 6 kí tự',
        ]);

        $token = JWTAuth::getToken();
        $user = JWTAuth::toUser($token);

        if(!Hash::check($request->cur_pwd, $user->password)) {
            return response()->json([
                'wrong_old_password' => true
            ]);
        }

        $user->password = bcrypt($request->new_pwd);
        $user->save();

        $data = array();
        $data['name'] = $user['name'];
        $data['email'] = $user['email'];
        $data['username'] = $user['username'];

        Mail::send('pages.mail.password', $data, function($message) use ($data){
                $message->from('blogtoan.com@gmail.com', 'Blog Toán');
                $message->subject('Thông báo đổi mật khẩu');
                $message->to($data['email']);
            });

        return response()->json([
            'success' => true
        ]);

    }

}
