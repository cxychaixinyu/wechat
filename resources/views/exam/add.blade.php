<!DOCTYPE html>
<html>
<head>
	<title>货物入库</title>
</head>
<body>
	<form action="{{url('exam/doadd')}}" method="post" enctype="multipart/form-data">
		@csrf
		货物名称 <input type="text" name="name"><br>
		货物图片 <input type="file" name="img"><br>
		货物数量 <input type="text" name="num"><br>
		<input type="submit" value="入库">
	</form>
</body>
</html>