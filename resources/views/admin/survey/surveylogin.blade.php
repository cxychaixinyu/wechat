<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>登录题库</title>
</head>
<body>
    <center>
        <form action="{{url('admin/dologin')}}" method="post">
            @csrf
            账号<input type="text" name="name">
            密码<input type="password" name="pwd">
            <input type="submit" value="登录" id="">
        </form>
    </center>
</body>
</html>