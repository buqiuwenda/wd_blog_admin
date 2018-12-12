<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


Route::group(['namespace' => 'Api'],function(){

    Route::get('nodes/tree', 'NodeController@getTreeNodes')->name('node.treeList');

    Route::post('image/uploads', 'UploadFileController@uploadImage')->name('image.upload');

    Route::post('file/deletes', 'UploadFileController@deleteFile')->name('file.delete');
});
