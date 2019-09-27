@extends('layout.common')

@section('title','商品修改')

@section('body')
	<!-- login -->
	<div class="pages section">
		<div class="container">
			<div class="pages-head">
				<h3>商品修改</h3>
			</div>
			<div class="login">
				<div class="row">
					<form class="col s12" method="post" action="{{url('admin/do_update')}}" enctype="multipart/form-data">
						@csrf
						<div class="input-field">
							<input type="text" name="goods_name" value="{{$data['goods_name']}}" class="validate" placeholder="商品名称" required>
						</div>
						图片：<input type="file" name="goods_pic"><br/>
							  <img src="{{$data['goods_pic']}}" width="100">
						<div class="input-field">
							<input type="text" name="goods_price" value="{{$data['goods_price']}}" class="validate" placeholder="商品价格" required>
						</div>
						<div class="input-field">
							<input type="text" name="goods_stock" value="{{$data['goods_stock']}}" class="validate" placeholder="商品库存" required>
						</div>
						<input type="hidden" name="goods_id" value="{{$data['goods_id']}}">
						<button class="btn button-default">修改</button>
					</form>
				</div>
			</div>
		</div>
	</div>
	<!-- end login -->
@endsection