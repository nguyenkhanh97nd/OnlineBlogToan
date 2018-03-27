<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\BData;
use App\Post;

class BDataController extends Controller
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
     * Get List Data test
     * Orderby: ID DESC
     * Paginate: 10
     * @return [json] [List data test]
     */
    public function apiGetIndex() {
        $bdatas = BData::with(['post.question','user'])->orderBy('id', 'DESC')->paginate(10);
        return response()->json($bdatas);
    }

    /**
     * Search some data test in database
     * Search with post id
     * Sort by ID DESC
     * @param  [string] $search [Keyword search]
     * @return [json]         [Data test found]
     */
    public function apiSearch($search) {
    	$bdatas = BData::with(['post.question','user'])->where('id_post', $search)->orderBy('id', 'DESC')->paginate(10);
        return response()->json($bdatas);
    }

    /**
     * Delele a data test from database
     * @param  [int] $id [id of data test need to delete]
     * @return [json]     [true or false deleted]
     */
    public function apiDelete($id) {

        $bdata = BData::findOrFail($id);
        $bdata->delete($id);
        return response()->json([
            'deleted'=>true,
            'message' => 'Success remove this Data Test'
        ]);
    }
}
