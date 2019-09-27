<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MailController extends Controller
{
    public function index()
    {
        $email="cxy99217@163.com";
        $this->send($email);
    }

    // public function send($email)
    // {
    //     \Mail::send('email',['name'=>$email],function($message)use($email){
    //         //设置主题
    //         $message->subject('欢迎注册');
    //         //设置接收方
    //         $message->to($email);
    //     });
    // }

    public function send($email)
    {
        $msg="欢迎注册万能集团-万能SHOP,您的验证码是".rand(1000,9999);
        \Mail::rav($msg,function($message)use($email){
            //设置主题
            $message->subject('万能集团');
            //设置接收方
            $message->to($email);
        });
    }
}