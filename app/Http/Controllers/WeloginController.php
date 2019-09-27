<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
class WeloginController extends Controller
{
    public function login()
    {
    	return view('welogin/login');
    }

    public function welogin_login()
    {
    	//定义地址
    	$redirect_uri='http://www.1901.com/welogin/code';
    	$url = 'https://open.weixin.qq.com/connect/oauth2/authorize?appid='.env('WECHAT_APPID').'&redirect_uri='.urlencode($redirect_uri).'&response_type=code&scope=snsapi_userinfo&state=STATE#wechat_redirect';
    	header('Location:'.$url);
    }


    public function code()
    {
    	$res=request()->all();
    	// dd($res);
    	$result = file_get_contents('https://api.weixin.qq.com/sns/oauth2/access_token?appid='.env('WECHAT_APPID').'&secret='.env('WECHAT_SECRET').'&code='.$res['code'].'&grant_type=authorization_code');
    	$re = json_decode($result,1);
    	// dd($re);
    	$user_info = file_get_contents('https://api.weixin.qq.com/sns/userinfo?access_token='.$re['access_token'].'&openid='.env('WECHAT_APPID').'&lang=zh_CN');
    	$wechat_user_info = json_decode($user_info,1);
    	$openid=$re['openid'];
    	$wechat_info=DB::table('user_wechat')->where(['openid'=>$openid])->first();
//    	dd($wechat_info);
    	if (!empty($wechat_info)) {
    		//存在 登录
    		request()->session()->put('uid',$wechat_info->uid);
    		echo "ok";
    		return redirect('wx.list');
    	} else {
    		//不存在,注册,登录
    		//插入user表数据一条
    		DB::beginTransaction();//打开事务
    		$uid=DB::table('user')->insertGetid([
    			'name'=>$wechat_user_info['nickname'],
    			'password'=>'',
    			'time'=>time(),
    		]);
    		$insert_result=DB::table('user_wechat')->insert([
    			'uid'=>$uid,
    			'openid'=>$openid
    		]);
    		//登录操作
    		request()->session()->put('uid',$wechat_info->openid);
    		echo "ok";
            return redirect('wx.list');
        }

    }
}
