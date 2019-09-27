<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>登录</title>
</head>
<body>
    <center>
        <h1>登录</h1>
        <form action="{{url('home/list')}}" method="post">
            @csrf
            <input type="text" value="用户名" name="name" id=""><br/>
            <input type="text" value="密码" name="pwd" id=""><br/>
            <input type="submit" value="登录" name="" id="">
        </form>
    </center>
</body>
</html>