<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">


    <title> - 登录</title>
    <meta name="keywords" content="">
    <meta name="description" content="">

    <link rel="shortcut icon" href="favicon.ico"> <link href="../../../css/css-h/bootstrap.min.css?v=3.3.6" rel="stylesheet">
    <link href="../../../css/css-h/font-awesome.css?v=4.4.0" rel="stylesheet">

    <link href="../../../css/css-h/animate.css" rel="stylesheet">
    <link href="../../../css/css-h/style.css?v=4.1.0" rel="stylesheet">
    <!--[if lt IE 9]>
    <meta http-equiv="refresh" content="0;ie.html" />
    <![endif]-->
    <script>if(window.top !== window.self){ window.top.location = window.location;}</script>
</head>

<body class="gray-bg">

    <div class="middle-box text-center loginscreen  animated fadeInDown">
        <div>
            <div>

                <h1 class="logo-name">h</h1>

            </div>
            <h3>欢迎使用 hAdmin</h3>

            <form action="{{url('hAdmin/dologin')}}" class="m-t" role="form" >
                @csrf
                <div class="form-group">
                    <input type="text" name="username" class="form-control" placeholder="用户名" required="">
                </div>
                <div class="form-group">
                    <input type="password" name="password" class="form-control" placeholder="密码" required="">
                </div>
                <div>
                    <input type="text" class="form-control"><button id="btn" type="button" class="btn btn-info">获取验证码</button>
                </div>

                <button type="submit" class="btn btn-primary block full-width m-b">登 录</button>


                <p class="text-muted text-center"> <a href="login.blade.php#"><small>忘记密码了？</small></a> | <a href="register.html">注册一个新账号</a>
                </p>

            </form>
        </div>
    </div>

    <!-- 全局js -->
    <script src="../../../js/js-h/jquery.min.js?v=2.1.4"></script>
    <script src="../../../js/js-h/bootstrap.min.js?v=3.3.6"></script>
    <script>
        $('#btn').click(function () {
            var obj={};
            obj.username=$('input[name="username"]').val();
            obj.password=$('input[name="password"]').val();
            var _token=$('input[name="_token"]').val();
            $.ajax({
                url:"send",
                method:"post",
                data:{obj,_token},
                success:function (res) {
                    alert(111);
                }
            })
        })
    </script>



</body>

</html>
