@extends('layout.common')

@section('title','用户登陆')

@section('body')
	<!-- login -->
	<div class="pages section">
		<div class="container">
			<div class="pages-head">
				<h3>登陆</h3>
			</div>
			<div class="login">
				<div class="row">
					<form class="col s12" id="form">
						<div class="input-field">
							<input type="text" name="user_name" class="validate" placeholder="用户名" required>
						</div>
						<div class="input-field">
							<input type="password" name="user_pwd" class="validate" placeholder="密码" required>
						</div>
						<a href=""><h6>忘记密码 ?</h6></a>
						<a href="{{url('admin/do_login')}}" class="btn button-default formDemo">登陆</a>
						<a href="{{url('admin/register')}}" class="btn button-default">去注册</a>
					</form>
				</div>
			</div>
		</div>
	</div>
	<!-- end login -->
@endsection

@section('script')
<script>
	$(function(){
		$('.formDemo').click(function(){
			var data = $('#form').serialize();

			$.post(
				"{url('do_login')}",
				data,
				function(res){
					console.log(res);
				}
			);
			return false;
		});
	});
</script>
@endsection

