<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Document</title>
</head>
<body>
    <center>
        <form action="{{url('admin/doadd')}}" method="post">
            @csrf
            <h1>添加竞猜球队</h1><br/>
            <input type="text" name="" id="">&nbsp;&nbsp;&nbsp;&nbsp;vs&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" name="" id=""><br/>
            结束竞猜时间 <input type="text" name="" id=""><br/>
            <input type="submit" value="添加" name="" id="">
        </form>
    </center>
</body>
</html>