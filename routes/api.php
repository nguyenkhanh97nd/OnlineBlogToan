<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['prefix'=>'category', 'middleware'=>'auth:api'], function() {

	// RESTfull
	Route::get('/', ['as'=>'api.category.index','uses'=>'CategoryController@apiGetIndex']);
	Route::post('/', ['as'=>'api.category.create','uses'=>'CategoryController@apiCreate']);
	Route::get('/{id}', ['as'=>'api.category.edit', 'uses'=>'CategoryController@apiShow']);
	Route::put('/{id}', ['as'=>'api.category.update','uses'=>'CategoryController@apiUpdate']);
	Route::delete('/{id}', ['as'=>'api.category.delete','uses'=>'CategoryController@apiDelete']);

	Route::get('/search/{search}', ['as'=>'api.category.search', 'uses'=>'CategoryController@apiSearch']);

});

Route::group(['prefix' => 'catequestion', 'middleware' => 'auth:api'],  function() {

	Route::get('/', ['as' => 'api.catequestion.index', 'uses' => 'CateQuestionController@apiGetIndex']);
	Route::post('/', ['as'=>'api.catequestion.create','uses'=>'CateQuestionController@apiCreate']);
	Route::get('/{id}', ['as'=>'api.catequestion.edit', 'uses'=>'CateQuestionController@apiShow']);
	Route::put('/{id}', ['as'=>'api.catequestion.update','uses'=>'CateQuestionController@apiUpdate']);
	Route::delete('/{id}', ['as'=>'api.catequestion.delete','uses'=>'CateQuestionController@apiDelete']);

	Route::get('/search/{search}', ['as'=>'api.catequestion.search', 'uses'=>'CateQuestionController@apiSearch']);

});

Route::group(['prefix'=>'subcategory', 'middleware'=>'auth:api'], function() {

	// RESTfull
	Route::get('/', ['as'=>'api.subcategory.index','uses'=>'SubCategoryController@apiGetIndex']);
	Route::post('/', ['as'=>'api.subcategory.create','uses'=>'SubCategoryController@apiCreate']);
	Route::get('/{id}', ['as'=>'api.subcategory.edit', 'uses'=>'SubCategoryController@apiShow']);
	Route::put('/{id}', ['as'=>'api.subcategory.update','uses'=>'SubCategoryController@apiUpdate']);
	Route::delete('/{id}', ['as'=>'api.subcategory.delete','uses'=>'SubCategoryController@apiDelete']);

	Route::get('/search/{search}', ['as'=>'api.subcategory.search', 'uses'=>'SubCategoryController@apiSearch']);

});

Route::group(['prefix' => 'subcatequestion', 'middleware' => 'auth:api'],  function() {

	Route::get('/', ['as' => 'api.subcatequestion.index', 'uses' => 'SubCateQuestionController@apiGetIndex']);
	Route::post('/', ['as'=>'api.subcatequestion.create','uses'=>'SubCateQuestionController@apiCreate']);
	Route::get('/{id}', ['as'=>'api.subcatequestion.edit', 'uses'=>'SubCateQuestionController@apiShow']);
	Route::put('/{id}', ['as'=>'api.subcatequestion.update','uses'=>'SubCateQuestionController@apiUpdate']);
	Route::delete('/{id}', ['as'=>'api.subcatequestion.delete','uses'=>'SubCateQuestionController@apiDelete']);

	Route::get('/search/{search}', ['as'=>'api.subcatequestion.search', 'uses'=>'SubCateQuestionController@apiSearch']);

});

Route::group(['prefix'=>'posts', 'middleware'=>'auth:api'], function() {

	// RESTfull
	Route::get('/', ['as'=>'api.posts.index','uses'=>'PostsController@apiGetIndex']);
	Route::post('/', ['as'=>'api.posts.create','uses'=>'PostsController@apiCreate']);
	Route::get('/{id}', ['as'=>'api.posts.edit', 'uses'=>'PostsController@apiShow']);
	Route::put('/{id}', ['as'=>'api.posts.update','uses'=>'PostsController@apiUpdate']);
	Route::delete('/{id}', ['as'=>'api.posts.delete','uses'=>'PostsController@apiDelete']);

	Route::get('/search/{search}', ['as'=>'api.posts.search', 'uses'=>'PostsController@apiSearch']);

});
Route::group(['prefix'=>'pendingposts', 'middleware'=>'auth:api'], function() {

	// RESTfull
	Route::get('/', ['as'=>'api.pendingposts.index','uses'=>'PostsController@apiGetPendingIndex']);
	Route::get('/{id}', ['as'=>'api.pendingposts.edit', 'uses'=>'PostsController@apiPendingShow']);
	Route::put('/{id}', ['as'=>'api.pendingposts.update','uses'=>'PostsController@apiPendingUpdate']);
	Route::delete('/{id}', ['as'=>'api.pendingposts.delete','uses'=>'PostsController@apiPendingDelete']);

	Route::get('/search/{search}', ['as'=>'api.pendingposts.search', 'uses'=>'PostsController@apiPendingSearch']);

});
Route::group(['prefix'=>'questions', 'middleware'=>'auth:api'], function() {

	// RESTfull
	Route::get('/', ['as'=>'api.questions.index','uses'=>'BQuestionsController@apiGetIndex']);
	Route::post('/', ['as'=>'api.questions.create','uses'=>'BQuestionsController@apiCreate']);
	Route::get('/{id}', ['as'=>'api.questions.edit', 'uses'=>'BQuestionsController@apiShow']);
	Route::put('/{id}', ['as'=>'api.questions.update','uses'=>'BQuestionsController@apiUpdate']);
	Route::delete('/{id}', ['as'=>'api.questions.delete','uses'=>'BQuestionsController@apiDelete']);

	Route::get('/search/{search}', ['as'=>'api.questions.search', 'uses'=>'BQuestionsController@apiSearch']);

	Route::delete('/questionimage/{id}', ['as'=>'api.questions.deleteImage', 'uses'=>'BQuestionsController@apiDeleteImage']);

});

Route::group(['prefix'=>'member', 'middleware'=>'auth:api'], function() {

	// RESTfull
	Route::get('/', ['as'=>'api.member.index','uses'=>'UserController@apiGetIndex']);
	Route::post('/', ['as'=>'api.member.create','uses'=>'UserController@apiCreate']);
	Route::get('/{id}', ['as'=>'api.member.edit', 'uses'=>'UserController@apiShow']);
	Route::put('/{id}', ['as'=>'api.member.update','uses'=>'UserController@apiUpdate']);
	Route::delete('/{id}', ['as'=>'api.member.delete','uses'=>'UserController@apiDelete']);

	Route::get('/search/{search}', ['as'=>'api.member.search', 'uses'=>'UserController@apiSearch']);

});

Route::group(['prefix'=>'mail', 'middleware'=>'auth:api'], function() {
	// Send Mail Admin
	Route::post('/', ['as'=>'api.mail.send', 'uses'=>'AdminMailController@apiPostMail']);
});

Route::group(['prefix'=>'comment', 'middleware'=>'auth:api'], function() {
	// Send Mail Admin
	Route::get('/', ['as'=>'api.comment.index', 'uses'=>'CommentController@apiGetIndex']);
	Route::delete('/{id}', ['as'=>'api.comment.delete','uses'=>'CommentController@apiDelete']);

	Route::get('/search/{search}', ['as'=>'api.comment.search', 'uses'=>'CommentController@apiSearch']);
});

Route::group(['prefix'=>'bdata', 'middleware'=>'auth:api'], function() {
	// Send Mail Admin
	Route::get('/', ['as'=>'api.bdata.index', 'uses'=>'BDataController@apiGetIndex']);
	Route::delete('/{id}', ['as'=>'api.bdata.delete','uses'=>'BDataController@apiDelete']);

	Route::get('/search/{search}', ['as'=>'api.bdata.search', 'uses'=>'BDataController@apiSearch']);
});


Route::group(['prefix'=>'client'], function() {



	Route::post('testonline', ['as'=>'api.client.testOnlineIndex', 'uses'=>'TestOnlineController@apiClientTestOnlineIndex'])->middleware('jwt.auth');
	Route::post('ajaxanswer', ['as'=>'api.client.ajaxAnswer', 'uses'=>'TestOnlineController@apiClientAjaxAnswer'])->middleware('jwt.auth');
	Route::post('submitTest', ['as'=>'api.client.submitTest', 'uses'=>'TestOnlineController@apiClientSubmitTest'])->middleware('jwt.auth');
	
	Route::get('posts', ['as'=>'api.client.getPosts', 'uses'=>'PostsController@apiClientGetPosts']);
	Route::post('register', ['as'=>'api.client.postRegister', 'uses' => 'Auth\RegisterController@apiClientRegister']);

	Route::get('category/{slugCate}', ['as'=>'api.client.getCategory', 'uses' =>'CategoryController@apiClientGetCategory']);
	Route::get('subcategory/{slugSubCate}', ['as'=>'api.client.getSubCategory', 'uses' =>'SubCategoryController@apiClientGetSubCategory']);

	Route::get('catequestion', ['as'=>'api.client.getAllCateQuestion', 'uses'=>'CateQuestionController@apiClientGetAllCate']);
	Route::get('catequestion/{slugCate}', ['as'=>'api.client.getFeedCate', 'uses'=>'CateQuestionController@apiClientGetFeedCate']);

	Route::get('subcatequestion/{slugSubCate}', ['as'=>'api.client.getFeedSubCate', 'uses'=>'SubCateQuestionController@apiClientGetFeedSubCate']);


	Route::post('searchPost', ['as'=>'api.client.postSearch', 'uses' => 'PostsController@apiClientPostSearch']);

	Route::get('comment/{slugPost}', ['as'=>'api.client.getComment', 'uses' => 'CommentController@apiClientGetComment'])->middleware('jwt.auth');
	Route::post('comment/{slugPost}', ['as' => 'api.client.postComment', 'uses' => 'CommentController@apiClientPostComment'])->middleware('jwt.auth');

	Route::get('user', ['as'=>'api.client.getLoggedUser', 'uses'=>'UserController@apiClientGetLoggedUser'])->middleware('jwt.auth');

	Route::get('getRank', ['as'=>'api.client.getRank', 'uses' => 'UserController@apiClientGetRank']);

	Route::post('settingName', ['as' => 'api.client.settingName', 'uses' => 'SettingController@apiClientSettingName'])->middleware('jwt.auth');

	Route::post('settingInfo', ['as' => 'api.client.settingInfo', 'uses' => 'SettingController@apiClientSettingInfo'])->middleware('jwt.auth');

	Route::post('settingAvatar', ['as' => 'api.client.settingAvatar', 'uses' => 'SettingController@apiClientSettingAvatar'])->middleware('jwt.auth');

	Route::post('settingPassword', ['as' => 'api.client.settingPassword', 'uses' => 'SettingController@apiClientSettingPassword'])->middleware('jwt.auth');


	Route::get('getUser/{username}', ['as'=>'api.client.getUser', 'uses'=>'UserController@apiClientGetUser'])->middleware('jwt.auth');


	Route::post('like', ['as' => 'api.client.likeFeed', 'uses' => 'ProfileController@apiClientDoLike'])->middleware('jwt.auth');
	Route::post('dislike', ['as' => 'api.client.dislikeFeed', 'uses' => 'ProfileController@apiClientDoDislike'])->middleware('jwt.auth');
	Route::post('comment', ['as' => 'api.client.commentFeed', 'uses' => 'ProfileController@apiClientDoComment'])->middleware('jwt.auth');
	Route::post('postFeed', ['as'=>'api.client.postFeed', 'uses'=>'SocialLearningController@apiClientPostFeed'])->middleware('jwt.auth');

	Route::get('comment_feed', ['as'=>'api.client.getCommentFeeds', 'uses'=>'CommentFeedController@apiClientGetCommentFeeds']);
	Route::get('comment_feed/{slug}', ['as'=>'api.client.getCommentFeed', 'uses'=>'CommentFeedController@apiClientGetCommentFeed'])->middleware('jwt.auth');
	Route::post('comment_feed/{slug}', ['as' => 'api.client.postCommentFeed', 'uses'=>'CommentFeedController@apiClientPostCommentFeed'])->middleware('jwt.auth');
	Route::post('accept_answer_feed', ['as'=>'api.client.acceptAnswerFeed', 'uses'=>'CommentFeedController@apiClientAcceptAnswerFeed'])->middleware('jwt.auth');
	Route::post('remove_accept_answer_feed', ['as'=>'api.client.removeAcceptAnswerFeed', 'uses'=>'CommentFeedController@apiClientRemoveAcceptAnswerFeed'])->middleware('jwt.auth');
	Route::post('lock_feed', ['as'=>'api.client.lockFeed', 'uses'=>'CommentFeedController@apiClientLockFeed'])->middleware('jwt.auth');
	Route::post('remove_feed', ['as'=>'api.client.removeFeed', 'uses'=>'CommentFeedController@apiClientRemoveFeed'])->middleware('jwt.auth');
	Route::post('edit_feed', ['as'=>'api.client.editFeed', 'uses'=>'CommentFeedController@apiClientEditFeed'])->middleware('jwt.auth');


	Route::post('following', ['as'=>'api.client.following', 'uses'=>'FriendshipController@apiClientFollowingList'])->middleware('jwt.auth');
	Route::post('followers', ['as'=>'api.client.friendshipInvited', 'uses'=>'FriendshipController@apiClientFollowersList'])->middleware('jwt.auth');

	Route::post('addFollow', ['as' => 'api.client.addFollow', 'uses' => 'FriendshipController@apiClientAddFollow'])->middleware('jwt.auth');

	Route::post('removeFollow', ['as' => 'api.client.removeFollow', 'uses' => 'FriendshipController@apiClientRemoveFollow'])->middleware('jwt.auth');


	Route::get('{slugSubCate}/{slugPost}', ['as'=>'api.client.getPost', 'uses' => 'PostsController@apiClientGetPost']);

});
