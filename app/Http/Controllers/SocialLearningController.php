<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\SubCateQuestion;
use App\Feed;

use JWTAuth;

class SocialLearningController extends Controller
{
    public function apiClientPostFeed(Request $request) {

    	$slug_cate = (string) trim($request->cate);
    	$slug_subcate = (string) trim($request->subcate);
    	$title = (string) trim($request->title);
    	$content = (string) trim($request->content);
    	$imageData = (string) trim($request->imageData);
    	$point_set = $request->point_set;

        $title = preg_replace('/\s+/', ' ', $title);
        $content = preg_replace('/\s+/', ' ', $content);

    	$token = JWTAuth::getToken();
    	$current_user = JWTAuth::toUser($token);

    	if(strlen($title) <= 0 || strlen($title) >100) {
            return response()->json([
                'error' => 'Tiêu đề từ 1-100 ký tự'
            ]);
        }

    	if(strlen($content) <= 0 || strlen($content) >500) {
            return response()->json([
                'error' => 'Nội dung từ 1-500 ký tự'
            ]);
        }

        // Get Slug
        $str = $title;
        	$str = trim(mb_strtolower($str));
		    $str = preg_replace('/(à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ)/', 'a', $str);
		    $str = preg_replace('/(è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ)/', 'e', $str);
		    $str = preg_replace('/(ì|í|ị|ỉ|ĩ)/', 'i', $str);
		    $str = preg_replace('/(ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ)/', 'o', $str);
		    $str = preg_replace('/(ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ)/', 'u', $str);
		    $str = preg_replace('/(ỳ|ý|ỵ|ỷ|ỹ)/', 'y', $str);
		    $str = preg_replace('/(đ)/', 'd', $str);
		    $str = preg_replace('/[^a-z0-9-\s]/', '', $str);
		    $str = preg_replace('/([\s]+)/', '-', $str);
		$slug = $str.str_random(4);
        
        $subcate = SubCateQuestion::where('slug', $slug_subcate)->firstOrFail();

        $feed = new Feed();
        $feed->name = $title;
        $feed->slug = $slug;
        $feed->content = $content;
        $feed->id_user = $current_user->id;
        $feed->id_sub_cate_question = $subcate->id;


        if($imageData) {
        	$exploded = explode(',', $imageData);
        	$decoded = base64_decode($exploded[1]);

        	if($exploded[0] === 'data:image/jpeg;base64') {
                $extension = 'jpg';
            } else if($exploded[0] === 'data:image/png;base64') {
                $extension = 'png';
            } else {
                return response()->json([
                    'error' => 'Chỉ sử dụng ảnh PNG,JPG,JPEG'
                ]);
            }

        	$name = str_random(4)."_".$slug.'.'.$extension;
        	while(file_exists("public/upload/user_questions/".$name)){
	            $name = str_random(4)."_".$slug.'.'.$extension;
	        }
	        $path = 'public/upload/user_questions/'.$name;
	        file_put_contents($path, $decoded);

            if(filesize($path) > 1000000) {
                unlink($path);
                return response()->json([
                    'error' => 'Ảnh phải nhỏ hơn 1MB'
                ]);
            }

	        $feed->image = $name;
        } else {
        	$feed->image = '';
        }


        if(!in_array($point_set, [5, 10, 15, 20])) {
        	$point_set = 5;
        }
        if($current_user->point_activity < $point_set) {
        	return response()->json([
	    		'error' => 'Bạn không đủ điểm năng động'
	    	]);
        }
        $feed->point_feed = $point_set;
        $feed->save();

        $current_user->point_activity = $current_user->point_activity - $point_set;
        $current_user->save();
        
    	return response()->json([
    		'success' => 'Đã gửi câu hỏi'
    	]);

    }
}
