@extends('layout.common')

@section('title','用户注册')

@section('body')
<!-- register -->
	<div class="pages section">
		<div class="container">
			<div class="pages-head">
				<h3>注册</h3>
			</div>
			<div class="register">
				<div class="row">
					<form class="col s12" id="form">
						@csrf
						<div class="input-field">
							<input type="text" name="user_name" class="validate" placeholder="NAME" required>
						</div>
						<div class="input-field">
							<input type="email" name="user_email" placeholder="EMAIL" class="validate" required>
						</div>
						<div class="input-field">
							<input type="password" name="user_pwd" placeholder="PASSWORD" class="validate" required>
						</div>
						<div class="btn button-default formDemo">注册</div>
					</form>
				</div>
			</div>
		</div>
	</div>
<!-- end register -->
@endsection

@section('script')
<script>
	layui.use('layer',function(){
		var layer = layui.layer;
	});
	$(function(){
		$('.formDemo').click(function(){
			var data = $('#form').serialize();
			
			$.post(
				"{{url('admin/do_register')}}",
				data,
				function(res){
					layer.msg(res.font,{icon:res.code,time:2000},function(){
						if (res.code==1) {
							location.href="{{url('admin/login')}}";
						};
					});
				},
				'json'
			);
			return false;
		});
	});
</script>
@endsection