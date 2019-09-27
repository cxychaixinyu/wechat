@extends('layout.common')

@section('title','商品添加')

@section('body')
	<!-- login -->
	<div class="pages section">
		<div class="container">
			<div class="pages-head">
				<h3>商品添加</h3>
			</div>
			<div class="login">
				<div class="row">
					<form class="col s12" method="post" action="{{url('admin/do_add_goods')}}" enctype="multipart/form-data">
						@csrf
						<div class="input-field">
							<input type="text" name="goods_name" class="validate" placeholder="商品名称" required>
						</div>
						图片：<input type="file" name="goods_pic"><br/>
						<div class="input-field">
							<input type="text" name="goods_price" class="validate" placeholder="商品价格" required>
						</div>
						<div class="input-field">
							<input type="text" name="goods_stock" class="validate" placeholder="商品库存" required>
						</div>
						<!-- <input type="submit" class="btn button-default formDemo"> -->
						<button class="btn button-default">添加</button>
					</form>
				</div>
			</div>
		</div>
	</div>
	<!-- end login -->
@endsection

<!-- @section('script')
<script>
	$(function(){
		$('.formDemo').click(function(){
			// var data = $('#form').serialize();
			 var pic = $('#img').attr('name');
			console.log(pic);
			return false;
		});
	});
</script>
@endsection -->