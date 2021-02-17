@extends('layouts.master')
@section('content')
<h4>Clean Stale connections</h4><br>
<div class="card">
<div class="card-body">
	<div class="message"></div>
	<form id="cleanconnections">
		<div id="err"></div>
		
		<label>Username</label>
		<input type="text" class="form-control" name="username" value="@if(isset(Auth::user()->username )){{ Auth::user()->username }}@else {{ '' }}@endif" id="username">
		<small>Enter the username here and click clean connection</small>
		<br>
		<button class="btn btn-success btn-md" type="submit">Clean Connections</button>
		{{ csrf_field() }}
	</form>
	<br>
	
</div>
<div class="dropdown-divider"></div>
	<p class="alert alert-info">This page is usefull if user has trouble in signing in to access internet.</p>
</div>

@endsection
@section('scripts')
<script type="text/javascript">
	$(document).ready(function(){
		$("#username").on('keydown',function(){
			$("#err").empty().removeClass('alert alert-danger');
		})
		$("#cleanconnections").submit(function(e){
			var username=$("#username").val();			
			var _token=$("input[name='_token']").val();
			if(username!=" " && username!="NULL"){
				var req = $.ajax({
					method:'POST',
					url:"{{ route('post.cleanstale') }}",
					data:{username:username,_token:_token},
				})

				req.done(function(data){
					if (data=='success') {
						$(".message").html("Successfully Cleaned stale connections for user "+username).removeClass('alert alert-danger').addClass('alert alert-success');
					}else{
						$(".message").html("There are no stale connection for user "+username).removeClass('alert alert-success').addClass('alert alert-danger');
					}
				})
			}else{
				$("#err").html("add a valid username").addClass('alert alert-danger');
			}
			e.preventDefault();
		})
	})
</script>
@endsection