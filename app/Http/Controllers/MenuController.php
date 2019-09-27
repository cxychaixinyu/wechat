<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Tools\Tools;
use DB;

class MenuController extends Controller
{
    public $tools;
    public function __construct(Tools $tools)
    {
        $this->tools=$tools;
    }

    public function list()
    {
        $info=DB::table('menu')->orderby('name1','asc','name2','asc')->get();
        return view('menu.list',['info'=>$info]);
    }

    public function add()
    {
        $req=request()->all();
        $button_type=!empty($req['name2'])?2:1;
        $result=DB::table('menu')->insert([
            'name1'=>$req['name1'],
            'name2'=>$req['name2'],
            'type'=>$req['type'],
            'button_type'=>$button_type,
            'event_value'=>$req['event_value']
        ]);
        if (!$result){
            dd('插入失败');
        }
        $this->load_menu();
    }

    public function load_menu()
    {
        $data=[];
        $menu_list=DB::table('menu')->select('name1')->groupBy('name1')->get();
        foreach ($menu_list as $vv){
            $menu_info=DB::table('menu')->where(['name1'=>$vv->name1])->get();
            $menu=[];
            foreach ($menu_info as $v){
                $menu[]=(array)$v;
            }
            $arr=[];
            foreach ($menu as $v){
                if ($v['button_type']==1){
                    if ($v['type']==1){
                        $arr=[
                            'type'=>'click',
                            'name'=>$v['name1'],
                            'url'=>$v['event_value']
                        ];
                    }elseif ($v['type']==2){
                        $arr=[
                            'type'=>'view',
                            'name'=>$v['name1'],
                            'url'=>$v['event_value']
                        ];
                    }
                }elseif ($v['button_type']==2){
                    $arr['name']=$v['name1'];
                    if ($v['type']==1){
                        $button_arr=[
                            'type'=>'click',
                            'name'=>$v['name2'],
                            'key'=>$v['event_value']
                        ];
                    }elseif ($v['type']==2){
                        $button_arr=[
                            'type'=>'view',
                            'name'=>$v['name2'],
                            'url'=>$v['event_value']
                        ];
                    }
                    $arr['sub_button'][]=$button_arr;
                }
            }
            $data['button'][]=$arr;
        }
        $url='https://api.weixin.qq.com/cgi-bin/menu/create?access_token=\'.$this->tools->get_wechat_access_token()';
        $re=$this->tools->curl_post($url,json_encode($data,JSON_UNESCAPED_UNICODE));
        $result=json_decode($re,1);
        dd($result);
    }
}
