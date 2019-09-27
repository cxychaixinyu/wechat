<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>学生列表</title>
</head>
<body>
    <center>
        <h2><a href="{{url('students/lxlist')}}">离校学生列表</a>
        <a href="{{url('students/add')}}">添加</a></h2>
        <table border="1">
            <tr>
                <td>学生姓名</td>
                <td>年龄</td>
                <td>地址</td>
                <td>操作</td>
            </tr>
            @foreach($data as $v)
            <tr>
                <td>{{$v->name}}</td>
                <td>{{$v->age}}</td>
                <td>@if($v->adress == 0)房山 @else 昌平 @endif</td>
                <td><a href="{{url('students/update')}}?id={{$v->id}}">修改</a>|<a href="{{url('students/delete')}}?id={{ $v->id }}">删除</a></td>
            </tr>
            @endforeach
        </table>
    </center>
</body>
</html>