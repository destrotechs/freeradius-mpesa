@extends('layouts.master')
@section('pagetitle')
Edit Customer
@endsection
@section('content')
<form method="post" action="{{ route('fetchcustomertoedit') }}">
	<div class="input-group mb-3">
	  <input type="text" name="username" class="form-control username" placeholder="Customer's username" aria-label="Customer's username" aria-describedby="button-addon2">
	  <div class="input-group-append">
	    <button class="btn btn-outline-primary" type="submit" id="fetch">Fetch</button>
	  </div>
	</div>
	<div id="users"></div>
	{{csrf_field()}}
</form>
<div class="dropdown-divider"></div>
@if (session('error'))
		    <div class="alert alert-danger">
		        {{ session('error') }}
		    </div>
		@endif
@endsection
@section('scripts')
<script type="text/javascript">
	$(document).ready(function(){
		
		$(".fetch").click(function(){
			var _token=$("input[name='_token']").val();
			var username=$(".username").val();
			$.ajax({
				method:"POST",
				url:"{{ route('fetchcustomertoedit') }}",
				data:{_token:_token,username:username},
				success:function(data){
					alert(data);
				}
			})
		})
		
	})
</script>
@endsection