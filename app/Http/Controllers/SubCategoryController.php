<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\SubCategory;
use App\Category;
use App\Post;
use App\Http\Requests\SubCategoryRequest;

class SubCategoryController extends Controller
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
     * Get List SubCategories
     * Orderby: ID DESC
     * Paginate: 10
     * @return [json] [List subcategories]
     */
    public function apiGetIndex() {
        $subcategories = SubCategory::with('category')->orderBy('id', 'DESC')->paginate(10);
        return response()->json($subcategories);
    }

    /**
     * Create new  SubCategory
     * @param  Request $request [Vuejs send data to API]
     * @return [json]           [true or false created]
     */
    public function apiCreate(Request $request) {
        $this->validate($request,
            [   'name'=>'required',
                'slug'=>'required|unique:sub_categories,slug',
                'category_id'=>'required',
                'description'=>'required'
            ],
            [   'name.required' => '* Input name',
                'slug.required' => '* Input slug',
                'slug.unique' => '* Slug category exits',
                'category_id.required' => '* Chose Category',
                'description.required' => '* Input descriptions'
            ]
        );
        $subcategory = new SubCategory();
        $subcategory->name = $request->name;
        $subcategory->slug = $request->slug;
        $subcategory->category_id = $request->category_id;
        $subcategory->description = $request->description;
        $subcategory->save();

        return response()->json([
            'saved' => true
        ]);
    }

    /**
     * Show information of subcategory
     * @param  [int] $id [Id of subcategory. Got from router]
     * @return [json]     [Information of subcategory]
     */
    public function apiShow($id) {
        $subcategory = SubCategory::findOrFail($id);
        return response()->json($subcategory);
    }

    /**
     * Update information of subcategory
     * @param  Request $request [Information want to update]
     * @param  [int]  $id      [Id of subcategory need update]
     * @return [json]           [true or false updated]
     */
    public function apiUpdate(Request $request, $id) {
        $this->validate($request,
            [   'name'=>'required',
                'category_id'=>'required',
                'description'=>'required'
            ],
            [   'name.required' => '* Input name',
                'category_id.required' => '* Chose Category',
                'description.required' => '* Input descriptions'
            ]
        );
        $edit = SubCategory::findOrFail($id);
        $edit->name = $request->name;
        $edit->category_id = $request->category_id;
        $edit->description = $request->description;
        $edit->save();
        return response()->json([
            'saved' => true
        ]);
    }

    /**
     * Delele a subcategory from database
     * Category must had not post (posts)
     * @param  [int] $id [id of subcategory need to delete]
     * @return [json]     [true or false deleted]
     */
    public function apiDelete($id) {

        $subcategory = SubCategory::findOrFail($id);
        $post = Post::where('subcategory_id', $id)->get();
        if(count($post) > 0) {
            return response()->json([
                'delete' => false,
                'message' => "Can't remove this SubCategory because it has some Posts"
            ]);
        }
        $subcategory->delete($id);
        return response()->json([
            'deleted'=>true,
            'message' => 'Success remove this SubCategory'
        ]);
    }

    /**
     * Search some subcategories in database
     * Search with name and description
     * Sort by ID DESC
     * @param  [string] $search [Keyword search]
     * @return [json]         [SubCategories found]
     */
    public function apiSearch($search) {
        $findSubCategory = SubCategory::with('category')->where('name','like',"%$search%")->orWhere('description', 'like', "%$search%")->orderBy('id', 'DESC')->paginate(10);
        return response()->json($findSubCategory);
    }

    /**
     * API Angular Client
     * @param  [string] $slugSubCate [Slug subcategory]
     * @return [json]           [sub categories]
     */
    public function apiClientGetSubCategory($slugSubCate) {
        $subCategory = SubCategory::with(['category'])->where('slug', $slugSubCate)->firstOrFail();
        $posts = Post::with(['subcategory', 'author'])->where('status', 1)->where('subcategory_id', $subCategory->id)->paginate(8);

        $top_posts = Post::with(['subcategory', 'author'])->where('status', 1)->where('subcategory_id', $subCategory->id)->orderBy('count_views', 'DESC')->take(10)->get();

        return response()->json([
            'subcategory' => $subCategory,
            'posts' => $posts,
            'top_posts' => $top_posts
        ]);
    }

}
