<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;

class GoodsController extends Controller
{
    public function add()
    {
        return view('admin.goods.add');
    }

    public function doadd(Request $request)
    {
        $req=$request->except(['_token']);
        $request->validate([
            'goods_name' => 'required|unique:goods|max:30',
            'goods_price' => 'required|numeric',
            'goods_stock'=>'required|numeric',
        ],[
            'goods_name.required'=>'商品名称必填',
            'goods_name.unique'=>'商品名称已存在',
            'goods_name.max'=>'名称长度在30以内',
            'goods_price.required'=>'商品价格必填',
            'goods_price.numeric'=>'价格必须为数字',
            'goods_stock.required'=>'商品库存必填',
            'goods_stock.numeric'=>'库存必须为数字',
        ]);
        
        if(request()->hasfile('goods_pic')){
            $req['goods_pic']=$this->upload('goods_pic');
            // dd($req['goods_pic']);
        }
        $req['add_time']=time();
        $data=DB::table('goods')->insert($req);
        if ($data) {
            return redirect('admin/goods/list');
        } else {
            echo "登录失败";
        }
    }

    public function list()
    {
        $req=request()->all();
        $goods_name=$req['goods_name']??'';
        $where=[];
        if ($goods_name) {
           $where[]=['goods_name','like','%'.$goods_name.'%'];
        }

        $goods_price=$req['goods_price']??'';
        if ($goods_price) {
            $where[]=['goods_price','=',$goods_price];
        }
        
        $data=DB::table('goods')->where($where)->paginate(5);
        return view('list',compact('data','goods_name','goods_price'));
    }

    public function upload($goods_pic)
    {
        if (request()->file($goods_pic)->isValid()) {
            $photo = request()->file($goods_pic);
            $store_result = $photo->store('', 'public');
            return $store_result;
        }
        exit('未获取到上传文件或上传过程出错');
    }
}
