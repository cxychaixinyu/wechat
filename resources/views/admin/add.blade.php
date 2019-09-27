<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>车票添加</title>
</head>
<body>
    <center>
        <form action="{{url('admin/doadd')}}" method="post">
            @csrf
            车次 <input type="text" name="name"><br/>
            出发站 <input type="text" name="startstation"><br/>
            到达站 <input type="text" name="outstation"><br/>
            出发时间 <input type="text" name="starttime"><br/>
            到达时间 <input type="text" name="outtime"><br/>
            剩余票数 <input type="text" name="num"><br/>
            <input type="submit" value="添加"><br/>
        </form>
    </center>
</body>
</html>