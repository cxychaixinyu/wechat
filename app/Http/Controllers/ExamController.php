<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class ExamController extends Controller
{
    public function login()
    {
    	


    	return view('exam/login');
    	
    	
    }

    public function dologin()
    {
    	$req=request()->all();
    	$where=[];
    	$where[]=[
    		'user_name'=>$req['user_name'],
    		'pwd'=>$req['pwd'],
    	];
    	// dd($where);
    	$data=DB::table('user')->where(['user_name'=>$req['user_name'],'pwd'=>$req['pwd']])->first();
    	$data=json_decode(json_encode($data),true);
    	// dd($data);
    	if ($data) {
    		session(['user'=>$data]);
    		// $user=session('user');
    		// dd($user);
    		return redirect('exam/list');
    	} else {
    		echo "<script>alert('用户名或密码错误')</script>";
    	}
    }

    public function add()
    {
    	return view('exam/add');
    }

    public function doadd()
    {
    	$time=strtotime('2019-08-29,13:00:00');
    	$time=substr($time,5,5);
    	$dtime=time();
    	$dtime=substr($dtime,5,5); 
    	$xtime=strtotime('2019-08-29,17:00:00');
    	$xtime=substr($xtime,5,5);
    	if ($dtime>$time && $dtime<$xtime) {
    		$req=request()->except('_token');
	    	$req['time']=time();
	    	
	    	
	    	if(request()->hasfile('img')){
	            $req['img']=$this->upload('img');
	            // dd($req['img']);
	        }
	    	$data=DB::table('exam')->insert($req);
	    	if ($data) {
	    		return redirect('exam/list');
	    	} else {
	    		echo "<script>alert('添加失败')</script>";
	    	}
    	} else {
    		echo "<script>alert('不在操作时间内')</script>";
    		return redirect('exam/add');
    	}
    	
    	
    	
    }

    public function list()
    {
    	$data=DB::table('exam')->get();
        dd($data);
    	return view('exam/list',['data'=>$data]);
    }

    public function out()
    {
    	$req=request()->post('id');
    	$data=DB::table('exam')->where(['id'=>$req])->first();
    	return view('exam/out',['data'=>$data]);
    }

    public function doout()
    {
    	$time=strtotime('2019-08-29,12:00:00');
    	$time=substr($time,5,5);
    	$dtime=time();
    	$dtime=substr($dtime,5,5); 
    	$xtime=strtotime('2019-08-29,17:00:00');
    	$xtime=substr($xtime,5,5);

    	if ($dtime>$time && $dtime<$xtime) {
	    	$id=request()->input('id');
	    	// dd($id);
	    	$number=request()->post('num');
	    	$number=json_decode(json_encode($number),true);
	    	$data=DB::table('exam')->where(['id'=>$id])->first();
	    	// dd($data);
	    	$data=json_decode(json_encode($data),true);

	    	
	    	// dd($data);
	    	$num=$data['num'];
	    	$num=($num-$number);
	    	$data=DB::table('exam')->where(['id'=>$id])->update(['num'=>$num]);
	    	return redirect('exam/list');
    	} else {
    		echo "<script>alert('不在操作时间内')</script>";
    		return redirect('exam/add');
    	}

    }

    public function jilu()
    {
    	$data=DB::table('jilu')->get();
    	return view('exam/jilu',['data'=>$data]);
    }

    public function upload($img)
    {
    	if (request()->file($img)->isValid()) {
            $photo = request()->file($img);
            $store_result = $photo->store('', 'public');
            return $store_result;
        }
        exit('未获取到上传文件或上传过程出错');
    }
}
