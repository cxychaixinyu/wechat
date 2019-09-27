<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Model\User;

class LoginController extends Controller
{
    // 登陆
	public function login()
	{
		return view('admin/login');
	}

	// 登陆处理
	public function do_login(Request $request)
	{
		$req = $request->all();
		// dd($request);
		$request->session()->put('admin','admin');
		return redirect('student/index');
	}

	// 注册表单
	public function register()
	{
		return view('admin/register');
	}

	// 注册处理
	public function do_register(Request $request)
	{
		$datas = $request->all();
		$datas['reg_time'] = time();
		$res = User::insert(['user_name'=>$datas['user_name'],'user_email'=>$datas['user_email'],'user_pwd'=>$datas['user_pwd'],'reg_time'=>$datas['reg_time']]);
		if ($res) {
			echo json_encode(['font'=>'注册成功','code'=>1]);
		}else{
			echo json_encode(['font'=>'未知错误','code'=>2]);die;
		}
	}
	public function FunctionName(Type $var = null)
	{
		# code...
	}
}
