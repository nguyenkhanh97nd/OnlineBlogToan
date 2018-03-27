<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Comment;
/*-- Quản lí user --*/
use Illuminate\Support\Facades\Auth;

use JWTAuth;
use App\Post;

class CommentController extends Controller
{

    /**
     * Get Master Blade Template View
     * Let Vuejs Backend
     * @return [view] [admin.master]
     */
    public function getMasterView() {
        return view('admin.master');
    }

    /**
     * API use Vuejs Backend
     * An API Restfull use Vuejs + Laravel
     */
    
    /**
     * Get List Comments
     * Orderby: ID DESC
     * Paginate: 10
     * @return [json] [List comments]
     */
    public function apiGetIndex() {
        $comments = Comment::with(['post','user'])->orderBy('id', 'DESC')->paginate(10);
        return response()->json($comments);
    }

    /**
     * Search some comments in database
     * Search with content
     * Sort by ID DESC
     * @param  [string] $search [Keyword search]
     * @return [json]         [Comments found]
     */
    public function apiSearch($search) {
        $findComments = Comment::with(['post','user'])->orWhere('content', 'like', "%$search%")->orderBy('id', 'DESC')->paginate(10);
        return response()->json($findComments);
    }

    /**
     * Delele a comment from database
     * @param  [int] $id [id of comment need to delete]
     * @return [json]     [true or false deleted]
     */
    public function apiDelete($id) {

        $comment = Comment::findOrFail($id);
        $comment->delete($id);
        return response()->json([
            'deleted'=>true,
            'message' => 'Success remove this Category'
        ]);
    }

    public function postComment($idPost, Request $request){
        $this->validate($request,[
                    'content'=>'required|min:1|max:200',
                ],[
                    'content.required'=>'Bạn phải nhập nội dung bình luận',
                    'content.min'=>'Không thể bình luận trống',
                    'content.max'=>'Bình luận không vượt quá 200 ký tự',
                ]);

    	$comment = new Comment;
    	
    	$comment->content = $request->content;        
        
        $comment->post_id = $idPost;
        $comment->user_id = Auth::user()->id;
    	$comment->save();
    	return redirect()->back();
    }

    /**
     * Angular API Client
     * @param  [string] $slugSubCate [slug subcategory]
     * @param  [string] $slugPost    [slug post]
     * @return [json]              [comments for post]
     */
    public function apiClientGetComment($slugPost) {
        // return 'dm';
        $slugPost = (string) $slugPost;
        $findPost = Post::where('slug', $slugPost)->first();
        $comments = Comment::with(['post','user'])->orderBy('id', 'DESC')->where('post_id', $findPost->id)->paginate(8);
        return response()->json([
            'comments' => $comments
        ]);
    }

    /**
     * Angular API Client
     * @param  [string] $slugPost [Slug Post Comment]
     * @return [json]           [Success or not]
     */
    public function apiClientPostComment(Request $request, $slugPost) {

        if(strlen($request->comment_content) <= 0 || strlen($request->comment_content) >200) {
            return response()->json([
                'wrong_comment' => 'Nội dung comment không hợp lệ'
            ]);
        }

        $slugPost = (string) $slugPost;
        $findPost = Post::where('slug', $slugPost)->first();
        $comment = new Comment;

        $token = JWTAuth::getToken();
        $user = JWTAuth::toUser($token);
        
        $comment->post_id = $findPost->id;
        $comment->user_id = $user->id;
        $comment->content = $request->comment_content;
        $comment->save();

        return response()->json([
            'success' => 'Bạn vừa bình luận'
        ]);
    }
}
