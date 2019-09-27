<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;

class SurveyController extends Controller
{
    public function surveylogin()
    {
        return view('admin.surveylogin');
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
            return redirect('admin/addsurvey');
        } else {
            return redirect('admin/surveylogin');
        }
    }

    public function addsurvey()
    {
        return view('admin.addsurvey');
    }

    public function doadd(Request $request)
    {
        $req=$request->all();
        unset($req['_token']);
        $where=[
            'name'=>$req['name'],
        ];
        $data=DB::table('survey')->where($where)->insert();
        return redirect('admin/problem');
    }

    public function addproblem()
    {
        return view('admin.addproblem');
    }

    public function do_add(Request $request)
    {
        $req=$request->all();
        unset($req['_token']);
        $data=DB::table('problem')->insert($req);
        return redirect('admin/lists');
    }

}