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
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');



Route::group([
    'middleware' => 'auth'
             ], function(){

    Route::group([
                     'namespace' => 'System',
                 ], function(){

        // 信息面板
        Route::get('menus', 'MenuController@index')->name('menu.index');
        Route::get('menus/create', 'MenuController@create')->name('menu.create');
        Route::post('menus', 'MenuController@store')->name('menu.store');
        Route::get('menus/{id}', 'MenuController@show')->name('menu.show');
        Route::get('menus/{id}/edit', 'MenuController@edit')->name('menu.edit');
        Route::put('menus/{id}','MenuController@update')->name('menu.update');
        Route::delete('menus/{id}', 'MenuController@destroy')->name('menu.destroy');

    });
});

