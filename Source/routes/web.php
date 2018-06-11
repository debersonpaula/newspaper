<?php
use App\User;

//authentication route
Auth::routes();
Route::get('/home', 'HomeController@index')->name('home');

//get route to add post
//detects if user is logged, if not, redirect to login page
Route::get('/addpost',function(){ 
    return view('addpost');
})->middleware('auth');

//my dashboard routes to control article's CRUD
Route::post('/article','ArticleController@postArticle');
Route::delete('/article','ArticleController@removeArticle');

//public routes
Route::get('/','WelcomeController@index');
Route::get('/article/{id}','WelcomeController@getArticle');
Route::get('/images/{id}','ImageController@getImage');
Route::get('/article/PDF/{id}','WelcomeController@getArticlePDF');
Route::get('/rss','WelcomeController@getArticleRSS');
Route::get('/activate/{id}','WelcomeController@getActivation');


Route::get('/test',function(){ 
    //$user = factory(User::class)->create();
    //var_dump($user);
    header( "X-Test", "Testing" );
    setcookie( "TestCookie", "test-value" );
    var_dump( xdebug_get_headers() );
});