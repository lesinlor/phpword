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

Route::get('/', function () {
    return view('welcome');
});


Route::group(['prefix' => 'api'], function (){

    Route::get('/table', "Home\HomeController@table");

    Route::get('/role', "RoleController@all");

    Route::resource('user', 'UserController');

    Route::get('/role/{role}', function ($item){
        if($_SESSION['role_id'] != 1){
            return array('code' => 1001,'message' => '权限不够');
        }
        $role = new \App\Role();
        $menusId = $role->menus($item);
        $menu = new \App\Menu();
        $data = $menu->roleMenus($menusId);
        return array('code' => 0, 'data' => $data);
    });

    Route::any('/session', "LoginController@info");

    Route::post('/login', "LoginController@login");

    Route::post('/logout', "LoginController@logout");

    Route::any('/img/upload', "ImageController@upload");

    Route::any('/img/store', "ImageController@store");

    Route::get('/table/list', "ConcordatController@all");

    Route::get('/table/detail', "ConcordatController@show");

    Route::post('/table/store', "ConcordatController@store");

    Route::post('/table/edit', "ConcordatController@edit");

    Route::any('/export', "ExportController@table");

    Route::any('/export/pic', "ExportController@pic");

    Route::get('/export/column', "ExportController@column");

});

Route::any('/test', function(){
    dd(session()->all());
});