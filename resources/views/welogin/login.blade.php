<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>登录</title>
</head>
<body>
	<form>
	<p>
		用户名：<input type="text" name="">
	</p>
	<p>
		密码：<input type="password" name="">
	</p>
    <p>
        <button>登录</button>
    </p>
	<P>
		<button type="button" class="btn">第三方登录</button>
	</P>
	</form>
	<script src="/js/jquery.min.js"></script>
	<script type="text/javascript">
		$(function(){
			$('.btn').click(function(){
				window.location.href="{{url('welogin/welogin_login')}}";
			})


		})


	</script>


</body>
</html>
