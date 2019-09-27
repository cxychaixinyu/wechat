<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;

class ExamController extends Controller
{
    public function examlogin()
    {
        return view('admin.examlogin');
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
        if ($res) {
            echo "<script>alert('登录成功')</script>";
            return redirect('admin/add_exam');
        } else {
            echo "<script>alert('用户名或密码错误')</script>";
            return redirect('admin/examlogin');
        }
        
        
    }

    public function examlists(Request $request)
    {
        $req=$request->all();
        $data=DB::table('exam')->paginate(5);
        return redirect('admin.examlists',['exam'=>$data]);
    }


}