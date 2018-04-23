<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use JWTAuth;
use App\User;
use App\Feed;
use App\LikeFeed;
use App\CommentFeed;
use App\SubCateQuestion;

class CommentFeedController extends Controller
{

    public function apiClientGetCommentFeeds(Request $request) {

        $sort_key = (string) $request->sort_key;

        if($sort_key === 'point') {
            $feeds = Feed::with(['user', 'like_feed', 'sub_cate_question.cate_question', 'comment_feed'])
                    ->orderBy('point_feed', 'DESC')
                    ->paginate(10);
        } else if($sort_key === 'unans'){
            $comment_feeds = CommentFeed::where('status', 1)->pluck('id_feed','id_feed')->toArray();

            $feeds = Feed::with(['user', 'like_feed', 'sub_cate_question.cate_question', 'comment_feed'])
                    ->whereNotIn('id', $comment_feeds)
                    ->orderBy('id', 'DESC')
                    ->paginate(10);
        } else {
            $feeds = Feed::with(['user', 'like_feed', 'sub_cate_question.cate_question', 'comment_feed'])
                    ->orderBy('id', 'DESC')
                    ->paginate(10);
        }

        return response()->json([
            'feeds' => $feeds,
            'v' => $sort_key
        ]);
    }

    public function apiClientGetCommentFeed(Request $request, $slug) {

	 	$feed_slug = (string) $slug;

    	$token = JWTAuth::getToken();
        $user = JWTAuth::toUser($token);

        $feed = Feed::with(['user', 'like_feed', 'sub_cate_question.cate_question.sub_cate_question'])
        			->where('status', '<>', 10)
        			->where('slug', $feed_slug)
     				->first();

     	$getUser = User::where('id', $feed['id_user'])
     				   ->where('status', 1)
     				   ->first();

     	$comment_feeds = CommentFeed::with(['user'])->where('id_feed', $feed['id'])->orderBy('id', 'DESC')->paginate(10);
        $total_comments = CommentFeed::where('id_feed', $feed['id'])->count();

     	$getUser['is_following'] = $user->is_following($getUser->id);

    	return response()->json([
    		'getUser' => $getUser,
    		'feed' => $feed,
    		'comment_feeds' => $comment_feeds,
            'total_comments' => $total_comments
    	]);

    }


    public function apiClientAcceptAnswerFeed(Request $request) {

        $token = JWTAuth::getToken();
        $user = JWTAuth::toUser($token);

        $id = (int) trim($request->comment_id);

        $comment_feed = CommentFeed::where('id', $id)->firstOrFail();

        if($comment_feed->status != 1) {
            return response()->json([
                'error'=>'Không thể duyệt!'
            ]);
        }

        $feed = Feed::where('id', $comment_feed->id_feed)->firstOrFail();
        $getUser = User::where('id', $comment_feed->id_user)->firstOrFail();

        $check_exits = CommentFeed::where('id_user', $getUser->id)->where('id_feed', $feed->id)->where('status', 10)->get();

        if($check_exits) {
            $bonus = 0;
        } else {
            $bonus = $feed->point_feed;   
        }

        $comment_feed->status = 10;
        $comment_feed->save();

        if($user->id != $getUser->id) {
            $getUser->point_activity = $getUser->point_activity + $bonus;
            $getUser->save();
        }

        return response()->json([
            'success' => 'Đã duyệt!'
        ]);

    }

    public function apiClientRemoveAcceptAnswerFeed(Request $request) {
        $token = JWTAuth::getToken();
        $user = JWTAuth::toUser($token);

        $id = (int) trim($request->comment_id);

        $comment_feed = CommentFeed::where('id', $id)->firstOrFail();

        if($comment_feed->status != 10) {
            return response()->json([
                'error'=>'Không thể bỏ duyệt!'
            ]);
        }

        $feed = Feed::where('id', $comment_feed->id_feed)->firstOrFail();
        $getUser = User::where('id', $comment_feed->id_user)->firstOrFail();

        if($user->id != $getUser->id) {
            $user->point_activity = $user->point_activity - $feed->point_feed;

            if($user->point_activity < 0) {
                return response()->json([
                    'error'=>'Không thể bỏ duyệt!'
                ]);
            } else {
                $user->save();
            }
        }
        $comment_feed->status = 1;
        $comment_feed->save();

        return response()->json([
            'success' => 'Đã bỏ duyệt!'
        ]);
    }

    public function apiClientLockFeed(Request $request) {
        $token = JWTAuth::getToken();
        $user = JWTAuth::toUser($token);

        $slug = (string) trim($request->feed_slug);

        $feed = Feed::where('slug', $slug)->where('status', 1)->firstOrFail();
        if($user->id == $feed->id_user) {
            $feed->status = 0;
            $feed->save();
            return response()->json([
                'success' => 'Đã đóng câu hỏi'
            ]);
        }
        return response()->json([
            'error' => 'Xảy ra lỗi'
        ]);

    }

    public function apiClientRemoveFeed(Request $request) {

        $token = JWTAuth::getToken();
        $user = JWTAuth::toUser($token);

        $slug = (string) trim($request->feed_slug);
        $feed = Feed::with(['comment_feed', 'like_feed'])->where('slug', $slug)->firstOrFail();

        if($user->id == $feed->id_user) {

            foreach ($feed->like_feed as $like_feed) {
                LikeFeed::destroy($like_feed->id);
            }

            foreach($feed->comment_feed as $comment_feed) {

                if($comment_feed->image) {
                    if(file_exists('upload/user_questions_comment/'.$comment_feed->image)) {
                        unlink('upload/user_questions_comment/'.$comment_feed->image);
                    }
                }
                CommentFeed::destroy($comment_feed->id);

            }
            if($feed->image) {
                if(file_exists('upload/user_questions/'.$feed->image)) {
                    unlink('upload/user_questions/'.$feed->image);
                }
            }
            $feed->delete();
            return response()->json([
                'success' => 'Đã xoá câu hỏi'
            ]);
        }
        return response()->json([
            'error' => 'Xảy ra lỗi'
        ]);

    }

    public function apiClientEditFeed(Request $request) {

        $slug = (string) trim($request->feed_slug);
        $slug_cate = (string) trim($request->cate);
        $slug_subcate = (string) trim($request->subcate);
        $title = (string) trim($request->title);
        $content = (string) trim($request->content);
        $imageData = (string) trim($request->imageData);
        $imageUrl = (string) trim($request->imageUrl);

        $title = preg_replace('/\s+/', ' ', $title);
        $content = preg_replace('/\s+/', ' ', $content);


        $token = JWTAuth::getToken();
        $current_user = JWTAuth::toUser($token);

        if(strlen($title) <= 0 || strlen($title) >100) {
            return response()->json([
                'error' => 'Tiêu đề chỉ từ 1-100 ký tự'
            ]);
        }

        if(strlen($content) <= 0 || strlen($content) >500) {
            return response()->json([
                'error' => 'Nội dung chỉ từ 1-500 ký tự'
            ]);
        }

        $subcate = SubCateQuestion::where('slug', $slug_subcate)->firstOrFail();
        $feed = Feed::where('slug', $slug)->where('status', '<>', 10)->firstOrFail();

        $feed->name = $title;
        $feed->content = $content;
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
            while(file_exists("upload/user_questions/".$name)){
                $name = str_random(4)."_".$slug.'.'.$extension;
            }
            $path = 'upload/user_questions/'.$name;
            file_put_contents($path, $decoded);
            
            if(filesize($path) > 1000000) {
                unlink($path);
                return response()->json([
                    'error' => 'Ảnh phải nhỏ hơn 1MB'
                ]);
            }

            if($feed->image) {
                if(file_exists('upload/user_questions/'.$feed->image)) {
                    unlink('upload/user_questions/'.$feed->image);
                }
            }
            
            $feed->image = $name;
        } else if($imageUrl == null) {
            if($feed->image) {
                if(file_exists('upload/user_questions/'.$feed->image)) {
                    unlink('upload/user_questions/'.$feed->image);
                }
            }
            $feed->image = '';
        }
        $feed->update();

        return response()->json([
            'success' => 'Đã sửa câu hỏi'
        ]);

    }
}
