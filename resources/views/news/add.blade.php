<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>新闻添加</title>
</head>
<body>
    <center>
        <form action="{{url('news/doadd')}}" method="post">
            @csrf
            <table>
                标题: <input type="text" name="name"><br>
                作者: <input type="text" name="autour"><br>
                内容: <textarea name="new" cols="30" rows="10"></textarea><br>
                <input type="submit" value="提交">
            </table>
        </form>
    </center>
</body>
</html>