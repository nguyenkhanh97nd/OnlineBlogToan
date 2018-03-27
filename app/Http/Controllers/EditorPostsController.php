<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

/*-- Quản lí user --*/
use Illuminate\Support\Facades\Auth;

use App\Post;
use App\Category;
use App\SubCategory;
use App\Http\Requests\EditorPostRequest;


class EditorPostsController extends Controller
{
    public function getAdd() {
    	$category = Category::where('status', 1)->get();
    	$subcategory = SubCategory::all();
    	return view('editor.posts.add',compact(['category','subcategory']));
    }

    public function postAdd(EditorPostRequest $request) {

    	$postAdd = new Post;
        $postAdd->subcategory_id = $request->subcategory;
        $postAdd->name = $request->txtName;
        $postAdd->slug = $request->txtSlug;
        $postAdd->brief = $request->txtBrief;
        $postAdd->content = $request->txtContent;
        $postAdd->author_id = Auth::user()->id;
        $postAdd->time_start = $request->time_start;
        $postAdd->time_do = $request->time_do;
        $postAdd->status = 0;


        $file = $request->file('image');
        $extension = $file->getClientOriginalExtension();

        $slug = $request->txtSlug;
        $image = str_random(4)."_".$slug.'.'.$extension;

        while(file_exists("upload/posts/".$image)){
            $image = str_random(4)."_".$slug.'.'.$extension;
        }

        $file->move("upload/posts",$image);

        $postAdd->image = $image;


        $postAdd->save();

        return redirect()->route('editor.posts.getList')->with(['flash_level'=>'success','flash_message'=>'Success Add Post']);

    }

    public function getList() {

    	$listEditorPosts = Post::where('author_id', Auth::id())->get();
    	return view('editor.posts.list',compact(['listEditorPosts']));

    }

    public function getEdit($slug) {

        $slug = (string) $slug;

    	$category = Category::all();
        $subcategory = SubCategory::all();

        $findPost = Post::where('author_id', Auth::id())->where('slug',$slug)->first();

        if(count($findPost) == 0) {
            return view('pages.errors');
        }

        return view('editor.posts.edit',compact(['findPost','category','subcategory']));
    }

    public function postEdit(Request $request, $slug) {

        $slug = (string) $slug;

        $findPost = Post::where('author_id', Auth::id())->where('slug',$slug)->first();

        if(count($findPost) == 0) {
            return view('pages.errors');
        }

    	$this->validate($request,
            ['category'=>'required',
            'subcategory'=>'required',
            'txtName'=>'required|',
            'txtSlug'=>'required',
            'txtBrief'=>'required',
            'txtContent'=>'required',
            ],
            ['category.required'=>'Chose category',
            'subcategory.required'=>'Chose sub category',
            'txtName.required'=>'Input name post',
            'txtSlug.required'=>'Input slug post',
            'txtBrief.required'=>'Input brief post',
            'txtContent.required'=>'Input content post',
            ]
        );

        $edit = Post::where('author_id', Auth::id())->where('slug',$slug)->first();
        $edit->subcategory_id = $request->subcategory;
        $edit->name = $request->txtName;
        $edit->slug = $request->txtSlug;
        $edit->brief = $request->txtBrief;
        $edit->content = $request->txtContent;
        $edit->author_id = Auth::user()->id;
        $edit->time_start = $request->time_start;
        $edit->time_do = $request->time_do;
        

        if($request->hasFile('image')){
            $file = $request->file('image');

            $extension = $file->getClientOriginalExtension();

            $slug = $request->txtSlug;
            $image = str_random(4)."_".$slug.'.'.$extension;

            while(file_exists("upload/posts/".$image)){
                $image = str_random(4)."_".$slug.'.'.$extension;
            }
            $file->move("upload/posts",$image);

            if(file_exists('upload/posts/'.$edit->image)) {
                unlink('upload/posts/'.$edit->image);
            }

            $edit->image = $image;

        }
        else{

        }
        
        $edit->save();
        return redirect()->route('editor.posts.getList')->with(['flash_level'=>'success','flash_message'=>'Success Edit Post']);
    }

    public function getDelete($slug) {

        $slug = (string) $slug;

    	$findPost = Post::where('author_id', Auth::id())->where('slug',$slug)->first();

        if(count($findPost) == 0) {
            return view('pages.errors');
        }
        if(file_exists('upload/posts/'.$findPost->image)) {
            unlink('upload/posts/'.$findPost->image);
        }
        $findPost->delete($findPost->id);
        return redirect()->route('editor.posts.getList')->with(['flash_level'=>'success','flash_message'=>'Success Delete Post']);

    }
}
