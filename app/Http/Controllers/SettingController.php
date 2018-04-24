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

        if(strlen(trim($request->name)) < 1 || strlen(trim($request->name)) > 40) {
            return response()->json([
                'wrong_name' => 'Tên 1-40 kí tự'
            ]);
        }

    	$token = JWTAuth::getToken();
        $current_user = JWTAuth::toUser($token);

        $update = User::where('id', $current_user->id)->first();
        $update->name = $request->name;
        $update->save();

    	return response()->json([
    		'success' => 'Cập nhật tên thành công'
    	]);

    }

    public function apiClientSettingInfo(Request $request) {

        if(strlen(trim($request->info)) < 1 || strlen(trim($request->info)) > 200) {
            return response()->json([
                'wrong_info' => 'Giới thiệu bản thân 1-200 kí tự'
            ]);
        }

        $token = JWTAuth::getToken();
        $current_user = JWTAuth::toUser($token);

        $update = User::where('id', $current_user->id)->first();
        $update->info = $request->info;
        $update->save();
        
        return response()->json([
    		'success' => 'Cập nhật thông tin thành công'
    	]);
    }

    public function apiClientSettingAvatar(Request $request) {
        
        $token = JWTAuth::getToken();
        $user = JWTAuth::toUser($token);

        if($request->avatar) {
            $exploded = explode(',', $request->avatar);
            $decoded = base64_decode($exploded[1]);

            if($exploded[0] == 'data:image/jpeg;base64') {
                $extension = 'jpg';
            } else if($exploded[0] == 'data:image/png;base64') {
                $extension = 'png';
            } else {
                return response()->json([
                    'wrong_avatar' => 'Chỉ sử dụng ảnh PNG,JPG,JPEG'
                ]);
            }

            $username = $user->username;
            $name = str_random(4)."_".$username.'.'.$extension;
            while(file_exists("public/upload/users/".$name)){
                $name = str_random(4)."_".$username.'.'.$extension;
            }
        
            $path = 'public/upload/users/'.$name;

            file_put_contents($path, $decoded);

            if(filesize($path) > 500000) {
                unlink($path);
                return response()->json([
                    'wrong_avatar' => 'Ảnh phải nhỏ hơn 500KB'
                ]);
            }

            // if($user->avatar && file_exists('upload/users/'.$user->avatar)) {
            //     unlink('upload/users/'.$user->avatar);
            // }

            $user->avatar = $name;
        }
        $user->save();

        return response()->json([
            'success' => 'Cập nhật ảnh thành công',
        ]);
    }

    public function apiClientSettingPassword(Request $request) {

        $token = JWTAuth::getToken();
        $user = JWTAuth::toUser($token);

        if(strlen(trim($request->cur_pwd)) < 6) {
            return response()->json([
                'wrong_old_password' => 'Mật khẩu hiện tại quá ngắn'
            ]);
        } else if(strlen(trim($request->new_pwd)) < 6) {
            return response()->json([
                'wrong_password' => 'Mật khẩu tối thiểu 6 kí tự'
            ]);
        } else {
            if(!Hash::check($request->cur_pwd, $user->password)) {
                return response()->json([
                    'wrong_old_password' => 'Sai mật khẩu hiện tại'
                ]);
            }
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
            'success' => 'Đổi mật khẩu thành công'
        ]);

    }

}
