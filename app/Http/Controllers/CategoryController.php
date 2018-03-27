<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Category;
use App\SubCategory;
use DB;
use App\Http\Requests\CategoryRequest;
class CategoryController extends Controller
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
     * Get List Categories
     * Orderby: ID DESC
     * Paginate: 10
     * @return [json] [List categories]
     */
    public function apiGetIndex() {
        $categories = Category::with('subcategory')->orderBy('id', 'DESC')->paginate(10);
        return response()->json($categories);
    }

    /**
     * Create new Category
     * @param  Request $request [Vuejs send data to API]
     * @return [json]           [true or false created]
     */
    public function apiCreate(Request $request) {

        $this->validate($request,
            [   'name'=>'required',
                'slug'=>'required|unique:categories,slug',
                'description'=>'required'
            ],
            [   'name.required' => '* Input name',
                'slug.required' => '* Input slug',
                'slug.unique' => '* Slug category exits',
                'description.required' => '* Input descriptions'
            ]
        );
        $category = new Category();
        $category->name = $request->name;
        $category->slug = $request->slug;
        $category->description = $request->description;
        $category->save();

        return response()->json([
            'saved' => true
        ]);
    }

    /**
     * Show information of category
     * @param  [int] $id [Id of category. Got from router]
     * @return [json]     [Information of category]
     */
    public function apiShow($id) {
        $category = Category::with('subcategory')->findOrFail($id);
        return response()->json($category);
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
        $edit = Category::findOrFail($id);
        $edit->name = $request->name;
        $edit->description = $request->description;
        $edit->save();
        return response()->json([
            'saved' => true
        ]);
    }

    /**
     * Delele a category from database
     * Category must had not subcategory (subcategories)
     * @param  [int] $id [id of category need to delete]
     * @return [json]     [true or false deleted]
     */
    public function apiDelete($id) {

        $category = Category::findOrFail($id);
        $subcategory = SubCategory::where('category_id', $id)->get();
        if(count($subcategory) > 0) {
            return response()->json([
                'delete' => false,
                'message' => "Can't remove this Category because it has some Subcategories"
            ]);
        }
        $category->delete($id);
        return response()->json([
            'deleted'=>true,
            'message' => 'Success remove this Category'
        ]);
    }

    /**
     * Search some categories in database
     * Search with name and description
     * Sort by ID DESC
     * @param  [string] $search [Keyword search]
     * @return [json]         [Categories found]
     */
    public function apiSearch($search) {
        $findCategory = Category::where('name','like',"%$search%")->orWhere('description', 'like', "%$search%")->orderBy('id', 'DESC')->paginate(10);
        return response()->json($findCategory);
    }

    /**
     * API Angular Client
     * @param  [string] $slugCate [Slug category]
     * @return [json]           [category]
     */
    public function apiClientGetCategory($slugCate) {
        $category = Category::with('subcategory')->where('slug', $slugCate)->firstOrFail();
        return response()->json($category);
    }


}
