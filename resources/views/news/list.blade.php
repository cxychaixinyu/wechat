<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>新闻列表</title>
</head>
<body>
	<table border="1" align="center" width="500">
		<b>欢迎{{$session['name']}}</b>
		<th>新闻标题</th>
		<th>点赞数</th>
		<th>点赞</th>
		<th>操作</th>
        @foreach($data as $v)
        <tr>
	        <td align="center" >
	        	<a href="{{url('news/show/'.$v['news_id'])}}">{{$v['news_title']}}</a>
	        </td>
	        <td align="center" class="num{{ $v['news_id'] }}" >
	        	{{$v['dian']}}
	        </td>
	        <td>
	        	<a href="javascript:void(0) " class="dian" data-id="{{ $v['news_id'] }}">{{ $v['flag'] }}</a>
	        </td>
	        <td align="center" >
	        	<a href="javascript:viod(0)">修改</a>|<a href="">删除</a>
	        </td>
    	</tr>
        @endforeach
	</table>
</body>
</html>
<script type="text/javascript" src="{{asset('js/jquery.min.js')}}"></script>

<script type="text/javascript">
	$('.dian').click(function(){
		obj = $(this);
		id  = obj.data('id')
		flag = obj.html()

		$.ajax({
			url:'/news/red',
			data:{'id': id, 'flag': flag},
			success:function(msg) {
				$('.num' + id).html(msg)
				if (flag == '点赞') {
					obj.html('取消点赞')
				} else {
					obj.html('点赞')
				}				
			}
		});
	});
</script>