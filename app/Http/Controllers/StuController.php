<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\storeStudentPost;//第二种验证
use Validator;//第三种验证
use DB;
use Illuminate\Support\Facades\Redis;

class StuController extends Controller
{
    public function add()
    {
        Redis::set('name','123456');
        echo Redis::get('name');
        die;
        $mem=new \Memcache;
        $mem->connect('127.0.0.1','11211');
        $data=$mem->get('student');
        if (empty($data)) {
            $data=json_encode(DB::table('student')->get());
            $mem->set('student',$data,0,10);
        }
        print_r($data);
        // $mem->set('key','abc',0,10);
        // echo $mem->get('key');
        die;
        return view('add');
    }

    public function doadd(Request $request)
    {
        $req=$request->except(['_token']);
        //第一种验证
        // $request->validate([
        //     'name' => 'required|unique:student|max:30',
        //     'age' => 'required|numeric',
        // ],[
        //     'name.required'=>'姓名必填',
        //     'name.unique'=>'姓名已存在',
        //     'name.max'=>'姓名长度在30以内',
        //     'age.required'=>'年龄必填',
        //     'age.numeric'=>'年龄必须为数字'
        // ]);

        //第三种验证
        $validator = Validator::make($req, [
            'name' => 'required|unique:student|max:30',
            'age' => 'required|numeric',
        ],[
                'name.required'=>'姓名必填',
                'name.unique'=>'姓名已存在',
                'name.max'=>'姓名长度在30以内',
                'age.required'=>'年龄必填',
                'age.numeric'=>'年龄必须为数字'
        ]);
        if ($validator->fails()) {
            return redirect('stu/add')
            ->withErrors($validator)
            ->withInput();
        }
        
        if(request()->hasfile('headimg')){
            $req['headimg']=$this->upload('headimg');
            // dd($req['headimg']);
        }
        $data=DB::table('student')->insert($req);
        if ($data) {
            return redirect('stu/list');
        } else {
            echo "登录失败";
        }
        
    }

    public function list()
    {
        $req=request()->all();
        $name=$req['name']??'';
        $where=[];
        if ($name) {
           $where[]=['name','like','%'.$name.'%'];
        }

        $age=$req['age']??'';
        if ($age) {
            $where[]=['age','=',$age];
        }
        
        $data=DB::table('student')->where($where)->paginate(3);
        // dd($data);
        return view('list',['data'=>$data,'name'=>$name,'age'=>$age]);
    }

    public function update()
    {
        $req=request()->all();
        $data=DB::table('student')->where(['id'=>$req['id']])->first();
        return view('update',['data'=>$data]);
    }

    //第二种验证
    public function doupdate(storeStudentPost $request)
    {
        $req=request()->all();
        dd($req);
        $data=DB::table('student')->where(['id'=>$req['id']])->update();
        if ($data) {
            return redirect('list');
        } else {
            echo "修改失败";
        }
    }

    public function delete($id)
    {
        $data=DB::table('student')->where($id)->delete();
    }

    public function upload($headimg)
    {
        if (request()->file($headimg)->isValid()) {
            $photo = request()->file($headimg);
            $store_result = $photo->store('', 'public');
            return $store_result;
        }
        exit('未获取到上传文件或上传过程出错');
    }

    public function session()
    {
        $user = ['uid'=>1,'name'=>'xiaole'];
        //存session
        //session(['user'=>$user]);
        request()->session()->put('user',$user);
        //取session
        $user = session('user');
        //$user = request()->session()->get('user');
        //删除session
        //session(['user'=>null]);
        //$user = session('user');
        
        // request()->session()->pull('user');
        // request()->session()->forget('user');
        // request()->session()->flush();
        $user = request()->session()->get('user');
        dd($user);

        return view('session');
    }
}