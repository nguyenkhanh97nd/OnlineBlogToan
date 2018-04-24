<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

/*-- Quản lí user --*/
use Illuminate\Support\Facades\Auth;

use App\Post;
use App\BQuestion;
use App\Http\Requests\EditorBQuestionRequest;
use DB;


class EditorBQuestionsController extends Controller
{
    public function getAdd(){
    	$posts = Post::where('author_id', Auth::id())->get();
    	return view('editor.questions.add',compact('posts'));
    }
    public function getList(){
        $listPost = Post::where('author_id', Auth::id())->get();
    	return view('editor.questions.list',compact('listPost'));
    }
    public function getEdit($slug){

        $slug = (string) $slug;

        $posts = Post::where('author_id', Auth::id())->get();
        $findPost = Post::where('author_id', Auth::id())->where('slug',$slug)->first();

        if(count($findPost) == 0) {
            return view('pages.errors');
        }
    	return view('editor.questions.edit',compact(['posts','findPost']));
    }

    public function postAdd(EditorBQuestionRequest $request){
    	
        $temp = $request->all();
            
        for($i = 0;$i<$temp['quess'];$i++){
            $ques[] = $temp['ques-'.$i];
            $ans_a[] = $temp['ans-a'.$i];
            $ans_b[] = $temp['ans-b'.$i];
            $ans_c[] = $temp['ans-c'.$i];
            $ans_d[] = $temp['ans-d'.$i];
            $ans_true[] = $temp['ans-true'.$i];

            if( $request->file('img-'.$i) != NULL){
                $file = $request->file('img-'.$i);

                $extension = $file->getClientOriginalExtension();
                $id = $request->id_post;

                $image = $id."_".str_random(4)."_".($i+1).".".$extension;

                while(file_exists("public/upload/questions/".$image)){
                    $image = $id."_".str_random(4)."_".($i+1).".".$extension;
                }

                $file->move("public/upload/questions",$image);

                $img[] = $image;
            }
            else{
                $img[] = '';
            }
            
        }

        for($i=0;$i<$temp['quess'];$i++){
            $data[$i] = array(
                'id_post'=>$request->id_post,
                'name'=>$ques[$i],
                'ans_a'=>$ans_a[$i],
                'ans_b'=>$ans_b[$i],
                'ans_c'=>$ans_c[$i],
                'ans_d'=>$ans_d[$i],
                'ans_true'=>$ans_true[$i],
                'image'=> $img[$i]
            );
        }
        BQuestion::insert($data);
        return redirect()->route('editor.questions.getList')->with(['flash_level'=>'success','flash_message'=>'Succes Add Questions Exam']);
        
	}
    public function postEdit(EditorBQuestionRequest $request, $slug){

        $slug = (string) $slug;

        $findPost = Post::where('author_id', Auth::id())->where('slug', $slug)->first();

        $id = $findPost->id;

        if(count($findPost) == 0) {
            return view('pages.errors');
        }

        $temp = $request->all();
         
        for($i = 0;$i<$temp['quess'];$i++){
            $ques[] = $temp['ques-'.$i];
            $ans_a[] = $temp['ans-a'.$i];
            $ans_b[] = $temp['ans-b'.$i];
            $ans_c[] = $temp['ans-c'.$i];
            $ans_d[] = $temp['ans-d'.$i];
            $ans_true[] = $temp['ans-true'.$i];

            $image_indb = BQuestion::where('id_post',$id)->pluck('image')->get($i);
            if( $request->file('img-'.$i) != NULL){
                $file = $request->file('img-'.$i);

                $extension = $file->getClientOriginalExtension();

                $image = $id."_".str_random(4)."_".($i+1).".".$extension;

                while(file_exists("public/upload/questions/".$image)){
                    $image = $id."_".str_random(4)."_".($i+1).".".$extension;
                }

                if( $image_indb != NULL ) {
                    if(file_exists('public/upload/questions/'.$image_indb)) {
                        unlink('public/upload/questions/'.$image_indb);
                    }
                }

                $file->move("public/upload/questions",$image);
                $img[] = $image;
            }
            else{
                $img[] = $image_indb;
            }
        }
        

        $table = (new BQuestion)->getTable();
        $idQ = BQuestion::where('id_post',$id)->pluck('id')->toArray();


        $query_start = "UPDATE $table SET ";

//Moob update name
        $query_start_name = "name = CASE id ";
        $query_for_name = "";
            for($i=0;$i<$temp['quess'];$i++){
                $query_for_name .= "WHEN $idQ[$i] THEN '$ques[$i]' ";
            }
        $query_for_name .= " END, ";
        $query_name = $query_start_name.$query_for_name;


//Moob update a
        $query_start_ans_a = "ans_a = CASE id ";
        $query_for_ans_a = "";
            for($i=0;$i<$temp['quess'];$i++){
                $query_for_ans_a .= "WHEN $idQ[$i] THEN '$ans_a[$i]' ";
            }
        $query_for_ans_a .= " END, ";
        $query_a = $query_start_ans_a.$query_for_ans_a;

//Moob update b
        $query_start_ans_b = "ans_b = CASE id ";
        $query_for_ans_b = "";
            for($i=0;$i<$temp['quess'];$i++){
                $query_for_ans_b .= "WHEN $idQ[$i] THEN '$ans_b[$i]' ";
            }
        $query_for_ans_b .= " END, ";
        $query_b = $query_start_ans_b.$query_for_ans_b;

//Moob update c
        $query_start_ans_c = "ans_c = CASE id ";
        $query_for_ans_c = "";
            for($i=0;$i<$temp['quess'];$i++){
                $query_for_ans_c .= "WHEN $idQ[$i] THEN '$ans_c[$i]' ";
            }
        $query_for_ans_c .= " END, ";
        $query_c = $query_start_ans_c.$query_for_ans_c;

//Moob update d
        $query_start_ans_d = "ans_d = CASE id ";
        $query_for_ans_d = "";
            for($i=0;$i<$temp['quess'];$i++){
                $query_for_ans_d .= "WHEN $idQ[$i] THEN '$ans_d[$i]' ";
            }
        $query_for_ans_d .= " END, ";
        $query_d = $query_start_ans_d.$query_for_ans_d;

//Moob update true
        $query_start_ans_true = "ans_true = CASE id ";
        $query_for_ans_true = "";
            for($i=0;$i<$temp['quess'];$i++){
                $query_for_ans_true .= "WHEN $idQ[$i] THEN '$ans_true[$i]' ";
            }
        $query_for_ans_true .= " END, ";
        $query_true = $query_start_ans_true.$query_for_ans_true;

//Noob update image question
        $query_start_img = "image = CASE id ";
        $query_for_img = "";
            for($i=0;$i<$temp['quess'];$i++){
                $query_for_img .= "WHEN $idQ[$i] THEN '$img[$i]' ";
            }
        $query_for_img .= " END ";
        $query_img = $query_start_img.$query_for_img;

//End query
        $query_end = " WHERE id IN (".implode(',',$idQ).") ";

//Update query using Query builder RAW queries
        $query = $query_start.$query_name.$query_a.$query_b.$query_c.$query_d.$query_true.$query_img.$query_end;
        DB::statement($query);
                
        
        return redirect()->route('editor.questions.getList')->with(['flash_level'=>'success','flash_message'=>'Success Edit Questions Exam']);

    }

    public function getDelete($slug){

        $slug = (string) $slug;

        $findPost = Post::where('author_id', Auth::id())->where('slug', $slug)->first();

        if(count($findPost) == 0) {
            return view('pages.errors');
        }

        $idQ = BQuestion::where('id_post',$findPost->id)->pluck('id')->toArray();
 
        BQuestion::whereIn('id',$idQ)->delete();
        return redirect()->route('editor.questions.getList')->with(['flash_level'=>'success','flash_message'=>'Success Delete Questions Exam']);

    }

}
