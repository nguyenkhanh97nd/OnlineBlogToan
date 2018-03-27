<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes();

/**
 * ADMIN BACKEND ROUTE
 */
Route::group( ['prefix'=>'admin', 'middleware'=>'adminLogin'] , function() {

	/**
	 * Route đăng nhập
	 */
	Route::get('login',['as'=>'admin.getLogin','uses'=>'UserController@getMasterView']);

	
	Route::group(['prefix'=>'dashboard'],function(){
		Route::get('index',['as'=>'admin.dashboard.index','uses'=>'AdminController@getMasterView']);
	});
 	/*---- Route thêm thành viên ----*/
 	Route::group( ['prefix'=>'member'],function() {
 		Route::get('index', 'UserController@getMasterView');
 		Route::get('create', 'UserController@getMasterView' );
 		Route::get('edit/{id}', 'UserController@getMasterView' );
 	});

 	/*---- Route category ----*/
 	Route::group(['prefix'=>'category'],function(){
 		Route::get('index', 'CategoryController@getMasterView');
 		Route::get('create', 'CategoryController@getMasterView' );
 		Route::get('edit/{id}', 'CategoryController@getMasterView' );
 	});
 	/*---- Route cate question ----*/
 	Route::group(['prefix'=>'catequestion'],function(){
 		Route::get('index', 'CateQuestionController@getMasterView');
 		Route::get('create', 'CateQuestionController@getMasterView' );
 		Route::get('edit/{id}', 'CateQuestionController@getMasterView' );
 	});

 	/*---- Route Sub_category ----*/
 	Route::group(['prefix'=>'subcategory'],function(){
 		Route::get('index', 'SubCategoryController@getMasterView');
 		Route::get('create', 'SubCategoryController@getMasterView' );
 		Route::get('edit/{id}', 'SubCategoryController@getMasterView' );
 	});

 	/*---- Route sub cate question ----*/
 	Route::group(['prefix'=>'subcatequestion'],function(){
 		Route::get('index', 'SubCateQuestionController@getMasterView');
 		Route::get('create', 'SubCateQuestionController@getMasterView' );
 		Route::get('edit/{id}', 'SubCateQuestionController@getMasterView' );
 	});

 	/*------ Route News ------*/
 	Route::group(['prefix'=>'posts'],function(){
 		Route::get('index', 'PostsController@getMasterView');
 		Route::get('create', 'PostsController@getMasterView' );
 		Route::get('edit/{id}', 'PostsController@getMasterView' );
 	});

 	Route::group(['prefix'=>'pendingposts'], function() {
 		Route::get('index', 'PostsController@getMasterView');
 		Route::get('create', 'PostsController@getMasterView' );
 		Route::get('edit/{id}', 'PostsController@getMasterView' );
 	});

 	Route::group(['prefix'=>'questions'],function(){
 		Route::get('index', 'BQuestionsController@getMasterView');
 		Route::get('create', 'BQuestionsController@getMasterView' );
 		Route::get('edit/{id}', 'BQuestionsController@getMasterView' );
 	});

 	Route::group(['prefix'=>'comment'],function(){
 		Route::get('index', 'CommentController@getMasterView');
 	});

 	Route::group(['prefix'=>'mail'], function(){
 		Route::get('index', 'AdminMailController@getMasterView');
 	});

 	Route::group(['prefix'=>'bdata'], function(){
 		Route::get('index', 'AdminMailController@getMasterView');
 	});

});


/**
 * EDITOR BACKEND ROUTE
 */
Route::group(['prefix'=>'editor', 'middleware'=>'editorLogin'], function(){

	Route::group(['prefix' => 'dashboard'], function() {
		Route::get('index', ['as'=>'editor.dashboard.index', 'uses'=>'EditorController@getIndex']);
	});

	Route::group(['prefix'=>'posts'], function(){

		//Ajax
		Route::post('getSubcategory',['as'=>'editor.ajax.posts.getSubcategory', 'uses'=>'AjaxController@getSubcategory']);

		Route::get('list', ['as' => 'editor.posts.getList', 'uses' => 'EditorPostsController@getList']);

		Route::get('add', ['as' => 'editor.posts.getAdd', 'uses' => 'EditorPostsController@getAdd']);
		Route::post('add', ['as' => 'editor.posts.postAdd', 'uses' => 'EditorPostsController@postAdd']);

		Route::get('edit/{idPost}', ['as' => 'editor.posts.getEdit', 'uses' => 'EditorPostsController@getEdit']);
		Route::post('edit/{idPost}', ['as' => 'editor.posts.postEdit', 'uses' => 'EditorPostsController@postEdit']);

		Route::get('delete/{idPost}',['as'=>'editor.posts.getDelete', 'uses'=>'EditorPostsController@getDelete']);

	});

	Route::group(['prefix'=>'questions'], function() {

		// Ajax
		Route::post('delete-image',['as'=>'editor.ajax.questions.delete.image','uses'=>'AjaxController@postDeleteImageQuestion']);

		Route::get('list',['as'=>'editor.questions.getList','uses'=>'EditorBQuestionsController@getList']);
		Route::get('add', ['as'=>'editor.questions.getAdd','uses'=>'EditorBQuestionsController@getAdd'] );
		Route::post('add', ['as'=>'editor.questions.postAdd','uses'=>'EditorBQuestionsController@postAdd'] );
		Route::get('delete/{idPost}', ['as'=>'editor.questions.getDelete','uses'=>'EditorBQuestionsController@getDelete'] );
		Route::get('edit/{idPost}', ['as'=>'editor.questions.getEdit','uses'=>'EditorBQuestionsController@getEdit'] );
		Route::post('edit/{idPost}', ['as'=>'editor.questions.postEdit','uses'=>'EditorBQuestionsController@postEdit'] );

	});
});


Route::get('/',['as'=>'page.index','uses'=>'HomeController@getIndex']);


Route::get('register/verify/{code}',['as'=>'register.verify','uses'=>'Auth\RegisterController@verify']);



//Call Cate show SubCate. Use .html for different from Route subcategory
Route::get('{slugCate}.html',['as'=>'page.category','uses'=>'HomeController@getIndex']);

//Call SubCate show All Post
//Call Post single
Route::get('{slugSubCate}',['as'=>'page.subcategory','uses'=>'HomeController@getIndex']);

Route::get('{subcategory}/{post}',['as'=>'page.post','uses'=>'HomeController@getIndex']);

Route::get('social-learning/{cate}/{subcate}',['as'=>'social.learning','uses'=>'HomeController@getIndex']);




