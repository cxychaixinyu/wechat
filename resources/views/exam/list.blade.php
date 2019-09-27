<!DOCTYPE html>
<html>
<head>
	<title>货物列表</title>
</head>
<body>
	<a href="{{url('exam/add')}}">入库</a>
	<a href="{{url('exam/jilu')}}">记录</a>
	<table border="1" align="center">
		<tr>
			<td>货物id</td>
			<td>货物名称</td>
			<td>货物图片</td>
			<td>当前库存</td>
			<td>入库时间</td>
			<td>操作</td>
		</tr>
		@foreach($data as $v)
		<tr>
			<td>{{$v->id}}</td>
			<td>{{$v->name}}</td>
			<td> <img src="{{env('UPLOAD_URL')}}{{$v->img}}" height="100"> </td>
			<td>{{$v->num}}</td>
			<td>{{date('Y-m-d H:i:s',$v->time)}}</td>
			<td><a href="{{url('exam/out')}}?id={{$v->id}}">出库</a></td>
		</tr>
		@endforeach	
	</table>
</body>
</html>