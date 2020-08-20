<?php

use Illuminate\Http\Request;
use App\Article;
use App\InfoGraph;
use App\CareeKiProfile;
use App\User;

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
//Route::post('user-register', 'ArticleController@register')->name('user.register');

Route::group(['middleware' => ['api','cors']], function () 
{
    
    Route::post('quiz-visitor-count/{id}', function($id){
		$post = QuizTopic::findorfail($id); // Find our post by ID.
        $post->increment('count'); // Increment the value in the clicks column.
        $post->update(); // Save our updated post.
        return response($content = $post, $status = 200);
	});

    Route::get('article', 'ArticleController@articleApiData');
    Route::get('career-profile', 'CkProfileController@ckProfileApiData');
    Route::get('infographic', 'InfographController@infographApiData');
    
    Route::post('update-profile', 'QuestionController@updateProfile');
    Route::post('send-message', 'ArticleController@message');
    Route::post('liked-content', 'ArticleController@likecontent');
        Route::get('liked-content-list/{id}', 'ArticleController@likecontentget');

    Route::post('update-email', 'QuestionController@updateEmail');
    Route::post('update-password', 'QuestionController@updatePassword');
    Route::post('update-profile-pic', 'ArticleController@saveProfilePic')->name('save-profilepic.page');
    Route::get('search/{title}', 'ArticleController@searchFilter')->name('search');


	Route::post('auth/register', 'Auth\ApiRegisterController@register');

	Route::post('login', function (Request $request) {
    
    if (auth()->attempt(['email' => $request->input('email'), 'password' => $request->input('password')])) {
        // Authentication passed...
        $user = auth()->user();
        $user->api_token = str_random(60);
        $user->save();
        return response()->json([
        	'status' => "success",
        	'code' => "200",
        	'data' => $user,
        ], 200);
    }
	    return response()->json([
	        'error' => 'Wrong Login Credential',
	        'code' => 401,
	    ], 401);
	});

});
