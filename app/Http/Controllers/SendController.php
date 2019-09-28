<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Tools\Tools;
use DB;

class SendController extends Controller
{
    public $tools;
    public function __construct(Tools $tools)
    {
        $this->tools=$tools;
    }

    public function get_access_token()
    {
        return $this->tools->get_wechat_access_token();
    }

    public function send()
    {
        $xml_string=file_get_contents('php://input');
        $wechat_log_psth=storage_path('logs/wechat'.date('Y-m-d H:i:s').'.log');
        file_put_contents($wechat_log_psth,"<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<\n",FILE_APPEND);
        file_put_contents($wechat_log_psth,$xml_string,FILE_APPEND);
        file_put_contents($wechat_log_psth,"\n<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<\n\n",FILE_APPEND);
        $xml_obj=simplexml_load_string($xml_string,'SimpleXMLElement',LIBXML_NOCDATA);
        $xml_arr=(array)$xml_obj;
        \Log::Info(json_encode($xml_arr,JSON_UNESCAPED_UNICODE));

        if ($xml_string['MsgType']=='event' && $xml_string['Event']=='subscribe'){
            $user_re=file_get_contents('https://api.weixin.qq.com/cgi-bin/user/info?access_token='.$this->tools->get_wechat_access_token().'&openid='.$xml_arr['FromUserName'].'&lang=zh_CN');
            $user_info=json_decode($user_re,1);
            $db_user=DB::table('user_weixin')->where(['openid'=>$xml_arr['FromUserName']])->first();
            if (empty($db_user)){
                DB::table('user_weixin')->insert([
                    'openid'=>$user_info['openid'],
                    'nickname'=>$user_info['nickname'],
                    'time'=>time(),

                ]);
                $message='您好，'.$user_info['nickname'].'：当前时间时间为'.time().'';
                $xml_str = '<xml><ToUserName><![CDATA['.$xml_arr['FromUserName'].']]></ToUserName><FromUserName><![CDATA['.$xml_arr['ToUserName'].']]></FromUserName><CreateTime>'.time().'</CreateTime><MsgType><![CDATA[text]]></MsgType><Content><![CDATA['.$message.']]></Content></xml>';
                echo $xml_str;
            }else{
                $message='欢迎回来'.$user_info['nickname'].':当前时间为'.time().'';
                $xml_str = '<xml><ToUserName><![CDATA['.$xml_arr['FromUserName'].']]></ToUserName><FromUserName><![CDATA['.$xml_arr['ToUserName'].']]></FromUserName><CreateTime>'.time().'</CreateTime><MsgType><![CDATA[text]]></MsgType><Content><![CDATA['.$message.']]></Content></xml>';
                echo $xml_str;
            }
        }
    }
}
