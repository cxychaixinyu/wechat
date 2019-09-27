<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Document</title>
</head>
<body>
    <form action="{{url('url/doupdate')}}?id={{$data->id}}" method="post" enctype="multipart/form-data">
        @csrf
        网站名称:<input type="text" name="name" value="{{$data->name}}" id=""><br/>
        网站网址: <input type="url" name="url" value="{{$data->url}}" id=""><br>
        链接类型: <input type="radio" name="linktype" value="0" id="" @if($data->linktype == 0) checked @endif>LOGO链接 <input type="radio" name="linktype" value="1" id="" @if($data->linktype == 1) checked @endif>文字链接<br>
        图片logo: <input type="file" name="logo" id=""><br>
        网站联系人: <input type="text" name="contacts" value="{{$data->contacts}}" id=""><br>
        网站介绍: <textarea name="content" id="" cols="30" rows="10" value="{{$data->content}}"></textarea><br>
        是否显示: <input type="radio" name="show" value="0" id="" @if($data->show == 0) checked @endif>是 <input type="radio" name="show" value="1" id="" @if($data->show == 1) checked @endif>否
        <input type="button" value="修改">
    </form>
</body>
</html>
<script src="{{asset('js/jquery-1.7.2.min.js')}}"></script>
<script>
    //验证学生姓名
    $('input[name="name"]').blur(function(){
        var name=$(this).val();
        var obj=$(this);
        $(this).next().remove();

        //中文 字母 .
        var reg=/^[\u4e00-\u9fa5A-Za-z.]{2,12}$/;
        if (!reg.test(name)) {
            $(this).after('<b style="color:red">学生姓名必须由中文字母.组成,长度为2~12位</b>');
            return;
        }
        $.ajaxSetup({
            headers:{
                'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
            }
        });

        var id={{$data->id}};
        //唯一性验证

        $.post('/url/checkName',{name:name,id:id},function(mag){
            if(msg>0){
                obj.after('<b style="color:red">学生姓名已存在</b>');
            }
        });
        
    });

    //验证年龄
    $('input[name="age"]').blur(function(){
        var age=$(this).val();
        $(this).next().remove();

        //数字
        var reg=/^\d{1,3}$/;
        if (!reg.test(age)) {
            $(this).after('<b style="color:red">请输入正确的年龄</b>');
            
        }
    });

    //点击提交按钮触发的验证
    $('input[type="button"]').click(function(){
        var flag=false;
        var name=$('input[name="name"]').val();
        $('input[name="name"]').next().remove();

        //中文 字母 .
        var reg=/^[\u4e00-\u9fa5A-Za-z.]{2,12}$/;
        if (!reg.test(name)) {
            $('input[name="name"]').after('<b style="color:red">学生姓名必须由中文字母.组成,长度为2~12位</b>');
            return;
        }
        $.ajaxSetup({
            headers:{
                'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
            }
        });

        //唯一性验证
        var id={{$data->id}};
        $.ajax({
            method:"post",
            url:"/url/checkName",
            async:false,
            data:{name:name,id:id},
        }).done(function(msg){
            if (msg>0) {
                flag=true;
            }
        });
        if (flag) {
            $('input[name="name"]').after('<b style="color:red">学生姓名已存在</b>');
            return;
        }

        var age=$('input[name="age"]').val();
        $('input[name="age"]').next().remove();

        //数字
        var reg=/^\d{1,3}$/;
        if (!reg.test(age)) {
            $('input[name="age"]').after('<b style="color:red">请输入正确的年龄</b>');
            return;
        }
        $('form').submit(); 
    });
</script>