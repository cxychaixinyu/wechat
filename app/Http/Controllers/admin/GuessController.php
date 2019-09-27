<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;

class GuessController extends Controller
{
    public function add()
    {
        return view('guess.add');
    }

    public function doadd(Request $requst)
    {
        $req=$requst->all();
        unset($req['_token']);
        $req['time']=strtotime($req['time']);
        $data=DB::table('guess')->insert($req);
        if ($data) {
            echo "ok";
            return redirect("/admin/res");
        } else {
            echo "no";
            return redirect("/admin/add");
        }
        
    }

    public function res()
    {
        return view('guess.res');
    }

    public function dores(Request $requst)
    {
        $req=$requst->all();
        unset($req['_token']);
        $data=DB::table('result')->insert($req);
        return redirect('/admin/add');
    }

    public function lists(Request $requst)
    {
        $req=$requst->all();
        $data=DB::table('guess')->paginate(5);
        return view('guess.lists',['guess'=>$data]);
    }

    public function cai()
    {
        return view('guess.cai');
    }

    public function docai(Request $requst)
    {
        $req=$requst->all();

    }
}