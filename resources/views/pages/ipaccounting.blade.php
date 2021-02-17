@extends('layouts.master')
@section('pagetitle')
Search IP Accounting Details
@endsection
@section('content')
<form>
	<div class="input-group mb-3">
	  <input type="text" name="ipaddress" class="form-control ip" placeholder="Ip Address" aria-label="Customer's username" aria-describedby="button-addon2">
	  <div class="input-group-append">
	    <button class="btn btn-outline-primary" type="button" id="fetch">Fetch</button>
	  </div>
	</div>
	{{csrf_field()}}
</form>
<div class="dropdown-divider"></div>
@if (session('error'))
		    <div class="alert alert-danger">
		        {{ session('error') }}
		    </div>
		@endif
		<div class="cnt">
			
		</div>
@endsection
@section('scripts')
<script type="text/javascript">
	$(document).ready(function(){
		
		$("#fetch").click(function(){
			var _token=$("input[name='_token']").val();
			var ip=$(".ip").val();
			$.ajax({
				method:"POST",
				url:"{{ route('fetchipaccounting') }}",
				data:{_token:_token,ip:ip},
				success:function(data){
					$(".cnt").html(data);
				}
			})
		})
		
	})
</script>
@endsection