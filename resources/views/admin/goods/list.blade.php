<link rel="stylesheet" href="../css/bootstrap.min.css">
<form action="{{url('admin/goods/list')}}" method="post">
    商品名称:<input type="text" name="goods_name" value="{{$goods_name}}">
    商品价格: <input type="text" name="goods_price" value="{{$goods_price}}">
    <input type="submit" value="搜索">
</form>
<table>
    <tr>
        <td>商品名称</td>
        <td>商品图片</td>
        <td>商品价格</td>
        <td>商品库存</td>
        <td>操作</td>
    </tr>
    @foreach($data as $v)
    <tr>
        <td>{{$v->goods_name}}</td>
        <td> <img src="{{env('UPLOAD_URL')}}{{$v->goods_pic}}" height="100"> </td>
        <td>{{$v->goods_price}}</td>
        <td>{{$v->goods_stock}}</td>
        <td><a href="{{url('admin/goods/update')}}?id={{$v->id}}">修改</a> | <a href="{{url('admin/goods/delete')}}?id={{$v->id}}">删除</a></td>
    </tr>
    @endforeach
</table>
{{ $data->links() }}