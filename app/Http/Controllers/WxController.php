<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Tools\Tools;
use DB;
class WxController extends Controller
{
    public $tools;
    public function __construct(Tools $tools)
    {
        $this->tools = $tools;
    }

    public function login()
    {
        return view('wx/login');
    }

    public function wx_login()
    {
        $redirect_uri = "http://www.1901.com/wx/code";
        $url = 'https://open.weixin.qq.com/connect/oauth2/authorize?appid=' . env('WECHAT_APPID') . '&redirect_uri=' . urlencode($redirect_uri) . '&response_type=code&scope=snsapi_userinfo&state=STATE#wechat_redirect';
        header('Location:' . $url);
    }

    public function code()
    {
        $res = request()->all();
        $result = file_get_contents('https://api.weixin.qq.com/sns/oauth2/access_token?appid=' . env('WECHAT_APPID') . '&secret=' . env('WECHAT_SECRET') . '&code=' . $res['code'] . '&grant_type=authorization_code');
        $re = json_decode($result, 1);
        $user_info = file_get_contents('https://api.weixin.qq.com/sns/userinfo?access_token=' . $re['access_token'] . '&openid=' . env('WECHAT_APPID') . '&lang=zh_CN');
        $wechat_user_info = json_decode($user_info, 1);
        $openid = $re['openid'];
        $wechat_info = DB::table('user_wechat')->where(['openid' => $openid])->first();
//    	dd($wechat_info);
        if (!empty($wechat_info)) {
            //存在 登录
            request()->session()->put('uid', $wechat_info->uid);
            echo "ok";
            return redirect('wx/list');
        } else {
            //不存在,注册,登录
            //插入user表数据一条
            DB::beginTransaction();//打开事务
            $uid = DB::table('user')->insertGetid([
                'name' => $wechat_user_info['nickname'],
                'password' => '',
                'time' => time(),
            ]);
            $insert_result = DB::table('user_wechat')->insert([
                'uid' => $uid,
                'openid' => $openid
            ]);
            //登录操作
            request()->session()->put('uid', $wechat_info->uid);
            echo "ok";
            return redirect('wx/list');
        }


    }

    public function get_access_token()
    {
        return $this->tools->get_wechat_access_token();
    }

    public function list()
    {
        $result = file_get_contents('https://api.weixin.qq.com/cgi-bin/user/get?access_token=' . $this->tools->get_wechat_access_token() . '&next_openid=');
        $re = json_decode($result, 1);
        $last_info = [];
        foreach ($re['data']['openid'] as $k => $v) {
            $user_info = file_get_contents('https://api.weixin.qq.com/cgi-bin/user/info?access_token=' . $this->tools->get_wechat_access_token() . '&openid=' . $v . '&lang=zh_CN');
            $user = json_decode($user_info, 1);
            // dd($user);
            $last_info[$k]['nickname'] = $user['nickname'];
            $last_info[$k]['openid'] = $v;
        }
        $last_info = json_encode($last_info);
        $last_info = json_decode($last_info);
        // dd($last_info);
        return view('wx/list', ['last_info' => $last_info]);
    }
}
