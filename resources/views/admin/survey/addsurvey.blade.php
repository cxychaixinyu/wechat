<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>调研项目添加</title>
</head>
<body>
    <center>
        <form action="{{url('admin/doadd')}}" method="post">
            @csrf
            调研项目: <input type="text" name="name" id=""><br/>
            <input type="submit" value="添加项目">
        </form>
    </center>
</body>
</html>