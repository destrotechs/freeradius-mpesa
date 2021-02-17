@extends('layouts.master')
@section('content')
<?php
if(isset($_POST['test'])){
	testConnectivity();
}
function testConnectivity(){
	echo"running";
}
?>
<div class="card">
	<div class="card-header"><h4>Test Customer Connectivity</h4></div>
	<div class="card-body">
		<div class="bg-success text-white res p-4" style="display: none;"></div>
		<form>
			<label>Username</label>
			<input type="text" name="username" id="username" class="form-control">
			<label>Password</label>
			<input type="text" name="password" id="password" class="form-control">
			<label>Radius port</label>
			<input type="text" name="radiusport" id="radiusport" readonly class="form-control" value="1812">
			<label>Radius server Address</label>
			<input type="text" name="server" id="server" class="form-control" value="127.0.0.1">
			<label>Nas Port</label>
			<input type="text" name="nasport" id="nasport" class="form-control" value="0">
			<label>Nas Secret</label>
			<input type="text" name="secret" id="nassecret" class="form-control" value="testing123">
			<hr>
			<button type="button" class="btn btn-success btn-md test">Perform test</button>
			{{ csrf_field() }}
		</form>
	</div>
</div>
@endsection
@section('scripts')
<script type="text/javascript">
	$(document).ready(function(){
		$(".test").click(function(){
			var username=$("#username").val();
			var _token=$('input[name="_token"]').val();
			var password=$("#password").val();
			var server=$("#server").val();
			var nasport=$("#nasport").val();
			var nassecret=$("#nassecret").val();
			if(username!="" && password!=""){
				$.ajax({
					method:"post",
					url:"{{ route('testconn') }}",
					data:{_token:_token,username:username,password:password,server:server,nasport:nasport,nassecret:nassecret},
					success:function(result){
						$(".res").html(result).show();
					}
				});
			}else{
				alert("Enter a valid username and password");
			}
		})
	})
</script>
@endsection