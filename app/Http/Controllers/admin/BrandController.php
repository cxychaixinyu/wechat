<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;

class BrandController extends Controller
{
    public function add()
    {
        return view('admin.brand.doadd');
    }

    public function doadd()
    {
        $req=request()->except(['_token']);
        $data=DB::table('brand')->insert($req);
        if ($data) {
            return redirect('admin/brand/list');
        } else {
            echo "添加失败";
        }
        
    }
}
