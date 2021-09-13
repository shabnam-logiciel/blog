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
Route::get('/post','PostcrudController@index');
Route::post('/post','PostcrudController@store');
Route::get('/post/{id}','PostcrudController@show');
Route::put('/post/{id}','PostcrudController@update');
Route::delete('/post/{id}','PostcrudController@destroy');
});

// Route::get('/postsearch/{title}','PostcrudController@search');


                         // COMMENTS//
Route::group(['before' => 'oauth'], function(){                          
Route::post('/comment','CommentController@commentstore');
Route::get('/comment','CommentController@commentindex');
Route::delete('/comment/{id}','CommentController@commentdestroy');
Route::put('/comment/{id}','CommentController@commentupdate');
});

                          // User Signup    //
Route::post('/signup','UserController@signup');
Route::post('/login','UserController@login');
Route::post('/status','UserController@status');
Route::get('/user','UserController@index');
Route::group(['before' => 'oauth'], function(){    
Route::post('/uploadimage','UserController@uploadimage');

});
Route::post('/department','UserController@departmentstore');
Route::get('/department','UserController@departmentindex');
