<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\CateQuestion;
use App\SubCateQuestion;
use App\CommentFeed;
use App\Feed;
use DB;

class CateQuestionController extends Controller
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
     * Get List Cate Questions
     * Orderby: ID DESC
     * Paginate: 10
     * @return [json] [List cate Questions]
     */
    public function apiGetIndex() {
        $catequestions = CateQuestion::with('sub_cate_question')->orderBy('id', 'DESC')->paginate(10);
        return response()->json($catequestions);
    }

    /**
     * Create new Cate Question
     * @param  Request $request [Vuejs send data to API]
     * @return [json]           [true or false created]
     */
    public function apiCreate(Request $request) {

        $this->validate($request,
            [   'name'=>'required',
                'slug'=>'required|unique:cate_questions,slug',
                'description'=>'required'
            ],
            [   'name.required' => '* Input name',
                'slug.required' => '* Input slug',
                'slug.unique' => '* Slug Cate Question exits',
                'description.required' => '* Input descriptions'
            ]
        );
        $cate = new CateQuestion();
        $cate->name = $request->name;
        $cate->slug = $request->slug;
        $cate->description = $request->description;
        $cate->save();

        return response()->json([
            'saved' => true
        ]);
    }

    /**
     * Show information of cate question
     * @param  [int] $id [Id of cate question. Got from router]
     * @return [json]     [Information of cate question]
     */
    public function apiShow($id) {
        $cate = CateQuestion::with('sub_cate_question')->findOrFail($id);
        return response()->json($cate);
    }

    /**
     * Update information of category
     * @param  Request $request [Information want to update]
     * @param  [int]  $id      [Id of category need update]
     * @return [json]           [true or false updated]
     */
    public function apiUpdate(Request $request, $id) {
        $this->validate($request,
            [   'name'=>'required',
                'description'=>'required'
            ],
            [   'name.required' => '* Input name',
                'description.required' => '* Input descriptions'
            ]
        );
        $edit = CateQuestion::findOrFail($id);
        $edit->name = $request->name;
        $edit->description = $request->description;
        $edit->save();
        return response()->json([
            'saved' => true
        ]);
    }

    /**
     * Delele a cate question from database
     * Category must had not sub cate question (subcatequestions)
     * @param  [int] $id [id of category need to delete]
     * @return [json]     [true or false deleted]
     */
    public function apiDelete($id) {

        $cate = CateQuestion::findOrFail($id);
        $subcate = SubCateQuestion::where('id_cate_question', $id)->get();
        if(count($subcate) > 0) {
            return response()->json([
                'delete' => false,
                'message' => "Can't remove this Cate Question because it has some Sub Cate Question"
            ]);
        }
        $cate->delete($id);
        return response()->json([
            'deleted'=>true,
            'message' => 'Success remove this Cate Question'
        ]);
    }

    /**
     * Search some cate question in database
     * Search with name and description
     * Sort by ID DESC
     * @param  [string] $search [Keyword search]
     * @return [json]         [cate question found]
     */
    public function apiSearch($search) {
        $findCate = CateQuestion::where('name','like',"%$search%")->orWhere('description', 'like', "%$search%")->orderBy('id', 'DESC')->paginate(10);
        return response()->json($findCate);
    }

    /**
     * API Angular Client
     * @param  [string] $slugCate [Slug category]
     * @return [json]           [category]
     */
    public function apiClientGetAllCate() {
        $cate = CateQuestion::with('sub_cate_question')->get();
        return response()->json($cate);
    }

    public function apiClientGetFeedCate(Request $request, $slugCate) {

        $sort_key = (string) $request->sort_key;

        $slugCate = (string) $slugCate;
        $cate = CateQuestion::where('slug', $slugCate)->firstOrFail();
        $subcatequestion = SubCateQuestion::where('id_cate_question', $cate->id)->get();
        $subcate = SubCateQuestion::where('id_cate_question', $cate->id)->pluck('id')->toArray();


        if($sort_key === 'point') {
            $feeds = Feed::with(['user', 'comment_feed', 'sub_cate_question.cate_question'])
                            ->whereIn('id_sub_cate_question', $subcate)
                            ->where('status', 1)
                            ->orderBy('point_feed', 'DESC')
                            ->paginate(10);
        } else if($sort_key === 'unans') {

            $comment_feeds = CommentFeed::where('status', 1)->pluck('id_feed','id_feed')->toArray();

            $feeds = Feed::with(['user', 'comment_feed', 'sub_cate_question.cate_question'])
                            ->whereIn('id_sub_cate_question', $subcate)
                            ->whereNotIn('id', $comment_feeds)
                            ->where('status', 1)
                            ->orderBy('id', 'DESC')
                            ->paginate(10);
        } else {
            $feeds = Feed::with(['user', 'comment_feed', 'sub_cate_question.cate_question'])
                            ->whereIn('id_sub_cate_question', $subcate)
                            ->where('status', 1)
                            ->orderBy('id', 'DESC')
                            ->paginate(10);
        }   
        return response()->json([
            'feeds' => $feeds,
            'subcatequestion' => $subcatequestion
        ]);
    }
}
