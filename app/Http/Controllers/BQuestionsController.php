<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


use App\Post;
use App\Http\Requests\BQuestionRequest;
use App\BQuestion;
use DB;
use App\BData;

class BQuestionsController extends Controller
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
     * Get List Questions Posts
     * Display Posts had Questions
     * Paginate: 10
     * @return [json] [List Questions Posts]
     */
    public function apiGetIndex() {
        $questions = array();
        $posts = Post::with('question')->has('question', '>', 0)->paginate(10);
        return response()->json($posts);
    }

    /**
     * Create new Questions of a Post
     * @param  Request $request [Vuejs send data to API]
     * @return [json]           [true or false created]
     */
    public function apiCreate(Request $request) {
        $data = $request->data;
        $images = $request->images;
        $number = $request->number;
        $post_id = $request->post_id;
        $this->validate($request,
            [
                'post_id'=>'required',
                'number'=>'required',
                'content'=>'required',
                'result'=>'required'
            ],
            [
                'post_id.required' => 'Chose Post Exam',
                'number.required' => 'Input number questions',
                'content.required' => 'Input content',
                'result.required' => 'Input result'
            ]
        );
        if($number<0 || $number>90 || count($data) != $number) {
            return response()->json([
                'saved' => false,
                'message'=> 'Errors'
            ]);
        }

        for($i = 0; $i < $number; $i++) {

            if($images[$i] == null) {
                $img[$i] = '';
            } else {
                $exploded = explode(',', $images[$i]);
                $decoded = base64_decode($exploded[1]);
                $extension = str_contains($exploded[0], 'jpeg') ? 'jpg' : 'png';
                $slug = $post_id;
                $name = str_random(4)."_".$slug.'.'.$extension;
                while(file_exists("public/upload/questions/".$name)){
                    $name = str_random(4)."_".$slug.'.'.$extension;
                }
                $path = 'public/upload/questions/'.$name;
                file_put_contents($path, $decoded);
                $img[$i] = $name;
            }

            $create[$i] = array(
                'id_post' => $post_id,
                'name' => $data[$i]['name'],
                'ans_a' => $data[$i]['answer_a'],
                'ans_b' => $data[$i]['answer_b'],
                'ans_c' => $data[$i]['answer_c'],
                'ans_d' => $data[$i]['answer_d'],
                'ans_true'=> $data[$i]['answer_true'],
                'image' => $img[$i]
            );

        }

        BQuestion::insert($create);
        return response()->json([
                'saved' => true,
                'message'=> 'Success Create Questions'
            ]);
    }

    /**
     * Show all questions of post
     * @param  [int] $id [Id of post. Got from router]
     * @return [json]     [All questions of post]
     */
    public function apiShow($id) {
        $questions = BQuestion::where('id_post', $id)->get();
        return response()->json($questions);
    }

    /**
     * Update questions of post
     * @param  Request $request [Content want to update]
     * @param  [int]  $id      [Id of post need update]
     * @return [json]           [true or false updated]
     */
    public function apiUpdate(Request $request, $id) {

        $data = $request->data;
        $images = $request->images;
        $number = $request->number;
        $post_id = $id;
        $this->validate($request,
            [
                'post_id'=>'required',
                'number'=>'required',
                'content'=>'required',
                'result'=>'required'
            ],
            [
                'post_id.required' => 'Chose Post Exam',
                'number.required' => 'Input number questions',
                'content.required' => 'Input content',
                'result.required' => 'Input result'
            ]
        );
        if($number<0 || $number>90 || count($data) != $number) {
            return response()->json([
                'saved' => false,
                'message'=> 'Errors'
            ]);
        }

        $idQ = BQuestion::where('id_post',$id)->pluck('id')->toArray();
        $image_indb = BQuestion::where('id_post', $id)->pluck('image')->toArray();

        for($i = 0;$i<$number;$i++){

            $ques[$i] = $data[$i]['name'];
            $ans_a[$i] = $data[$i]['ans_a'];
            $ans_b[$i] = $data[$i]['ans_b'];
            $ans_c[$i] = $data[$i]['ans_c'];
            $ans_d[$i] = $data[$i]['ans_d'];
            $ans_true[$i] = $data[$i]['ans_true'];

            if($images[$i] == null){
                $img[$i] = $image_indb[$i];                
            }
            else{
                $exploded = explode(',', $images[$i]);
                $decoded = base64_decode($exploded[1]);
                $extension = str_contains($exploded[0], 'jpeg') ? 'jpg' : 'png';
                $slug = $post_id;
                $name = str_random(4)."_".$slug.'.'.$extension;
                while(file_exists("public/upload/questions/".$name)){
                    $name = str_random(4)."_".$slug.'.'.$extension;
                }
                $path = 'public/upload/questions/'.$name;

                if($image_indb[$i] != "" && file_exists('public/upload/questions/'.$image_indb[$i])) {
                    unlink('public/upload/questions/'.$image_indb[$i]);
                }
                file_put_contents($path, $decoded);

                $img[$i] = $name;
            }
        }


        $table = (new BQuestion)->getTable();

        $query_start = "UPDATE $table SET ";

//Moob update name
        $query_start_name = "name = CASE id ";
        $query_for_name = "";
            for($i=0;$i<$number;$i++){
                $query_for_name .= "WHEN $idQ[$i] THEN ('".addslashes($ques[$i])."') ";
            }
        $query_for_name .= " END, ";
        $query_name = $query_start_name.$query_for_name;


//Moob update a
        $query_start_ans_a = "ans_a = CASE id ";
        $query_for_ans_a = "";
            for($i=0;$i<$number;$i++){
                $query_for_ans_a .= "WHEN $idQ[$i] THEN ('".addslashes($ans_a[$i])."') ";
            }
        $query_for_ans_a .= " END, ";
        $query_a = $query_start_ans_a.$query_for_ans_a;

//Moob update b
        $query_start_ans_b = "ans_b = CASE id ";
        $query_for_ans_b = "";
            for($i=0;$i<$number;$i++){
                $query_for_ans_b .= "WHEN $idQ[$i] THEN ('".addslashes($ans_b[$i])."') ";
            }
        $query_for_ans_b .= " END, ";
        $query_b = $query_start_ans_b.$query_for_ans_b;

//Moob update c
        $query_start_ans_c = "ans_c = CASE id ";
        $query_for_ans_c = "";
            for($i=0;$i<$number;$i++){
                $query_for_ans_c .= "WHEN $idQ[$i] THEN ('".addslashes($ans_c[$i])."') ";
            }
        $query_for_ans_c .= " END, ";
        $query_c = $query_start_ans_c.$query_for_ans_c;

//Moob update d
        $query_start_ans_d = "ans_d = CASE id ";
        $query_for_ans_d = "";
            for($i=0;$i<$number;$i++){
                $query_for_ans_d .= "WHEN $idQ[$i] THEN ('".addslashes($ans_d[$i])."') ";
            }
        $query_for_ans_d .= " END, ";
        $query_d = $query_start_ans_d.$query_for_ans_d;

//Moob update true
        $query_start_ans_true = "ans_true = CASE id ";
        $query_for_ans_true = "";
            for($i=0;$i<$number;$i++){
                $query_for_ans_true .= "WHEN $idQ[$i] THEN ('".addslashes($ans_true[$i])."') ";
            }
        $query_for_ans_true .= " END, ";
        $query_true = $query_start_ans_true.$query_for_ans_true;

//Noob update image question
        $query_start_img = "image = CASE id ";
        $query_for_img = "";
            for($i=0;$i<$number;$i++){
                $query_for_img .= "WHEN $idQ[$i] THEN ('$img[$i]') ";
            }
        $query_for_img .= " END ";
        $query_img = $query_start_img.$query_for_img;

//End query
        $query_end = " WHERE id IN (".implode(',',$idQ).") ";

//Update query using Query builder RAW queries
        $query = $query_start.$query_name.$query_a.$query_b.$query_c.$query_d.$query_true.$query_img.$query_end;
        DB::statement($query);

        // return $images;

        return response()->json([
                'saved' => true,
                'message'=> 'Success Edit Questions'
            ]);

    }

    /**
     * Search some posts had questions in database
     * Search with name and description
     * Sort by ID DESC
     * @param  [string] $search [Keyword search]
     * @return [json]         [Posts found]
     */
    public function apiSearch($search) {
        $questions = array();
        $posts = Post::has('question', '>', 0)->with('question')->where('name','like',"%$search%")->orderBy('id', 'DESC')->paginate(10);
        return response()->json($posts);
    }
    /**
     * Delele all questions of post from database
     * Post must had not data test
     * @param  [int] $id [id of post need to delete]
     * @return [json]     [true or false deleted]
     */
    public function apiDelete($id) {

        $data_test = BData::where('id_post', $id)->get();

        if(count($data_test) > 0 ) {
            return response()->json([
                'deleted' => false,
                'message' => "Can't remove this Questions Exam because it has Data Test"
            ]);
        }

        $idQ = BQuestion::where('id_post',$id)->pluck('id')->toArray();
        BQuestion::whereIn('id',$idQ)->delete();
        
        return response()->json([
            'deleted'=>true,
            'message' => 'Success remove Questions Exam'
        ]);
    }
    /**
     * Delete an image of question in a post
     * @param  [int] $id [Id of question]
     * @return [json]     [true or false deleted]
     */
    public function apiDeleteImage($id) {
        $idQ = BQuestion::findOrFail($id);
        if($idQ->image == "") {
            return response()->json([
                'deleted' => false,
                'message' => "Can't remove this Question Image"
            ]);
        }
        $image = $idQ->image;
        while(file_exists("public/upload/questions/".$image)){
            unlink("public/upload/questions/".$image);
        }
        $idQ->image = "";
        $idQ->save();

        return response()->json([
                'deleted' => true,
                'message' => "Success remove this Question Image"
            ]);
    }
    
}
