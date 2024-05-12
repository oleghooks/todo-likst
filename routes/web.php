<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    if(Auth::check())
        return redirect('/home');
    else
        return view('welcome');
});

Auth::routes();

Route::middleware('auth')->group(function () {
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

    Route::controller(\App\Http\Controllers\ListsController::class)->group(function (){
        Route::get('/list', 'list');
        Route::post('/list/add', 'add');
        Route::get('/list/delete', 'delete');
        Route::get('/list/info', 'info');
        Route::post('/list/edit', 'edit');
    });
    Route::controller(\App\Http\Controllers\TaskAttachmentsController::class)->group(function (){
        Route::post('/tasks/upload', 'add');
    });
    Route::controller(\App\Http\Controllers\TasksController::class)->group(function (){
        Route::post('/tasks/add', 'add');
        Route::get('/tasks/list', 'list');
        Route::get('/tasks/edit_form', 'editForm');
        Route::post('/tasks/edit', 'edit');
    });
    //Route::get('/imagefly/{params}/{imagepath}','Ivliev\Imagefly\ImageflyController@index')->where('imagepath', '.*');;
});
