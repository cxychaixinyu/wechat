<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>车票信息</title>
</head>
<body>
    <form action="{{url('/admin/lists')}}" method="get">			
        <input type="text" name="search" value="{{$search}}">
        <input type="submit" name="" value="搜索">
    </form>
    <table>
        <tr>
            <td>车次</td>
            <td>出发站</td>
            <td>到达站</td>
            <td>出发时间</td>
            <td>到达时间</td>
            <td>剩余票数</td>
            <td>操作</td>
        </tr>
        @foreach($ticket as $v)
        <tr>
            <td>{{ $v->name }}</td>
            <td>{{ $v->startstation }}</td>
            <td>{{ $v->outstation }}</td>
            <td>{{ $v->starttime }}</td>
            <td>{{ $v->outtime }}</td>
            <td>{{ $v->num }}</td>
            <td><a href="{{'/admin/buy'}}">购买</a></td>
        </tr>
        @endforeach
    </table>
    {{ $ticket->links() }}
</body>
</html>