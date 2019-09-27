<?php

namespace App\Http\Controllers\home;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;

class ExamController extends Controller
{
    public function login()
    {
        return view('home.login');
    }

    public function dologin(Request $request)
    {
        $req=$request->all();
        unset($req['_token']);
        $where=[
            'name'=>$req['name'],
            'pwd'=>$req['pwd']
        ];
        $res=DB::table('login')->where($where)->first();
        // dd($res);
        if ($res) {
            echo "登录成功";
            return redirect('home/list');
        } else {
            echo "登录失败";
        }
        
    }

    public function list()
    {
        $res=DB::table('new')->paginate(3);
        
        return view('home.list',['guess'=>$res]);
    }
}