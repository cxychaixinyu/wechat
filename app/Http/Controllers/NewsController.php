<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class NewsController extends Controller
{
    public function add()
    {
        return view('news/add');
    }

    public function doadd()
    {
        $req=request()->except('_token');
        $req['time']=time();
        $data=DB::table('news')->insert($req);
        if ($data) {
            return redirect('new/list');
        }
    }

    public function list()
    {
        $data=DB::table('news')->get();
        $data=json_decode(json_encode($data),true);

        $rela = DB::table('relation')->where(['uid' => session('user')['uid']])->get();
        $rela = json_decode(json_encode($rela),true);

        $dianzan = array_column($rela, 'news_id');

        foreach($data as $key => $val) {
            $v = Redis::get('dianzan' . $val['news_id']);
            $data[$key]['dian'] = empty($v) ? 0 : $v;


            $data[$key]['flag'] = in_array($val['news_id'], $dianzan) ? '取消点赞' : '点赞';
        }

        // dd($data);
        return view('news/index',compact('data'));
    }

    public function red()
    {
        $id   = request()->get('id');
        $flag = request()->get('flag');

        if ($flag == '点赞') {
            Redis::incr('dianzan' . $id);
            // 新增点赞关系
            DB::table('relation')->insert(['uid' => session('user')['u_id'], 'news_id' => $id]);
        } else {
            Redis::decr('dianzan' . $id);
            // 删除点赞关系
            DB::table('relation')->where(['uid' => session('user')['u_id'], 'news_id' => $id])->delete();
        }

        echo Redis::get('dianzan' . $id);
    }
}
