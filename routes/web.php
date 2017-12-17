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

    Route::post('/login', "LoginController@login");

    Route::post('/logout', "LoginController@logout");

    Route::any('/img/upload', "ImageController@upload");

    Route::get('/table/list', "ConcordatController@all");

    Route::get('/table/detail', "ConcordatController@show");

    Route::post('/table/store', "ConcordatController@store");

    Route::post('/table/edit', "ConcordatController@edit");

});

Route::any('/test', function(){
   $t = '2017-12-11';
   dd(strtotime($t));
});

