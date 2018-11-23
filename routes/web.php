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

        // 用户管理
        Route::get('members', 'MemberController@index')->name('member.index');
        Route::get('members/create', 'MemberController@create')->name('member.create');
        Route::post('members', 'MemberController@store')->name('member.store');
        Route::get('members/{id}', 'MemberController@show')->name('member.show');
        Route::get('members/{id}/edit', 'MemberController@edit')->name('member.edit');
        Route::put('members/{id}','MemberController@update')->name('member.update');

        // 角色管理
        Route::get('roles', 'RoleController@index')->name('role.index');
        Route::get('roles/create', 'RoleController@create')->name('role.create');
        Route::post('roles', 'RoleController@store')->name('role.store');
        Route::get('roles/{id}', 'RoleController@show')->name('role.show');
        Route::get('roles/{id}/edit', 'RoleController@edit')->name('role.edit');
        Route::put('roles/{id}','RoleController@update')->name('role.update');
//        Route::delete('roles/{id}', 'RoleController@destroy')->name('role.destroy');

    });
});

