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

// Route::get('/', function () {
//     return view('welcome');
// });

// Route::get('/', function () {
//     return "<form astion='/useradd'>".csrf_field()."<input type=text name=username><button>提交</button></form>";
// });

//周试
Route::prefix('students')->group(function(){
	Route::get('add','StudentsController@add');
	Route::post('doadd','StudentsController@doadd');
	Route::get('list','StudentsController@list');
	Route::get('lxlist','StudentsController@lxlist');
	Route::get('update','StudentsController@update');
	Route::post('doupdate','StudentsController@doupdate');
	Route::get('delete','StudentsController@delete');
	Route::get('lxupdate','StudentsController@lxupdate');
});

// 登陆
Route::get('/admin/login','admin\LoginController@login');
Route::post('/admin/do_login','admin\LoginController@do_login');

//后台

Route::prefix('admin')->group(function(){
	//后台
	Route::get('index/index','admin\IndexController@index');//后台主页
	Route::get('index/head','admin\IndexController@head');//后台主页头部
	Route::get('index/left','admin\IndexController@left');//后台主页左边
	Route::get('index/main','admin\IndexController@main');//后台主页主体

	//管理员
	Route::get('user/add','admin\UserController@add');//后台管理员添加
	Route::post('user/doadd','admin\UserController@doadd');//处理管理员添加
	Route::get('user/list','admin\UserController@list');//管理员列表
	Route::get('user/delete','admin\UserController@delete');//管理员删除
	Route::get('user/update','admin\UserController@update');//管理员修改

	//商品
	Route::get('goods/add','admin\GoodsController@add');//商品添加
	Route::post('goods/doadd','admin\GoodsController@doadd');//处理商品添加
	Route::get('goods/list','admin\GoodsController@list');//商品列表

	// //品牌
	// Route::get('brand/add','admin\BrandController@add');//品牌添加
	// Route::post('brand/doadd','admin\BrandController');//处理添加
});

Route::prefix('url')->middleware('checklogin')->group(function()
{
	Route::get('add','UrlController@add_url');
	Route::post('doadd','UrlController@doadd_url');
	Route::any('list','UrlController@list_url');
	Route::get('update','UrlController@update_url');
	Route::post('doupdate','UrlController@doupdate_url');
	Route::get('delete','UrlController@delete_url');
	Route::post('checkName','UrlController@checkName');
});

//练习
Route::prefix('stu')->group(function(){
	Route::get('add','StuController@add');
	Route::post('doadd','StuController@doadd');
	Route::get('list','StuController@list');
	Route::get('update','StuController@update');
	Route::get('session','StuController@session');
});

// 注册
Route::get('/admin/register','admin\LoginController@register');
Route::post('/admin/do_register','admin\loginController@do_register');

// 展示学生信息
Route::get('/student/index','StudentController@index');

// 处理添加学生信息
Route::post('/student/do_add','StudentController@do_add');

// 修改学生信息
Route::get('/student/update','StudentController@update');
Route::post('/student/do_update','StudentController@do_update');

// 删除学生信息
Route::get('/student/delete','StudentController@delete');


// 作业1 题库
Route::get('/admin/examlogin','admin\ExamController@examlogin');//登录
Route::post('/admin/dologin','admin\ExamController@dologin');//处理登录
Route::get('/admin/examlists','admin\ExamController@examlists');//列表


// 添加商品
Route::get('/admin/add_goods','admin\GoodsController@add_goods');
Route::post('/admin/do_add_goods','admin\GoodsController@do_add_goods');

// 展示商品信息
Route::get('/admin/goodslist','admin\GoodsController@goodslist');

// 处理商品修改
Route::post('/admin/do_update','admin\GoodsController@do_update');

// 删除商品
Route::get('/admin/delete','admin\GoodsController@delete');

//考试
Route::get('/admin/add','admin\AddsController@add');
Route::post('/admin/doadd','admin\AddsController@doadd');
Route::get('/admin/lists','admin\AddsController@lists');

Route::get('/home/login','home\ExamController@login');
Route::post('/home/dologin','home\ExamController@dologin');
Route::get('/home/list','home\ExamController@list');



//作业2 调研
Route::get('/admin/surveylogin','admin\SurveyController@surveylogin');//登录
Route::post('/admin/dologin','admin\SurveyController@dologin');//处理登录
Route::get('/admin/addsurvey','admin\SurveyController@addsurvey');//添加调研项目
Route::post('/admin/doadd','admin\SurveyController@doadd');//处理添加

//作业3 竞猜
Route::get('/admin/guess/add','admin\GuessController@add');//添加
Route::post('/admin/guess/doadd','admin\GuessController@doadd');//处理添加
Route::get('/admin/guess/lists','admin\GuessController@lists');//竞猜列表
Route::get('/admin/guess/cai','admin\GuessController@cai');//竞猜
Route::post('/admin/guess/docai','admin\GuessController@docai');//处理竞猜

Route::get('/', function () {
	session(['user'=>['uid'=>1,'name'=>'admin']]);
	return response('hello admin')->header('content-type','text/html');
});



Route::prefix('news')->middleware('checklogin')->group(function(){
	Route::get('add','NewsController@add');
	Route::post('doadd','NewsController@doadd');
	Route::get('list','NewsController@list');
	Route::get('red','NewsController@red');
});
Route::get('/login',function(){
	return "<form action='/uid/78' method='post' > <input type='hidden' name='_token' value='.csrf_token().'><input type=text name=username><button>登录</button>";
});

// 调用中间件
Route::group(['middleware'=>['login']],function(){
	// 展示添加学生信息表单
	Route::get('/student/add','StudentController@add');
});

// 商品修改调用中间件
Route::group(['middleware'=>['update']],function(){
	// 展示商品修改表单
	Route::get('/admin/update','admin\GoodsController@update');
});
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

// Route::get('/', 'IndexController@index');
// Route::get('/login', 'LoginController@login');
// Route::get('/dologin', 'LoginController@dologin');
// Route::get('/reg', 'LoginController@reg');
// Route::get('/doreg', 'LoginController@doreg');
// Route::any('/checkMail','LoginController@checkMail');
// Route::any('/checkTel','LoginController@checkTel');
// Route::any('/sendEmail','LoginController@sendEmail');

// Route::any('/abort','CommonController@abort');
// Route::any('/ok','CommonController@ok');
// Route::any('/no','CommonController@no');
// Route::any('/send','CommonController@send');

//考试
Route::get('exam/login','ExamController@login');
Route::get('exam/dologin','ExamController@dologin');
Route::prefix('exam')->middleware('checklogin')->group(function(){
	Route::get('add','ExamController@add');
	Route::post('doadd','ExamController@doadd');
	Route::get('list','ExamController@list');
	Route::get('out','ExamController@out');
	Route::post('doout','ExamController@doout');
	Route::get('jilu','ExamController@jilu');
});

Route::get('wechat/get_access_token','WechatController@get_access_token');
Route::get('wechat/get_user_list','WechatController@get_user_list');
Route::get('wechat/get_user_xiang','WechatController@get_user_xiang');
Route::get('/wechat/clear_api','WechatController@clear_api');
Route::get('/wechat/source','WechatController@wechat_source'); //素材管理
Route::get('/wechat/upload','WechatController@upload'); //上传
Route::post('/wechat/do_upload','WechatController@do_upload'); //上传
// Route::get('wechat/list','WechatController@list');
// Route::get('wechat/xiang','WechatController@xiang');
Route::prefix('welogin')->group(function () {
	Route::get('login','WeloginController@login');
	Route::any('welogin_login','WeloginController@welogin_login');
	Route::any('code','WeloginController@code');
});
Route::get('/wechat/login','LoginController@wechat_login'); //微信授权登陆
Route::get('/wechat/code','LoginController@code'); //接收code
Route::get('/wechat/send','WechatController@send_template_massage');

Route::prefix('tag')->group(function (){
    Route::get('add','TagController@add');
});

Route::get('wx/login','WxController@login');
Route::any('wx/wx_login','WxController@wx_login');
Route::any('wx/code','WxController@code');
Route::prefix('wx')->middleware('checklogin')->group(function (){
    Route::get('list','WxController@list');
});

Route::prefix('menu')->group(function (){
   Route::get('list','MenuController@list');
   Route::get('add','MenuController@add');
});
