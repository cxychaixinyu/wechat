<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>添加用户-有点</title>
<link rel="stylesheet" type="text/css" href="{{asset('css/css.css')}}" />
<script type="text/javascript" src="{{asset('js/jquery.min.js')}}"></script>
</head>
<body>
	<div id="pageAll">
		<div class="pageTop">
			<div class="page">
				<img src="{{asset('img/coin02.png')}}" /><span><a href="#">首页</a>&nbsp;-&nbsp;<a
					href="#">公共管理</a>&nbsp;-</span>&nbsp;意见管理
			</div>
		</div>
		<div class="page ">
			<!-- 会员注册页面样式 -->
			<div class="banneradd bor">
                <form action="{{url('admin/user/doupdate')}}" method="post">
                    @csrf
                    <div class="baTopNo">
                        <span>会员注册</span>
                    </div>
                    <div class="baBody">
                        <div class="bbD">
                            &nbsp;&nbsp;&nbsp;用户名：<input type="text" value="{{$data->name}}" class="input3" name="name"/>
                        </div>
                        <div class="bbD">
                            用户等级：<input type="text" value="{{$data->level}}"  class="input3" name="level" />
                        </div>
                        <div class="bbD">
                            <p class="bbDP">
                                <input class="btn_ok btn_yes" type="submit" value="修改">
                                <a class="btn_ok btn_no" href="#">取消</a>
                            </p>
                        </div>
                    </div>
                </form>
			</div>

			<!-- 会员注册页面样式end -->
		</div>
	</div>
</body>
</html>