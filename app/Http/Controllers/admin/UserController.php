<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;

class UserController extends Controller
{
    public function list()
    {
        $data=DB::table('user')->paginate(3);
        return view('admin.user.list',['data'=>$data]);
    }

    public function add()
    {
        return view('admin.user.add');
    }

    public function doadd()
    {
        $req=request()->all();
        unset($req['_token']);
        $time=time();
        $data=DB::table('user')->insert([
            'name'=>$req['name'],
            'pwd'=>$req['pwd'],
            'level'=>$req['level'],
            'time'=>$time,
        ]);
        if ($data) {
            return redirect('admin/user/list');
        } else {
            echo "添加失败";
        }    
    }

    public function update()
    {
        $req=request()->all();
        
        $data=DB::table('user')->where(['id'=>$req['id']])->first();
        return view('admin.user.update',['data'=>$data]);
    }

    public function doupdate(Request $request)
    {
        $req=$request->excpet(['_token']);
        $data=DB::table('user')->where($req)->update();
        if ($data) {
            return redirect('admin/user/list');
        } else {
            echo "修改失败";
        }
    }

    public function delete()
    {
        $req=request()->all();
        $data=DB::table('user')->where(['id'=>$req['id']])->delete();
        if ($data) {
            return redirect('admin/user/list');
        } else {
            echo "删除失败";
        }
        
    }
}