@extends('layouts.master')
@section('pagetitle')
Customer Accounting rec
@endsection
@section('content')
<form>
	<div class="input-group mb-3">
	  <input type="text" name="username" class="form-control username" placeholder="Customer's username" aria-label="Customer's username" aria-describedby="button-addon2">
	  <div class="input-group-append">
	    <button class="btn btn-outline-danger" type="button" id="fetch">Delete</button>
	  </div>
	</div>
	<div id="users"></div>
	{{csrf_field()}}
</form>
<div class="dropdown-divider"></div>
<div class="message"></div>
@endsection
@section('scripts')
<script type="text/javascript">
	$(document).ready(function(){
		
		$("#fetch").click(function(){
			var _token=$("input[name='_token']").val();
			var username=$(".username").val();
			if(username!=""){
				if(confirm("are you sure you want to delete "+username+" accounting records?")){
					$.ajax({
						method:"POST",
						url:"{{ route('deletecustomeracctrec') }}",
						data:{_token:_token,username:username},
						success:function(data){
							if(data=='success'){
								$(".message").html("Accounting records for "+username+" removed successfully").removeClass("alert alert-danger").addClass("alert alert-success");
							}else{
								$(".message").html("Accounting records for "+username+" could not be found").removeClass("alert alert-success").addClass("alert alert-danger");
							}
						}
					})
				}
			}
		})
		
	})
</script>
@endsection