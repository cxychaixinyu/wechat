<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>学生列表</title>
</head>
<body>
    <center>
        <h2><a href="{{url('students/list')}}">在校学生列表</a></h2>
        <table border="1">
            <tr>
                <td>学生姓名</td>
                <td>年龄</td>
                <td>地址</td>
                <td>操作</td>
            </tr>
            @foreach($data as $v)
            <tr>
                <td>{{ $v->name }}</td>
                <td>{{ $v->age }}</td>
                <td>@if($v->adress == 0)房山 @else 昌平 @endif</td>
                <td><a href="{{url('students/lxupdate')}}?id={{$v->id}}">恢复</a></td>
            </tr>
            @endforeach
        </table>
    </center>
</body>
</html>