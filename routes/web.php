<?php
Route::group(['middleware' => 'auth'], function() {

  Route::get('/', [App\Http\Controllers\MenuController::class, 'menu'])->name('menu');

  Route::get('/menu', [App\Http\Controllers\MenuController::class, 'menu'])->name('menu');

  Route::get('/todo/list', '\App\Http\Controllers\TodoController@index')->name('todo.index');

  Route::get('/todo/create', '\App\Http\Controllers\TodoController@showCreateForm')->name('todo.create');
  Route::post('/todo/create', '\App\Http\Controllers\TodoController@create');

  Route::get('/todo/edit', '\App\Http\Controllers\TodoController@showEditForm')->name('todo.edit');
  Route::post('/todo/edit', '\App\Http\Controllers\TodoController@edit');
  
  Route::post('/todo/destroy', '\App\Http\Controllers\TodoController@destroy')->name('todo.destroy');

  Route::get('/user/list', '\App\Http\Controllers\UserController@index')->name('user.index');
  
  Route::get('/user/create', '\App\Http\Controllers\UserController@showCreateForm')->name('user.create');
  Route::post('/user/create', '\App\Http\Controllers\UserController@create');

  Route::get('/user/edit', '\App\Http\Controllers\UserController@showEditForm')->name('user.edit');
  Route::post('/user/edit', '\App\Http\Controllers\UserController@edit');

  Route::post('/user/destroy', '\App\Http\Controllers\UserController@destroy')->name('user.destroy');

});

Auth::routes();