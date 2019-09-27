<!DOCTYPE html>
<html>
<head>
	<title>登录</title>
</head>
<body>
	<form action="{{url('exam/dologin')}}" method="get">
		@csrf
		用户名<input type="text" name="user_name"><br>
		密码<input type="password" name="pwd"><br>
		<input type="submit" value="登录">
	</form>
</body>
</html>