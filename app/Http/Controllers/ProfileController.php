<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use App\User;
use App\Feed;
use App\CommentFeed;
use App\LikeFeed;

use JWTAuth;

class ProfileController extends Controller
{

    public function apiClientDoLike(Request $request) {

        $slug_feed = (string) $request->slug_feed;

        $token = JWTAuth::getToken();
        $current_user = JWTAuth::toUser($token);

        $feed = Feed::where('slug', $slug_feed)->where('status','<>', 10)->firstOrFail();

        $like_feed = LikeFeed::where('id_user', $current_user->id)
                             ->where('id_feed', $feed->id)
                             ->first();

        if(count($like_feed) == 0) {
            $like_feed = new LikeFeed;
            $like_feed->id_user = $current_user->id;
            $like_feed->id_feed = $feed->id;
            $like_feed->status = 1;
            $like_feed->save();
        }

        return response()->json([
            'success' => 'Bạn vừa thích status'
        ]);
    }

    public function apiClientDoDislike(Request $request) {

        $slug_feed = (string) $request->slug_feed;

        $token = JWTAuth::getToken();
        $current_user = JWTAuth::toUser($token);

        $feed = Feed::where('slug', $slug_feed)->where('status', '<>', 10)->firstOrFail();

        $like_feed = LikeFeed::where('id_user', $current_user->id)
                             ->where('id_feed', $feed->id)
                             ->first();

        if(count($like_feed) != 0) {
            $like_feed->delete();
        }

        return response()->json([
            'success' => 'Bạn vừa bỏ thích status'
        ]);
    }

    public function apiClientDoComment(Request $request) {

        $imageData = (string) trim($request->comment_image);

        $slug_feed = (string) trim($request->slug_feed);

        $comment_content = (string) trim($request->comment_content);

        if(strlen($comment_content) <=0 || strlen($comment_content) > 500) {
            return response()->json([
                'comment_status' => 'Nội dung comment lỗi'
            ]);
        }

        $token = JWTAuth::getToken();
        $current_user = JWTAuth::toUser($token);

        $feed = Feed::with(['user'])->where('slug', $slug_feed)->where('status', 1)->firstOrFail();

        $slug = $feed->slug;



        $comment_feed = new CommentFeed;

        if($imageData) {
            $exploded = explode(',', $imageData);
            $decoded = base64_decode($exploded[1]);

            if($exploded[0] === 'data:image/jpeg;base64') {
                $extension = 'jpg';
            } else if($exploded[0] === 'data:image/png;base64') {
                $extension = 'png';
            } else {
                return response()->json([
                    'comment_status' => 'Chỉ sử dụng ảnh PNG,JPG,JPEG'
                ]);
            }

            $name = $slug."_".str_random(4).'.'.$extension;
            while(file_exists("public/upload/user_questions_comment/".$name)){
                $name = $slug."_".str_random(4).'.'.$extension;
            }
            $path = 'public/upload/user_questions_comment/'.$name;
            file_put_contents($path, $decoded);

            if(filesize($path) > 1000000) {
                unlink($path);
                return response()->json([
                    'comment_status' => 'Ảnh phải nhỏ hơn 1MB'
                ]);
            }

            $comment_feed->image = $name;
        } else {
            $comment_feed->image = '';
        }

        $comment_feed->id_user = $current_user->id;
        $comment_feed->id_feed = $feed->id;
        $comment_feed->content = $comment_content;
        

        $comment_feed->status = 1;
        $comment_feed->save();

        return response()->json([
            'success' => 'Bạn vừa comment status',
        ]);

    }
}
