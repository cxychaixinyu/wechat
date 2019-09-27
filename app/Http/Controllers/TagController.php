<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TagController extends Controller
{
    public function add(){
        return view('tag/add');
    }

    public function doadd()
    {
        $res=request()->all();
        $result=file_get_contents('https://api.weixin.qq.com/cgi-bin/tags/create?access_token='.$this->get_access_token().'');
    }
}
