<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;

class AddsController extends Controller
{
    public function add()
    {
        return view('admin.add');
    }

    public function doadd(Request $request)
    {
        $info=$request->all();
        unset($info['_token']);
        $res=DB::table('ticket')->insert($info);
        if ($res) {
            return redirect("/admin/lists");
        } else {
            echo "未知错误";
        }
        
    }

    public function lists(Request $request)
    {
        $info=$request->all();
        $search="";
        if (!empty($info['search'])) {
            

            $search=$info['search'];
            $data=DB::table('ticket')->where('startstation','like','%'.$info['search'].'%')->paginate(3);
        } else {
            $data=DB::table('ticket')->paginate(3);
        }
        
        
        return view('/admin/lists',['ticket'=>$data,'search'=>$search]);
    }
}