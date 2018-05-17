<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\SubCateQuestion;
use App\CateQuestion;
use App\CommentFeed;
use App\Feed;

class SubCateQuestionController extends Controller
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
     * Get List Sub Cate Question
     * Orderby: ID DESC
     * Paginate: 10
     * @return [json] [List Sub Cate Question]
     */
    public function apiGetIndex() {
        $subcate = SubCateQuestion::with('cate_question')->orderBy('id', 'DESC')->paginate(10);
        return response()->json($subcate);
    }

    /**
     * Create new  Sub Cate Question
     * @param  Request $request [Vuejs send data to API]
     * @return [json]           [true or false created]
     */
    public function apiCreate(Request $request) {
        $this->validate($request,
            [   'name'=>'required',
                'slug'=>'required|unique:sub_cate_questions,slug',
                'id_cate_question'=>'required',
                'description'=>'required'
            ],
            [   'name.required' => '* Input name',
                'slug.required' => '* Input slug',
                'slug.unique' => '* Slug Sub Cate Question exits',
                'id_cate_question.required' => '* Chose Cate Question',
                'description.required' => '* Input descriptions'
            ]
        );
        $subcate = new SubCateQuestion();
        $subcate->name = $request->name;
        $subcate->slug = $request->slug;
        $subcate->id_cate_question = $request->id_cate_question;
        $subcate->description = $request->description;
        $subcate->save();

        return response()->json([
            'saved' => true
        ]);
    }

    /**
     * Show information of sub cate question
     * @param  [int] $id [Id of sub cate question. Got from router]
     * @return [json]     [Information of sub cate question]
     */
    public function apiShow($id) {
        $subcate = SubCateQuestion::findOrFail($id);
        return response()->json($subcate);
    }

    /**
     * Update information of sub cate question
     * @param  Request $request [Information want to update]
     * @param  [int]  $id      [Id of sub cate question need update]
     * @return [json]           [true or false updated]
     */
    public function apiUpdate(Request $request, $id) {
        $this->validate($request,
            [   'name'=>'required',
                'id_cate_question'=>'required',
                'description'=>'required'
            ],
            [   'name.required' => '* Input name',
                'id_cate_question.required' => '* Chose Category',
                'description.required' => '* Input descriptions'
            ]
        );
        $edit = SubCateQuestion::findOrFail($id);
        $edit->name = $request->name;
        $edit->id_cate_question = $request->id_cate_question;
        $edit->description = $request->description;
        $edit->save();
        return response()->json([
            'saved' => true
        ]);
    }


    /**
     * Delele a sub cate question from database
     * Category must had not post (posts)
     * @param  [int] $id [id of sub cate question need to delete]
     * @return [json]     [true or false deleted]
     */
    public function apiDelete($id) {

        $subcate = SubCateQuestion::findOrFail($id);
        $feeds = Feed::where('id_sub_cate_question', $id)->get();
        if(count($feeds) > 0) {
            return response()->json([
                'delete' => false,
                'message' => "Can't remove this Sub Cate Question because it has some Feed"
            ]);
        }
        $subcate->delete($id);
        return response()->json([
            'deleted'=>true,
            'message' => 'Success remove this Sub Cate Question'
        ]);
    }

    /**
     * Search some sub cate question in database
     * Search with name and description
     * Sort by ID DESC
     * @param  [string] $search [Keyword search]
     * @return [json]         [sub cate question found]
     */
    public function apiSearch($search) {
        $fingSubcate = SubCateQuestion::with('cate_question')->where('name','like',"%$search%")->orWhere('description', 'like', "%$search%")->orderBy('id', 'DESC')->paginate(10);
        return response()->json($fingSubcate);
    }

    /**
     * API Angular Client
     * @param  [string] $slugSubCate [Slug Sub cate question]
     * @return [json]           [sub cate question]
     */
    public function apiClientGetFeedSubCate(Request $request, $slugSubCate) {

        $sort_key = (string) $request->sort_key;

        $subCate = SubCateQuestion::where('slug', $slugSubCate)->firstOrFail();

        if($sort_key === 'point') {

            $feeds = Feed::with(['sub_cate_question.cate_question', 'user', 'comment_feed'])
                    ->where('id_sub_cate_question', $subCate->id)
                    ->orderBy('point_feed', 'DESC')
                    ->paginate(10);
        } else if($sort_key === 'unans') {

            $comment_feeds = CommentFeed::where('status', 1)->pluck('id_feed','id_feed')->toArray();

            $feeds = Feed::with(['sub_cate_question.cate_question', 'user', 'comment_feed'])
                    ->where('id_sub_cate_question', $subCate->id)
                    ->whereNotIn('id', $comment_feeds)
                    ->orderBy('id', 'DESC')
                    ->paginate(10);

        } else {

            $feeds = Feed::with(['sub_cate_question.cate_question', 'user', 'comment_feed'])
                    ->where('id_sub_cate_question', $subCate->id)
                    ->orderBy('id', 'DESC')
                    ->paginate(10);

        }

        return response()->json([
            'feeds' => $feeds,
        ]);
    }
}
