<!DOCTYPE html>
<html>
<head>
	<title>记录</title>
</head>
<body>
	<table border="1" align="center">
		<tr>
			<td>用户ID</td>
			<td>货物ID</td>
			<td>操作时间</td>
			<td>操作类型</td>
		</tr>
		@foreach($data as $v)
		<tr>
			<td> {{$v->u_id}} </td>
			<td> {{$v->hid}} </td>
			<td> {{$v->time}} </td>
			<td> @if ($v->status==1) 出库 @else 出库 @endif</td>
		</tr>
		@endforeach

	</table>
</body>
</html>