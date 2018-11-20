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

Route::get('/', 'HomeController@index')->name('home');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');



Route::group([
    'middleware' => 'auth'
             ], function(){

    // 系统管理
    Route::group([
                     'namespace' => 'System',
                 ], function(){

        // 菜单管理
        Route::get('menus', 'MenuController@index')->name('menu.index');
        Route::get('menus/create', 'MenuController@create')->name('menu.create');
        Route::post('menus', 'MenuController@store')->name('menu.store');
        Route::get('menus/{id}', 'MenuController@show')->name('menu.show');
        Route::get('menus/{id}/edit', 'MenuController@edit')->name('menu.edit');
        Route::put('menus/{id}','MenuController@update')->name('menu.update');
        Route::delete('menus/{id}', 'MenuController@destroy')->name('menu.destroy');


        // 节点管理
        Route::get('nodes', 'NodeController@index')->name('node.index');
        Route::get('nodes/create', 'NodeController@create')->name('node.create');
        Route::post('nodes', 'NodeController@store')->name('node.store');
        Route::get('nodes/{id}', 'NodeController@show')->name('node.show');
        Route::get('nodes/{id}/edit', 'NodeController@edit')->name('node.edit');
        Route::put('nodes/{id}','NodeController@update')->name('node.update');
        Route::delete('nodes/{id}', 'NodeController@destroy')->name('node.destroy');

    });
});

