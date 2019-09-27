@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
<form action="{{url('admin/goods/doadd')}}" method="post" enctype="multipart/form-data">
    @csrf
    商品名称:<input type="text" name="goods_name">@php echo $errors->first('goods_name'); @endphp<br/>
    商品图片: <input type="file" name="goods_pic" id=""><br/>
    商品价格: <input type="text" name="goods_price" id="">@php echo $errors->first('goods_price'); @endphp<br/>
    库存: <input type="text" name="goods_stock" id="">@php echo $errors->first('goods_stock'); @endphp<br/>
    <button>提交</button>
</form>
