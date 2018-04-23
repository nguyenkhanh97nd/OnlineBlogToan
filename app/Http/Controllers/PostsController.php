<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

/*-- Quản lí user --*/
use Illuminate\Support\Facades\Auth;
use App\Post;

use App\Category;
use App\SubCategory;
use App\Comment;
use App\BQuestion;
use App\Http\Requests\PostRequest;
use Mail;

class PostsController extends Controller
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
     * Get List posts
     * Orderby: ID DESC
     * Paginate: 10
     * @return [json] [List posts]
     */
    public function apiGetIndex() {
        $posts = Post::with(['subcategory.category','author','question'])->where('status', 1)->orderBy('id', 'DESC')->paginate(10);
        return response()->json($posts);
    }

    /**
     * Create new post
     * @param  Request $request [Vuejs send data to API]
     * @return [json]           [true or false created]
     */
    public function apiCreate(Request $request) {

        $this->validate($request,
            [   'name'=>'required',
                'slug'=>'required|unique:posts,slug',
                'category_id'=>'required',
                'subcategory_id'=>'required',
                'time_start' =>'required',
                'time_do'=>'required',
                'brief'=>'required',
                'content'=>'required',
                'image'=>'required',
                'status'=>'required'
            ],
            [   'name.required' => '* Input name',
                'slug.required' => '* Input slug',
                'slug.unique' => '* Slug post exist',
                'category_id.required'=> '* Chose category',
                'subcategory_id.required' => '* Chose sub category',
                'time_start.required'=>'* Input time start',
                'time_do.required'=>'* Input time do',
                'brief.required' => '* Input brief',
                'content.required' => '* Input content',
                'image.required'=>'* Input image',
                'status.required'=>'* Input status'

            ]
        );
        
        $post = new Post;
        $post->subcategory_id = $request->subcategory_id;
        $post->name = $request->name;
        $post->slug = $request->slug;
        $post->brief = $request->brief;
        $post->content = $request->content;
        $post->author_id = 1;                            // To do later
        $post->time_start = $request->time_start;
        $post->time_do = $request->time_do;
        $post->status = $request->status;


        $exploded = explode(',', $request->image_upload);
        $decoded = base64_decode($exploded[1]);

        $extension = str_contains($exploded[0], 'jpeg') ? 'jpg' : 'png';

        $slug = $request->slug;
        $name = str_random(4)."_".$slug.'.'.$extension;
        while(file_exists("upload/posts/".$name)){
            $name = str_random(4)."_".$slug.'.'.$extension;
        }
        $path = 'upload/posts/'.$name;
        file_put_contents($path, $decoded);

        $post->image = $name;

        $post->save();

        // Send mail Admin notification
        
        $data = array();

        $data['email'] = 'nguyenkhanh97nd@gmail.com';   // TODO: later
        $data['title'] = 'Bài viết mới trên Blog Toán';
        $data['post_name'] = $post->name;
        $data['status'] = $post->status;
        $data['subcategory'] = $post->subcategory->slug;
        $data['slug'] = $post->slug;

        Mail::send('admin.mail.posts.create', $data, function($message) use ($data){
                $message->from('blogtoan.com@gmail.com', 'Blog Toán');
                $message->subject('Bạn vừa tạo bài viết mới trên Blog Toán');
                $message->to($data['email']);
            });

        return response()->json([
            'saved' => true,
            'message'=>'Success Create New Post!'
        ]);
    }

    /**
     * Show information of post
     * @param  [int] $id [Id of post. Got from router]
     * @return [json]     [Information of post]
     */
    public function apiShow($id) {
        $post = Post::with(['subcategory'])->where('status', 1)->findOrFail($id);
        return response()->json($post);
    }

    /**
     * Update information of post
     * @param  Request $request [Information want to update]
     * @param  [int]  $id      [Id of post need update]
     * @return [json]           [true or false updated]
     */
    public function apiUpdate(Request $request, $id) {
        $this->validate($request,
            [   'name'=>'required',
                'category_id'=>'required',
                'subcategory_id'=>'required',
                'time_start' =>'required',
                'time_do'=>'required',
                'brief'=>'required',
                'content'=>'required',
                'status'=>'required'
            ],
            [   'name.required' => '* Input name',
                'category_id.required'=> '* Chose category',
                'subcategory_id.required' => '* Chose sub category',
                'time_start.required'=>'* Input time start',
                'time_do.required'=>'* Input time do',
                'brief.required' => '* Input brief',
                'content.required' => '* Input content',
                'status.required'=>'* Input status'

            ]
        );
        $edit = Post::with(['subcategory','author'])->findOrFail($id);

        $mail_status = $edit->status;

        $edit->subcategory_id = $request->subcategory_id;
        $edit->name = $request->name;
        $edit->slug = $request->slug;
        $edit->brief = $request->brief;
        $edit->content = $request->content;
        $edit->author_id = $edit->author->id;
        $edit->time_start = $request->time_start;
        $edit->time_do = $request->time_do;
        $edit->status = $request->status;

        if($request->image == 'filled') {
            $exploded = explode(',', $request->image_upload);
            $decoded = base64_decode($exploded[1]);

            $extension = str_contains($exploded[0], 'jpeg') ? 'jpg' : 'png';

            $slug = $request->slug;
            $name = str_random(4)."_".$slug.'.'.$extension;
            while(file_exists("upload/posts/".$name)){
                $name = str_random(4)."_".$slug.'.'.$extension;
            }
            $path = 'upload/posts/'.$name;
            unlink('upload/posts/'.$edit->image);
            file_put_contents($path, $decoded);

            $edit->image = $name;
        }
        $edit->save();

        if($mail_status != $edit->status) {

            if($mail_status == 1) $title = 'Bài viết bị gỡ bỏ trên Blog Toán';
            if($mail_status == 0) $title = 'Bài viết được chấp thuận trên Blog Toán';

            $data = array();

            $data['email'] = $edit->author->email;
            $data['title'] = $title;
            $data['post_name'] = $edit->name;
            $data['status'] = $edit->status;
            $data['subcategory'] = $edit->subcategory->slug;
            $data['slug'] = $edit->slug;

            Mail::send('admin.mail.posts.edit', $data, function($message) use ($data){
                    $message->from('blogtoan.com@gmail.com', 'Blog Toán');
                    $message->subject('Bạn có bài viết thay đổi trạng thái trên Blog Toán');
                    $message->to($data['email']);
                });

        }

        return response()->json([
            'saved' => true,
            'message' => 'Success Edit Post'
        ]);
    }

    /**
     * Delele a post from database
     * Post must had not comment (comments)
     * @param  [int] $id [id of post need to delete]
     * @return [json]     [true or false deleted]
     */
    public function apiDelete($id) {

        $post = Post::with(['author'])->findOrFail($id);

        $data = array();

        $data['email'] = $post->author->email;
        $data['title'] = 'Bài viết bị xoá trên Blog Toán';
        $data['post_name'] = $post->name;

        $comment = Comment::where('post_id', $id)->get();
        $question = BQuestion::where('id_post', $id)->get();

        if(count($comment) > 0 || count($question) >0) {
            return response()->json([
                'deleted' => false,
                'message' => "Can't remove this Post because it has questions or comments"
            ]);
        }
        unlink('upload/posts/'.$post->image);

        $post->delete($id);

        Mail::send('admin.mail.posts.delete', $data, function($message) use ($data){
                $message->from('blogtoan.com@gmail.com', 'Blog Toán');
                $message->subject('Bài viết bị xoá trên Blog Toán');
                $message->to($data['email']);
            });

        return response()->json([
            'deleted'=>true,
            'message' => 'Success remove this Post'
        ]);
    }


    /**
     * Search some posts in database
     * Search with name and description
     * Sort by ID DESC
     * @param  [string] $search [Keyword search]
     * @return [json]         [Posts found]
     */
    public function apiSearch($search) {
        $findPosts = Post::with(['subcategory.category','author'])->where('name','like',"%$search%")->orWhere('brief', 'like', "%$search%")->orWhere('content', 'like', "%$search%")->orderBy('id', 'DESC')->paginate(10);
        return response()->json($findPosts);
    }




    /**
     * API use Vuejs Backend
     * An API Restfull use Vuejs + Laravel
     */
    
    /**
     * Get List Pending Posts
     * Orderby: ID DESC
     * Paginate: 10
     * @return [json] [List pending posts]
     */
    public function apiGetPendingIndex() {
        $posts = Post::with(['subcategory.category','author'])->where('status', 0)->orderBy('id', 'DESC')->paginate(10);
        return response()->json($posts);
    }

    /**
     * Show information of pending post
     * @param  [int] $id [Id of pending post. Got from router]
     * @return [json]     [Information of pending post]
     */
    public function apiPendingShow($id) {
        $post = Post::with(['subcategory'])->where('status', 0)->findOrFail($id);
        return response()->json($post);
    }

    /**
     * Update information of pending post
     * @param  Request $request [Information want to update]
     * @param  [int]  $id      [Id of pending post need update]
     * @return [json]           [true or pending post updated]
     */
    public function apiPendingUpdate(Request $request, $id) {
        $this->validate($request,
            [   'name'=>'required',
                'category_id'=>'required',
                'subcategory_id'=>'required',
                'time_start' =>'required',
                'time_do'=>'required',
                'brief'=>'required',
                'content'=>'required',
                'status'=>'required'
            ],
            [   'name.required' => '* Input name',
                'category_id.required'=> '* Chose category',
                'subcategory_id.required' => '* Chose sub category',
                'time_start.required'=>'* Input time start',
                'time_do.required'=>'* Input time do',
                'brief.required' => '* Input brief',
                'content.required' => '* Input content',
                'status.required'=>'* Input status'

            ]
        );
        $edit = Post::with(['subcategory','author'])->where('status', 0)->findOrFail($id);

        $mail_status = $edit->status;

        $edit->subcategory_id = $request->subcategory_id;
        $edit->name = $request->name;
        $edit->slug = $request->slug;
        $edit->brief = $request->brief;
        $edit->content = $request->content;
        $edit->author_id = $edit->author->id;
        $edit->time_start = $request->time_start;
        $edit->time_do = $request->time_do;
        $edit->status = $request->status;

        if($request->image == 'filled') {
            $exploded = explode(',', $request->image_upload);
            $decoded = base64_decode($exploded[1]);

            $extension = str_contains($exploded[0], 'jpeg') ? 'jpg' : 'png';

            $slug = $request->slug;
            $name = str_random(4)."_".$slug.'.'.$extension;
            while(file_exists("upload/posts/".$name)){
                $name = str_random(4)."_".$slug.'.'.$extension;
            }
            $path = 'upload/posts/'.$name;
            unlink('upload/posts/'.$edit->image);
            file_put_contents($path, $decoded);

            $edit->image = $name;
        }
        $edit->save();

        if($mail_status != $edit->status) {

            if($mail_status == 1) $title = 'Bài viết bị gỡ bỏ trên Blog Toán';
            if($mail_status == 0) $title = 'Bài viết được chấp thuận trên Blog Toán';

            $data = array();

            $data['email'] = $edit->author->email;
            $data['title'] = $title;
            $data['post_name'] = $edit->name;
            $data['status'] = $edit->status;
            $data['subcategory'] = $edit->subcategory->slug;
            $data['slug'] = $edit->slug;

            Mail::send('admin.mail.posts.edit', $data, function($message) use ($data){
                    $message->from('blogtoan.com@gmail.com', 'Blog Toán');
                    $message->subject('Bạn có bài viết thay đổi trạng thái trên Blog Toán');
                    $message->to($data['email']);
                });

        }

        return response()->json([
            'saved' => true,
            'message' => 'Success Change Pending Post'
        ]);
    }

    /**
     * Delele a pending post from database
     * Category must had not comment or question (comments or questions)
     * @param  [int] $id [id of pending post need to delete]
     * @return [json]     [true or false deleted]
     */
    public function apiPendingDelete($id) {

        $post = Post::with(['author'])->where('status', 0)->findOrFail($id);

        $data = array();

        $data['email'] = $post->author->email;
        $data['title'] = 'Bài viết bị xoá trên Blog Toán';
        $data['post_name'] = $post->name;

        $comment = Comment::where('post_id', $id)->get();
        $question = BQuestion::where('id_post', $id)->get();

        if(count($comment) > 0 || count($question) >0) {
            return response()->json([
                'deleted' => false,
                'message' => "Can't remove this Pending Post because it has questions or comments"
            ]);
        }
        unlink('upload/posts/'.$post->image); 
        $post->delete($id);

        Mail::send('admin.mail.posts.delete', $data, function($message) use ($data){
                $message->from('blogtoan.com@gmail.com', 'Blog Toán');
                $message->subject('Bài viết bị xoá trên Blog Toán');
                $message->to($data['email']);
            });

        return response()->json([
            'deleted'=>true,
            'message' => 'Success remove this Pending Post'
        ]);
    }

    /**
     * Search some pending posts in database
     * Search with name and description
     * Sort by ID DESC
     * @param  [string] $search [Keyword search]
     * @return [json]         [Pending posts found]
     */
    public function apiPendingSearch($search) {
        $findPosts = Post::where('status', 0)->with(['subcategory.category','author'])->where('name','like',"%$search%")->orWhere('brief', 'like', "%$search%")->orWhere('content', 'like', "%$search%")->orderBy('id', 'DESC')->paginate(10);
        return response()->json($findPosts);
    }


    /**
     * API Client
     * @return [json] [List Posts]
     */
    public function apiClientGetPosts() {
        $listActivePosts = Post::with(['subcategory','author'])->where('status', 1)->orderBy('created_at','DESC')->paginate(8);
        $listFeaturePosts = Post::with(['subcategory'])->where('status', 1)->orderBy('count_views', 'DESC')->take(5)->get();
        return response()->json([
            'posts' => $listActivePosts,
            'featurePosts' => $listFeaturePosts,

        ]);
    }

    /**
     * API Client
     * @param  [string] $slugSubCate [slug sub category]
     * @param  [string] $slugPost    [slug post]
     * @return [json]              [post found]
     */
    public function apiClientGetPost($slugSubCate, $slugPost) {
        $subcategory = SubCategory::where('slug',$slugSubCate)->firstOrFail();
        $post = Post::with(['subcategory.category', 'author'])->where('status', 1)->where('subcategory_id', $subcategory->id)->where('slug', $slugPost)->firstOrFail();
        $count = $post->count_views;
        $count = $count + 1;
        $post->count_views = $count;
        $post->update();

        $same_posts = Post::with(['subcategory.category', 'author'])->where('status', 1)->where('subcategory_id', $subcategory->id)->where('id', '<>', $post->id)->orderBy('id', 'DESC')->take(10)->get();

        $testonline = false;
        $bquestions = BQuestion::where('id_post', $post->id)->get();
        if(count($bquestions) > 0) {
            $testonline = true;
        }

        return response()->json([
            'post' => $post,
            'same_posts' => $same_posts,
            'testonline' => $testonline
        ]);
    }

    /**
     * API Client
     * @param  [string] $search [search keyword]
     * @return [json]         [posts]
     */
    public function apiClientPostSearch(Request $request) {

        $search = (string) $request->keyword;

        $findPosts = Post::with(['subcategory.category','author'])->where('name','like',"%$search%")->orWhere('brief', 'like', "%$search%")->orWhere('content', 'like', "%$search%")->orderBy('id', 'DESC')->paginate(8);
        return response()->json([
            'posts' => $findPosts
        ]);
    }

}
