<?php

namespace App\Http\Controllers\hAdmin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use App\Model\Curl;

class LoginController extends Controller
{
    public function login()
    {
        return view('hAdmin.login');
    }

    public function dologin()
    {
        $res=request()->all();

    }

    public function send()
    {
        $user_name=\request()->all('user_name');
        $pass_word=\request()->all('password');
        $where=[];
        $where[]=[
            'user_name'=>$user_name,
            'password'=>$pass_word
        ];
        $res=DB::table('user')->where($where)->first();
        $openid=$res['openid'];
        $code=rand(1000,9999);
        $url='https://api.weixin.qq.com/cgi-bin/message/template/send?access_token='.$res['access_token'];
        $args=[
            'touser'=>$openid,
            'template_id'=>'26ECp-qUQcgccM-ffEpKDHhwIVX1jOyIzBxgqc72lxo',
            'data'=>[
                'code'=>[
                    'value'=>$code,
                    'color'=>"#173177"
                ],
                'name'=>[
                    'value'=>$user_name,
                    'color'=>"#173177"
                ],
                'time'=>[
                    'value'=>time(),
                    'color'=>"#173177"
                ]
            ]
        ];
        Curl::post($url,$args);
    }

    /**
     * 网页授权获取用户openid
     * @return [type] [description]
     */
    public static function getOpenid()
    {
        //echo 1;die;
        //先去session里取openid
        $openid = session('openid');
        //var_dump($openid);die;
        if(!empty($openid)){
            return $openid;
        }
        //微信授权成功后 跳转咱们配置的地址 （回调地址）带一个code参数
        $code = request()->input('code');
        if(empty($code)){
            //没有授权 跳转到微信服务器进行授权
            $host = $_SERVER['HTTP_HOST'];  //域名
            $uri = $_SERVER['REQUEST_URI']; //路由参数
            $redirect_uri = urlencode("http://".$host.$uri);  // ?code=xx
            $url = "https://open.weixin.qq.com/connect/oauth2/authorize?appid=".self::appid."&redirect_uri={$redirect_uri}&response_type=code&scope=snsapi_base&state=STATE#wechat_redirect";
            header("location:".$url);die;
        }else{
            //通过code换取网页授权access_token
            $url =  "https://api.weixin.qq.com/sns/oauth2/access_token?appid=".self::appid."&secret=".self::secret."&code={$code}&grant_type=authorization_code";
            $data = file_get_contents($url);
            $data = json_decode($data,true);
            $openid = $data['openid'];
            //获取到openid之后  存储到session当中
            session(['openid'=>$openid]);
            return $openid;
            //如果是非静默授权 再通过openid  access_token获取用户信息
        }
    }
}
