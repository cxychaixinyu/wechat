@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
<form action="{{url('stu/doadd')}}" method="post" enctype="multipart/form-data">
    @csrf
    姓名:<input type="text" name="name">@php echo $errors->first('name'); @endphp<br/>
    头像: <input type="file" name="headimg" id=""><br/>
    年龄: <input type="text" name="age" id="">@php echo $errors->first('age'); @endphp<br/>
    性别: <input type="radio" name="sex" value="0" id="">男 <input type="radio" name="sex" value="1">女<br/>
    <button>提交</button>
</form>