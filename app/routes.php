<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::get('/', function()
{
    echo "welcome to blog assignment..";
    exit;
});
 
                    // post  //
Route::group(['before' => 'oauth'], function(){        
Route::get('/post','PostsController@index');
Route::post('/post','PostsController@store');
Route::get('/post/{id}','PostsController@show');
Route::put('/post/{id}','PostsController@update');
Route::delete('/post/{id}','PostsController@destroy');
Route::post('/postfavourite','PostsController@addfavourite');

});

// Route::get('/postsearch/{title}','PostcrudController@search');


                         // COMMENTS//
Route::group(['before' => 'oauth'], function(){                          
Route::post('/comment','CommentController@store');
Route::get('/comment','CommentController@index');
Route::delete('/comment/{id}','CommentController@destroy');
Route::put('/comment/{id}','CommentController@update');
});

                          // User Signup    //
Route::post('/signup','UserController@signup');
Route::post('/login','UserController@login');
Route::post('/status','UserController@status');
Route::get('/user','UserController@index');

                        // image upload    //
Route::group(['before' => 'oauth'], function(){    
Route::post('/uploadimage','UserController@uploadimage');

});

                        // department   //
Route::post('/department','UserController@departmentstore');
Route::get('/department','UserController@departmentindex');
