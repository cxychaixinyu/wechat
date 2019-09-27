<form action="{{url('stu/doupdate')}}" method="post">
    @csrf
    姓名: <input type="text" name="name" value="{{$data->name}}" id=""><br/>
    年龄: <input type="text" name="age" value="{{$data->age}}"><br/>
    性别: <input type="radio" name="sex" value="0" @if($data->sex == 0) checked @endif >男 <input type="radio" name="sex" value="1" @if($data->sex == 1) checked @endif>女<br/>
    <input type="submit" value="修改">
</form>