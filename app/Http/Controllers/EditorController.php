<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use App\BQuestion;
use App\Comment;
use App\User;
use Illuminate\Support\Facades\Auth;

class EditorController extends Controller
{
    public function getIndex() {
    	$current_editor = Auth::id();

    	$posts = Post::with(['comment','question', 'data'])->where('author_id', $current_editor)->orderBy('id', 'DESC')->get();

        $comments = null;
        $questions = null;
        $datas = null;
        $pendingPosts = null;
        $acceptedPosts = null;
        $posts_with_questions = null;


        if(count($posts) > 0) {
            foreach($posts as $post) {
            
                foreach($post['question'] as $question) {
                    $questions[] = $question;
                }
                foreach($post['data'] as $data) {
                    $datas[] = $data;
                }
                foreach($post['comment'] as $comment) {
                    $comments[] = $comment;
                }

                $posts_with_questions[] = $post['question'];
            }

            $acceptedPosts = $posts->where('status', 1);
            $pendingPosts = $posts->where('status', 0);
        }

    	return view('editor.dashboard.index', compact(['comments', 'questions', 'datas', 'pendingPosts', 'acceptedPosts', 'posts_with_questions']));
    }
}
