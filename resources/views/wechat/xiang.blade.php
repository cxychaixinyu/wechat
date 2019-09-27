<html>
    <head>
        <title>用户列表</title>
    </head>
    <body>
        <center>
            <table border="1">
                <tr>
                    <td>用户昵称</td>
                    <td>城市</td>
                    <td>头像</td>
                </tr>
                @foreach($last_info as $v)
                    <tr>
                        <td>{{$v->nickname}}</td>
                        <td>{{$v->city}}</td>
                        <td><img src="{{$v->headimgurl}}" alt=""></td>
                    </tr>
                @endforeach
            </table>
        </center>
    </body>
</html>