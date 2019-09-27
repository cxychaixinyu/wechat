@extends('layouts.shop')
@section('title', '登录')
@section('content')
<header>
    <a href="javascript:history.back(-1)" class="back-off fl"><span class="glyphicon glyphicon-menu-left"></span></a>
    <div class="head-mid">
        <h1>会员注册</h1>
    </div>
</header>
    <div class="head-top">
      <img src="{{asset('home/images/head.jpg')}}" />
    </div><!--head-top/-->
    <form action="{{url('user')}}" method="get" class="reg-login">
        <h3>还没有三级分销账号？点此<a class="orange" href="{{url('reg')}}">注册</a></h3>
        @csrf
        <div class="lrBox">
            <div class="lrList"><input type="text" name="user_name" placeholder="输入手机号码或者邮箱号" /></div>
            <div class="lrList"><input type="text" name="pwd" placeholder="输入密码" /></div>
        </div><!--lrBox/-->
        <div class="lrSub">
            <input type="submit" id="btn" value="立即登录" />
        </div>
    </form><!--reg-login/-->
    @include('public.footer')
@endsection
<script>
    $(function(){
        layui.use('layer',function(){
            var layer=layui.layer;
            $(document).on('click','#btn',function(){
                var obj={};
                obj.user_name=$('input[name="user_name"]').val();
                var _token=$('input[name="_token"]').val()
                obj.pwd=$('input[name="pwd"]').val();
                if (obj.user_name=='' || obj.pwd=='') {
                    layer.msg('请填写完整信息',{icon:2});
                    return false;
                }

                $.ajax({
                    url:"dologin",
                    method:"post",
                    data:{obj,_token},
                    success:function(res){
                        layer.msg(res.font,{icon:res.code});
                        if(res.code==1){
                            location.href="index";
                        }
                    },
                    dataType:'json'
                });
            })
        })
    })
</script>