@extends('layouts.master')
@section('content')
<h5>Quick Customer</h5>
<hr>
@if (session('success'))
			    <div class="alert alert-success">
			        {{ session('success') }}
			    </div>
			@endif
			@if (session('error'))
			    <div class="alert alert-danger">
			        {{ session('error') }}
			    </div>
			@endif
<form method="post" action="{{ route('autocustomer.post') }}">
	<div class="form-group">
    <button type="button" class="btn btn-danger btn-sm float-right" id="reset">reset credentials</button>
  </div>
  <div class="form-group">
    <label for="exampleFormControlSelect1">Select Plan For the user</label>
    <select class="form-control" name="plan" id="exampleFormControlSelect1">
      <option value="">Select Plan to add customer to</option>
      @forelse($plans as $p)
      <option value="{{ $p->planname }}">{{ $p->plantitle }}</option>
      @empty
      <option value="">No Plan available</option>
      @endforelse
    </select>
  </div>
  <div class="form-group">
    <label for="exampleInputPassword1">Phone</label>
    <input type="text" name="phone" placeholder="e.g 07xxxxxxxx" class="form-control" id="exampleInputPassword1">
  </div>
  <div class="form-group">
    <label for="exampleInputPassword1">Username</label>
    <input type="text" name="username" readonly="readonly" class="form-control username" id="exampleInputPassword1">
  </div>
  <div class="form-group">
    <label for="exampleInputPassword1">Password</label>
    <input type="password" name="password" readonly="readonly" class="form-control password" id="exampleInputPassword1">
  </div>
  {{ csrf_field() }}
  <button type="submit" class="btn btn-primary">Create Customer</button>
</form>
@endsection
@section('scripts')
<script type="text/javascript">
	$(document).ready(function(){
		$("#reset").click(function(){
			var username=generateUsername();
			var password=generatePassword();
			$(".username").val(username);
			$(".password").val(password);
		})
		var username=generateUsername();
		var password=generatePassword();
		$(".username").val(username);
		$(".password").val(password);
		function generateUsername(){
			var text = "";
			var possible = "ABCDEFGHJKLMNPQRSTUVWXYZabcdefghjklmnpqrstuvwxyz23456789";

		  	for (var i = 0; i < 6; i++)
		    text += possible.charAt(Math.floor(Math.random() * possible.length));

		  	return text;
		}
		function generatePassword(){
			var text = "";
			var possible = "ABCDEFGHJKLMNPQRSTUVWXYZ23456789";

		  	for (var i = 0; i < 5; i++)
		    text += possible.charAt(Math.floor(Math.random() * possible.length));

		  	return text;
		}
	})
</script>
@endsection