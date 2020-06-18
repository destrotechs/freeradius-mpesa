@extends('layouts.default')
@section('content')
<h4>Bundle Balance</h4><br>
<div class="card p-3">
<div class="card-body">
	<form id="checkbalance">
		<div id="err"></div>
		
		<label>Username</label>
		<input type="text" class="form-control" name="username" value="@if(isset(Auth::user()->username )){{ Auth::user()->username }}@else {{ 'username' }}@endif" id="username">
		<br>
		<div class="form-group">
		    <label for="exampleFormControlSelect1">Select Bundle</label>
			  <select class="custom-select" name="plan" id="plan">
			    <option value="">Choose bundle plan...</option>
			    <option value="50mbs">50MBs @ Kes 10/-</option>
			    <option value="100mbs">100MBs @ Kes 20/-</option>
			    <option value="500mbs">500MBs @ Kes 100/-</option>
			  </select>
		</div>
		<br>
		<button class="btn btn-success btn-md" type="submit">Check</button>
		{{ csrf_field() }}
	</form>
	<br>
	
</div>
</div>
<table class="table table-bordered table-striped">
		<thead>
			<tr>
				<th>Bundle Bought</th>
				<th>Bundle used</th>
				<th>Balance</th>
			</tr>
		</thead>
		<tbody class="res"></tbody>
	</table>
@endsection
@section('scripts')
<script type="text/javascript">
	$(document).ready(function(){
		$("#checkbalance").submit(function(e){
			var username=$("#username").val();
			var plan=$("#plan").val();
			
			var _token=$("input[name='_token']").val();
			if(username!="" && plan!=""){
				var req = $.ajax({
					method:'POST',
					url:"{{ route('user.check.balance') }}",
					data:{username:username,plan:plan,_token:_token},
				})

				req.done(function(data){
					if (data=='error') {
						$("#err").html("You have not purchased the selected bundle plan").addClass('alert alert-danger');
					}else{
						$(".res").html(data);
					}
				})
			}else{
				$("#err").html("add a valid username and select bundle plan to view balance").addClass('alert alert-danger');
			}
			e.preventDefault();
		})
	})
</script>
@endsection