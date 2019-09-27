<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CommonController extends Controller
{
    //内部方法
	public function abort($msg,$url){
		echo "<script>alert('{$msg}');location.href='{$url}'</script>";
    }

    public function ok($font='操作成功',$code=1)
    {
        echo json_encode(['font'=>$font,'code'=>$code]);
        return;
    }

    public function no($font='操作失败',$code=2)
    {
        echo json_encode(['font'=>$font,'code'=>$code]);
        return;
    }
    
    public function send($user_name)
    {
        $msg="欢迎注册万能集团-万能SHOP,您的验证码是".rand(1000,9999);
        \Mail::rav($msg,function($message)use($user_name){
            //设置主题
            $message->subject('万能集团');
            //设置接收方
            $message->to($user_name);
        });
    }

    
}
