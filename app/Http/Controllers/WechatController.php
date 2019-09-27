<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use DB;
use App\Tools\Tools;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\File;

class WechatController extends Controller
{
	public $tools;
    public $client;
    public function __construct(Tools $tools,Client $client)
    {
        $this->tools = $tools;
        $this->client = $client;
    }
    /**
     * 调用频次清0
     */
    public function  clear_api(){
        $url = 'https://api.weixin.qq.com/cgi-bin/clear_quota?access_token='.$this->tools->get_wechat_access_token();
        $data = ['appid'=>env('WECHAT_APPID')];
        $this->tools->curl_post($url,json_encode($data));
    }
    public function post_test()
    {
        dd($_POST);
    }
    /**
     * 微信素材管理页面
     */
    public function wechat_source(Request $request,Client $client)
    {
        $req = $request->all();
        empty($req['source_type'])?$source_type = 'image':$source_type=$req['source_type'];
        if(!in_array($source_type,['image','voice','video','thumb'])){
            dd('类型错误');
        }
        if($req['page'] <= 0 ){
            dd('页码错误');
        }
        empty($req['page'])?$page = 1:$page=$req['page'];
        if($page <= 0 ){
            dd('页码错误');
        }
        $pre_page = $page - 1;
        $pre_page <= 0 && $pre_page = 1;
        $next_page = $page + 1;
        $url = 'https://api.weixin.qq.com/cgi-bin/material/batchget_material?access_token='.$this->tools->get_wechat_access_token();
        $data = [
            'type' =>$source_type,
            'offset' => $page == 1 ? 0 : ($page - 1) * 20,
            'count' => 20
        ];
        //guzzle使用方法
//        $r = $client->request('POST', $url, [
//            'body' => json_encode($data)
//        ]);
//        $re = $r->getBody();
        $re = $this->tools->redis->get('source_info');
        //$re = $this->curl_post($url,json_encode($data));
        $info = json_decode($re,1);
        $media_id_list = [];
        foreach($info['item'] as $v){
            $media_id_list[] = $v['media_id'];
        }
        $source_info = DB::connection('mysql_cart')->table('wechat_source')->whereIn('media_id',$media_id_list)->get();
        //dd($source_info);
        return view('Wechat.source',['info'=>$source_info,'pre_page'=>$pre_page,'next_page'=>$next_page,'source_type'=>$source_type]);
    }
    /**
     * 上传
     */
    public function upload(){
        return view('Wechat.upload',[]);
    }
    /**
     * image video voice thumb
     * id media_id type[类型] path ['/storage/wechat/image/imagename.jpg'] add_time
     * @param Request $request
     */
    public function do_upload(Request $request,Client $client){
        $type = $request->all()['type'];
        $source_type = '';
        switch ($type){
            case 1: $source_type = 'image'; break;
            case 2: $source_type = 'voice'; break;
            case 3: $source_type = 'video'; break;
            case 4: $source_type = 'thumb'; break;
            default;
        }
        $name = 'file_name';
        if(!empty($request->hasFile($name)) && request()->file($name)->isValid()){
            //大小 资源类型限制
            $ext = $request->file($name)->getClientOriginalExtension();  //文件类型
            $size = $request->file($name)->getClientSize() / 1024 / 1024;
            if($source_type == 'image'){
                if(!in_array($ext,['jpg','png','jpeg','gif'])){
                    dd('图片类型不支持');
                }
                if($size > 2){
                    dd('太大');
                }
            }elseif($source_type == 'voice'){
                if (!in_array($ext,['AMR','MP3'])){
                    dd('语音类型不支持');
                }
                if ($size > 2){
                    dd('太大');
                }
            }elseif ($source_type == 'video'){
                if (!in_array($ext,['MP4'])){
                    dd('视频类型不支持');
                }
                if ($size > 10){
                    dd('太大');
                }
            }
            $file_name = time().rand(1000,9999).'.'.$ext;
            $path = request()->file($name)->storeAs('wechat/'.$source_type,$file_name);
//            dd($path);
            $storage_path = '/storage/'.$path;
//            dump($storage_path);
            $path='./storage/'.$path;
//            dd($path);
            $path = realpath('./storage/'.$path);
            dd($path);
            $url = 'https://api.weixin.qq.com/cgi-bin/material/add_material?access_token='.$this->tools->get_wechat_access_token().'&type='.$source_type;
            //$result = $this->curl_upload($url,$path);
            $result = $this->guzzle_upload($url,$path,$client);
            $re = json_decode($result,1);
            //插入数据库
            DB::connection('mysqlshop')->table('wechat_source')->insert([
                'media_id'=>$re['media_id'],
                'type' => $type,
                'path' => $storage_path,
                'add_time'=>time()
            ]);
            echo 'ok';
        }
    }

    public function guzzle_upload($url,$path,$client,$is_video=0,$title='',$desc=''){
        dd($path);
        $multipart =  [
            [
                'name'     => 'media',
                'contents' => fopen($path, 'r')
            ]
        ];
        if($is_video == 1){
            $multipart[] = [
                'name'=>'description',
                'contents' => json_encode(['title'=>$title,'introduction'=>$desc],JSON_UNESCAPED_UNICODE)
            ];
        }
        $result = $client->request('POST',$url,[
            'multipart' => $multipart
        ]);
        return $result->getBody();
    }

    public function get_access_token()
    {
    	return $this->tools->get_wechat_access_token();
    }
    /**
     * curl上传微信素材
     * @param $url
     * @param $path
     * @return bool|string
     */
    public function curl_upload($url,$path)
    {
        $curl = curl_init($url);
        curl_setopt($curl,CURLOPT_RETURNTRANSFER,true);
        curl_setopt($curl,CURLOPT_POST,true);  //发送post
        $form_data = [
            'media' => new \CURLFile($path)
        ];
        curl_setopt($curl,CURLOPT_POSTFIELDS,$form_data);
        $data = curl_exec($curl);
        //$errno = curl_errno($curl);  //错误码
        //$err_msg = curl_error($curl); //错误信息
        curl_close($curl);
        return $data;
    }




    public function get_user_list()
	{
		$result=file_get_contents('https://api.weixin.qq.com/cgi-bin/user/get?access_token='.$this->tools->get_wechat_access_token().'&next_openid=');
		$re=json_decode($result,1);
		$last_info=[];
		foreach ($re['data']['openid'] as $k => $v) {
			$user_info=file_get_contents('https://api.weixin.qq.com/cgi-bin/user/info?access_token='.$this->tools->get_wechat_access_token().'&openid='.$v.'&lang=zh_CN');
			$user=json_decode($user_info,1);
			// dd($user);
			$last_info[$k]['nickname']=$user['nickname'];
			$last_info[$k]['openid']=$v;
		}
		$last_info=json_encode($last_info);
		$last_info=json_decode($last_info);
		// dd($last_info);
		return view('wechat.list',['last_info'=>$last_info]);
	}

	public function get_user_xiang()
	{
		$result=file_get_contents('https://api.weixin.qq.com/cgi-bin/user/get?access_token='.$this->tools->get_wechat_access_token().'&next_openid=');
		$re=json_decode($result,1);
		$last_info=[];
		foreach ($re['data']['openid'] as $k => $v) {
			$user_info=file_get_contents('https://api.weixin.qq.com/cgi-bin/user/info?access_token='.$this->tools->get_wechat_access_token().'&openid='.$v.'&lang=zh_CN');
			$user=json_decode($user_info,1);
			// dd($user);
			$last_info[$k]['nickname']=$user['nickname'];
			$last_info[$k]['headimgurl']=$user['headimgurl'];
			$last_info[$k]['city']=$user['city'];
			$last_info[$k]['openid']=$v;
		}
		$last_info=json_encode($last_info);
		$last_info=json_decode($last_info);
		// dd($last_info);
		return view('wechat.xiang',['last_info'=>$last_info]);
	}

	public function send_template_massage(){
        $openid='obB01uHNGlEHsu2fGiw-pCb5tpOQ';
        $url='http://api.weixin.qq.com/cgi-bin/message/template/send?access_token='.$this->tools->get_wechat_access_token().'';
        $data=[
            'touser' => $openid,
            'template_id' => '26ECp-qUQcgccM-ffEpKDHhwIVX1jOyIzBxgqc72lxo',
            'url' => 'http://www.1901.com',
            'data'=>[
                'first'=>[
                    'value'=>'恭喜您',
                    'color'=>'red'
                ],
                'keyword1'=>[
                    'value'=>'姜英丽女士',
                    'color'=>'black'
                ],
                'keyword2'=>[
                    'value'=>'您已被本公司选为2019年的形象大使！',
                    'color'=>'red'
                ]
            ]
        ];

        $res = $this->tools->curl_post($url,json_encode($data,JSON_UNESCAPED_UNICODE));
//        dd($res);
        $result = json_decode($res,1);
        dd($result);
    }
}
