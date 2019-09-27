<html>
<head>
    <title>用户列表</title>
</head>
<body>
<center>
    <table border="1">
        <tr>
            <td>用户昵称</td>
            <td>用户openid</td>
            <td>操作</td>
        </tr>
        @foreach($last_info as $v)
            <tr>
                <td>{{$v->nickname}}</td>
                <td>{{$v->openid}}</td>
                <td><a href="{{url('wx/text')}}">推送消息</a></td>
            </tr>
        @endforeach
    </table>
</center>
</body>
</html>
