<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/support', "SupportController@index");

Route::get('/users', "UserController@index");
Route::get('/users/show/{id}', "UserController@show");
Route::put('/users/create',"UserController@store");
Route::post('/users/update/{id}', "UserController@update");
Route::post('/users/delete/{id}', "UserController@destroy");

Route::get('/roles', "RoleController@index");

Route::get('/projects', "ProjectController@index");
Route::put('/create_project', "ProjectController@store");
Route::post('/projects/edit/{id}', "ProjectController@update");
Route::post('/projects/delete/{id}', "ProjectController@destroy");
Route::get('/projects/show/{id}', "ProjectController@show");

Route::get('/statuses', "StatusesController@index");
Route::get('/users_statuses', "UsersStatusesController@index");

Route::get('/tasks', "TaskController@index");
Route::put('/create_task', "TaskController@store");
Route::post('/tasks/edit/{id}',"TaskController@update");
Route::post('/tasks/delete/{id}', "TaskController@destroy");
Route::get('/tasks/show/{id}', "TaskController@show");

Route::get('/comments', "CommentController@index");
Route::post('/comments/delete/{id}', "CommentController@destroy");
Route::get('/comments/show/{task_id}', "CommentController@show");
Route::put('/create_comment', "CommentController@store");

