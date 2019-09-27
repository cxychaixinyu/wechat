<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Document</title>
    <link rel="stylesheet" href="/css/bootstrap.min.css">
    <script src="{{asset('js/jquery-1.7.2.min.js')}}"></script>
</head>
<body>
    <center>
        <a href="{{url('url/add')}}">添加</a>
        <form action="{{url('url/list')}}" method="get">
            @csrf
            网站名称: <input type="text" name="name" value="{{$name}}">
            <input type="submit" value="搜索">
        </form>
        <table border="1">
            <tr>
                <td>网站名称</td>
                <td>网站logo</td>
                <td>链接类型</td>
                <td>状态</td>
                <td>操作</td>
            </tr>
            @foreach($data as $v)
            <tr>
                <td>{{$v->name}}</td>
                <td> <img src="{{env('UPLOAD_URL')}}{{$v->logo}}" height="100"> </td>
                <td>@if($v->linktype == 0)logo链接 @else 文字链接 @endif</td>
                <td>@if($v->show == 0)是 @else 否 @endif</td>
                <td><a href="{{url('url/update')}}?id={{$v->id}}">修改</a>|<a class="del" id="{{$v->id}}">删除</a></td>
            </tr>
            @endforeach
        </table>
        {{ $data->appends(['name'=>$name])->links() }}
        
    </center>
</body>
<script>
    $('.del').click(function(){
    	var _this=$(this);
    	var id = $(this).attr('id');


    	$.ajax({
            url: "{{url('url/delete')}}",
            method: 'post',
            data: {id:id},
            dataType: 'json',
            async: true,
            success: function(res){
                if (res.code==1) {
                    _this.parents('tr').remove();
                    location.href="{{url('url/list')}}";
                };    
            } 
    	});	




    });

</script>
</html>