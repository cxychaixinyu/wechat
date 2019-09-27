<link rel="stylesheet" href="/css/bootstrap.min.css">
<form action="{{url('stu/list')}}" method="post">
    姓名:<input type="text" name="name" value="{{$name}}">
    年龄: <input type="text" name="age" value="{{$age}}">
    <input type="submit" value="搜索">
</form>
<table>
    <tr>
        <td>姓名</td>
        <td>头像</td>
        <td>年龄</td>
        <td>性别</td>
        <td>操作</td>
    </tr>
    @foreach($data as $v)
    <tr>
        <td>{{$v->name}}</td>
        <td> <img src="{{env('UPLOAD_URL')}}{{$v->headimg}}" height="100"> </td>
        <td>{{$v->age}}</td>
        <td>@if($v->sex == 0)男 @else 女 @endif</td>
        <td><a href="{{url('stu/update')}}?id={{$v->id}}">修改</a> | <a href="{{url('stu/delete')}}?id={{$v->id}}">删除</a></td>
    </tr>
    @endforeach
</table>
{{ $data->links() }}

