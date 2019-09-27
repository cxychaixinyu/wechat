<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class UrlController extends Controller
{
    public function add_url()
    {
        return view('add_url');
    }

    public function doadd_url(Request $request)
    {
        $req=request()->except(['_token']);
        // dd($req);
        $request->validate([
            'name'=>'required|unique:url|alpha_dash',
            'url'=>'required|url',
        ],[
            'name.required'=>'网站名称不能为空',
            'name.unique'=>'网站名称已存在',
            'name.alpha_dash'=>'网站名称必须由中文字母数字下划线组成',
            'url.required'=>'网址不能为空',
            'url.url'=>'网址格式为http://www.****.com格式',
        ]);
        
        if(request()->hasfile('logo')){
            $req['logo']=$this->upload('logo');
            // dd($req['logo']);
        }
    
        $data=DB::table('url')->insert($req);
        if ($data) {
            echo "<script>alert('添加成功');</script>";
            return redirect('url/list');
        } else {
            echo "<script>alert('添加失败');</script>";
            return redirect('url/add');
        }
    }

    public function list_url()
    {
        $req=request()->all();
        $name=$req['name']??'';
        $where=[];
        if($name){
            $where[]=['name','like','%'.$name.'%'];
        }

        $data=DB::table('url')->where($where)->paginate(3);
        return view('list_url',['data'=>$data,'name'=>$name]);
    }

    public function update_url()
    {
        $req=request()->all();
        $data=DB::table('url')->where(['id'=>$req['id']])->first();
        return view('update_url',['data'=>$data]);
    }

    public function doupdate_url(Request $request)
    {
        $req=request()->except(['_token']);
        // dd($req);
        $request->validate([
            'name'=>'required|alpha_dash',
            'url'=>'required|url',
        ],[
            'name.required'=>'网站名称不能为空',
            'name.alpha_dash'=>'网站名称必须由中文字母数字下划线组成',
            'url.required'=>'网址不能为空',
            'url.url'=>'网址格式为http://www.****.com格式',
        ]);
        
        if(request()->hasfile('logo')){
            $req['logo']=$this->upload('logo');
        }

        $data=DB::table('url')->where(['id'=>$req['id']])->update($req);
        if ($data) {
            echo "<script>alert('修改成功');</script>";
            return redirect('url/list');
        } else {
            echo "<script>alert('修改失败');</script>";
            return redirect('url/update_url');
        }        
    }

    public function delete_url()
    {
        $req=request()->all();
        $data=DB::table('url')->where(['id'=>$req['id']])->delete();
        
        if ($data) {
            
            $info = ['code'=>1];
            echo json_encode($info);
        }else{
            $info = ['code'=>2];
            echo json_encode($info);
        } 
    }

    public function upload($name)
    {
        if (request()->file($name)->isValid()) {
            $photo = request()->file($name);
            $store_result = $photo->store('','public');
            return $store_result;
        }
        exit('未获取到上传文件或上传过程出错');
    }

    public function checkName()
    {
        $where['name']=request()->name;
        $id=request()->id??'';
        if ($name) {
            $where[]=['name','=',$name];
        }
        if ($id) {
            $where[]=['id','!=',$id];
        }
        $data=DB::table('url')->where($where)->first();
        echo $data;
    }
}
