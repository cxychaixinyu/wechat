<!DOCTYPE html>
<html>
<head>
	<title>出库</title>
</head>
<body>
	<form action="{{url('exam/doout')}}?id={{$data->id}}" method="post">
		@csrf
		
		货物名称 <input type="text" name="name" value="{{$data->name}}"><br>
		出库数量 <input type="text" name="num" value="{{$data->num}}"><br>
		<input type="submit" value="出库" name="">
	</form>
</body>
</html>