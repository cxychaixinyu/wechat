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
<form action="{{url('login')}}" method="get" class="reg-login">
    <h3>已经有账号了？点此<a class="orange" href="{{url('login')}}">登陆</a></h3>
    @csrf
    <div class="lrBox">
        <div class="lrList"><input type="text" name="user_name" placeholder="输入手机号码或者邮箱号" /></div>
        <div class="lrList2"><input type="text" name="user_code" placeholder="输入短信验证码" /> <button class="code" id="sendEmailcode">获取验证码</button></div>
        <div class="lrList"><input type="password" name="pwd" placeholder="设置新密码（6-18位数字或字母）" /></div>
        <div class="lrList"><input type="password" name="pwd2" placeholder="再次输入密码" /></div>
    </div><!--lrBox/-->
    <div class="lrSub">
        <input type="submit" value="立即注册" />
    </div>
</form><!--reg-login/-->
    @include('public.footer')
@endsection
<script>
    $(function(){
        layui.use(['layer'],function(){
            var layer=layui.layer;
            var _token=$('input[name="_token"]').val();
            $(document).on('click','.code',function(){
                var _this=$(this);
                var user_name=$('input[name="user_name"]').val();
                var flag=false;
                if (user_name=='') {
                    layer.msg('请填写邮箱或手机号',{icon:2});
                    return false;
                }

                //根据长度判断是邮箱还是手机
                if (user_name.length>11) {
                    var reg=/^\w+@\w+.com$/i;
                    if (!reg.test(user_name)) {
                        layer.msg('邮箱格式不正确',{icon:2});
                        return flase;
                    }else{
                        //验证唯一性
                        $.ajax({
                            url:'checkMail',
                            method:'post',
                            async:false,
                            data:{user_name:user_name,_token:_token},
                            success:function(res){
                                if (res.code==2) {
                                    layer.msg(res.font,{icon:res.code});
                                    flag=false;
                                } else {
                                    flag=true;
                                }
                            },
                            dataType:'json',
                        });
                        if (flag==false) {
                            return false;
                        }
                        //发送邮箱验证码
                        $.post(
                            "sendEmail",
                            {user_name:user_name,_token:_token},
                            function(msg){                                
                                layer.msg(msg.font,{icon:msg.code});                                
                            },
                            'json',
                        );
                    }

                } else {
                    var reg=/^1[345789]\d{9}$/;
                    if (!reg.test(user_name)) {
                        layer.msg('手机号格式不正确',{icon:2});
                        return false;
                    } else {
                        //验证唯一性
                        $.ajax({
                            url:'checkTel',
                            method:'post',
                            async:false,
                            data:{user_name:user_name,_token:_token},
                            success:function(res){
                                if (res.code==2) {
                                    layer.msg(res.font,{icon:res.code});
                                    flag=false;
                                } else {
                                    flag=true;
                                }
                            },
                            dataType:'json',
                        });
                        if (flag==false) {
                            return false;
                        }
                    }
                }
                
            });

            $(document).on('click','#btn',function(){
                var layer=layui.layer;
                var _token=$('input[name="_token"]').val();
            })
        })
    })
</script>