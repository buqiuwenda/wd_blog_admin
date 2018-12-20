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
    'middleware' => ['auth','permission'],
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

    // 标签管理
    Route::group(['namespace' => 'Tag'],function(){
        Route::get('tags', 'TagController@index')->name('tag.index');
        Route::get('tags/create', 'TagController@create')->name('tag.create');
        Route::post('tags', 'TagController@store')->name('tag.store');
        Route::get('tags/{id}', 'TagController@show')->name('tag.show');
        Route::get('tags/{id}/edit', 'TagController@edit')->name('tag.edit');
        Route::put('tags/{id}','TagController@update')->name('tag.update');
        Route::delete('tags/{id}', 'TagController@destroy')->name('tag.destroy');

    });

    // 类别管理
    Route::group(['namespace' => 'Category'],function(){
        Route::get('category', 'CategoryController@index')->name('category.index');
        Route::get('category/create', 'CategoryController@create')->name('category.create');
        Route::post('category', 'CategoryController@store')->name('category.store');
        Route::get('category/{id}', 'CategoryController@show')->name('category.show');
        Route::get('category/{id}/edit', 'CategoryController@edit')->name('category.edit');
        Route::put('category/{id}','CategoryController@update')->name('category.update');
        Route::delete('category/{id}', 'CategoryController@destroy')->name('category.destroy');

    });

    // 用户管理
    Route::group(['namespace' => 'User'], function(){
        Route::get('users', 'UserController@index')->name('user.index');
        Route::get('users/{id}', 'UserController@show')->name('user.show');
        Route::get('users/{id}/edit', 'UserController@edit')->name('user.edit');
        Route::put('users/{id}','UserController@update')->name('user.update');
    });

    // 文章管理
    Route::group(['namespace' => 'Article'], function(){
        Route::get('articles', 'ArticleController@index')->name('article.index');
        Route::get('articles/create', 'ArticleController@create')->name('article.create');
        Route::post('articles', 'ArticleController@store')->name('article.store');
        Route::get('articles/{id}', 'ArticleController@show')->name('article.show');
        Route::get('articles/{id}/edit', 'ArticleController@edit')->name('article.edit');
        Route::put('articles/{id}','ArticleController@update')->name('article.update');
    });

    // 评论管理
    Route::group(['namespace' => 'Article'], function(){
        Route::get('comments', 'CommentController@index')->name('comment.index');
        Route::get('comments/{id}', 'CommentController@show')->name('comment.show');
    });

});

