<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Document</title>
</head>
<body>
    <center>
        <h1>竞猜列表</h1>
        <table>            
            @foreach($guess as $v)
                {{$v->name1}} vs {{$v->name2}}
                @if({{$v->time}} > time())
                    <a href="{{url('admin/cai')}}">竞猜</a>
                @else
                    <a href="{{url('admin/result')}}">查看结果</a>
                @endif
            @endforeach
        </table>
    </center>
    <script src="{{asset('js/jquery.min.js')}}"></script>
    <script>
        $(function(){
            
        });
    </script>
</body>
</html>