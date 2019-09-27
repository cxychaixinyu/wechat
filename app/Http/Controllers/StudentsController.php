<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class StudentsController extends Controller
{
    public function add()
    {
        return view('students/add');
    }

    public function doadd()
    {
        $req=request()->except('_token');
        $data=DB::table('students')->insert($req);
        if ($data) {
            return redirect('students/list');
        } else {
            echo "添加失败";
        }
        
    }

    public function list()
    {
        $where=[];
        $where[]=['status','=',1];
        $data=DB::table('students')->where($where)->get();
        // dd($data);
        return view('students/list',['data'=>$data]);
    }

    public function update()
    {
        $req=request()->all();
        $data=DB::table('students')->where(['id'=>$req['id']])->first();
        // dd($data);
        return view('students/update',['data'=>$data]);
    }

    public function doupdate()
    {
        $req=request()->except('_token');
        $data=DB::table('students')->where(['id'=>$req['id']])->update($req);
        if ($data) {
            return redirect('students/list');
        } else {
            echo "修改失败";
        }        
    }

    public function delete()
    {
        $req=request()->input();
        $where=[];
        $where[]=['id','=',$req['id']];
        $data=DB::table('students')->where($where)->update(['status'=>'0']);
        if ($data) {
            return redirect('students/list');
        } else {
            echo "删除失败";
        }
        
    }

    public function lxlist()
    {
        $where=[];
        $where[]=['status','=',0];
        $data=DB::table('students')->where($where)->get();
        return view('students/lxlist',['data'=>$data]);
    }

    public function lxupdate()
    {
        $req=request()->input();
        $data=DB::table('students')->where(['id'=>$req['id']])->update(['status'=>'1']);
        if ($data) {
            return redirect('students/lxlist');
        } else {
            echo "恢复失败";
        }
    }
}
