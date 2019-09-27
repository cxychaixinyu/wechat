<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Http\Controllers\CommonController;

class LoginController extends CommonController
{
    public function login()
    {
        return view('login.login');
    }

    public function dologin()
    {
        $req=request()->except('_token');
        $res=DB::table('user')->select($req);
        if ($res) {
            $this->ok();
        } else {
            $this->no();
        }
        
    }

    public function reg()
    {
        return view('login.reg');
    }

    public function doreg()
    {
        $req=request()->except('_token');
        $res=DB::table('user')->insert($req);
        if ($res) {
            $this->ok();
        } else {
            $this->no();
        }
        
    }

    public function checkMail()
    {
        $user_name=request()->input('user_name');
        $res=DB::table('user')->where(['username'=>$username])->first();
        if ($res) {
            $this->no('邮箱账号已被注册');
        } else {
            $this->ok();
        }
        
    }

    public function checkTel()
    {
        $user_name=request()->input('user_name');
        $res=DB::table('user')->where(['user_name'=>$user_name])->first();
        if ($res) {
            $this->no('手机号已被注册');
        } else {
            $this->ok();
        }
        
    }

    public function sendEmail()
    {
        $user_name=request()->input('user_name');
        $res=$this->send($user_name);
        if ($res) {
            session(['sessonCode'=>$res,'codeTime'=>time()]);
            $this->ok('已发送');
        } else {
            $this->no('未知错误,请检查网络链接');
        }
    }
}
