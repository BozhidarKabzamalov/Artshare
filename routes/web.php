<?php

Route::group(['middleware' => ['web']], function(){

    Route::get('/', 'PagesController@index')->name('home');
    Route::get('/artwork/{id}', 'PagesController@specificImage')->name('specificImage');
    Route::get('/categories', 'PagesController@categories')->name('categories');
    Route::get('/category/{name}', 'PagesController@specificCategory')->name('specificCategory');
    Route::get('/profile/{username}', 'PagesController@profile')->name('profile');
    Route::get('/search', 'PagesController@search')->name('search');
    Route::get('/signup', 'PagesController@signup')->name('signUpView');
    Route::get('/signin', 'PagesController@signin')->name('signInView');
    Route::post('/signup', 'UsersController@signUp')->name('signup');
    Route::post('/signin', 'UsersController@signIn')->name('signin');

    Route::group(['middleware' => ['auth']], function(){

        Route::get('/upload', 'PagesController@upload')->name('upload');
        Route::get('/logout', 'UsersController@logOut')->name('logout');
        Route::get('/settings/{username}', 'PagesController@settings')->name('settings');
        Route::get('/artwork/edit/{id}', 'PagesController@updateArtwork')->name('updateArtworkView');
        Route::post('/category', 'CategoryController@createCategory')->name('createCategory');
        Route::post('/artwork', 'ArtworkController@uploadArtwork')->name('uploadArtwork');
        Route::post('/comment', 'CommentsController@postComment')->name('comment');
        Route::post('/artwork/like', 'LikeController@likeArtwork')->name('likeArtwork');
        Route::delete('/artwork/{id}', 'ArtworkController@DeleteArtwork')->name('DeleteArtwork');
        Route::delete('/categories', 'CategoryController@deleteCategories')->name('deleteCategories');
        Route::delete('/comment', 'CommentsController@deleteComment')->name('deleteComment');
        Route::patch('/profile/{user}', 'UsersController@updateProfile')->name('updateProfile');
        Route::patch('/artwork/{id}', 'ArtworkController@updateArtwork')->name('updateArtwork');

        Route::group(['middleware' => 'roles', 'roles' => 'admin'], function(){

            Route::get('/admin', 'pagesController@admin')->name('admin');

        });

    });

});
