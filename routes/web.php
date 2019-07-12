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


// 展示学生信息
Route::get('/student/index','StudentController@index');

// 处理添加学生信息
Route::post('/student/do_add','StudentController@do_add');

// 修改学生信息
Route::get('/student/update','StudentController@update');
Route::post('/student/do_update','StudentController@do_update');

// 删除学生信息
Route::get('/student/delete','StudentController@delete');

// 登陆
// Route::get('/student/login','StudentController@login');
// Route::post('/student/do_login','StudentController@do_login');


// 注册
// Route::get('/student/register','StudentController@register');
// Route::get('/student/do_register','StudentController@do_register');

// 添加商品
Route::get('/admin/add_goods','admin\GoodsController@add_goods');
Route::post('/admin/do_add_goods','admin\GoodsController@do_add_goods');

// 登陆
Route::get('/admin/login','admin\LoginController@login');
Route::post('/admin/do_login','admin\LoginController@do_login');

// 注册
Route::get('/admin/register','admin\LoginController@register');
Route::post('/admin/do_register','admin\loginController@do_register');


// 调用中间件
Route::group(['middleware'=>['login']],function(){
	// 展示添加学生信息表单
	Route::get('/student/add','StudentController@add');
});