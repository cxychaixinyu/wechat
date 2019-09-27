<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>学生添加</title>
</head>
<body>   
    <form action="{{url('students/doupdate')}}?id={{$data->id}}" method="post">
        @csrf
        地址: <select name="adress" id="">
                <option value="0" @if($data->adress == 0) selected @endif >房山</option>
                <option value="1" @if($data->adress == 1) selected @endif >昌平</option>
              </select><br>
        <input type="submit" value="提交">
    </form>
</body>
</html>