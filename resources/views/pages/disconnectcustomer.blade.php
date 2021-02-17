@extends('layouts.master')
@section('content')
<div class="card">
	<div class="card-header"><h4>Disconnect Customer</h4></div>
	<div class="err"></div>
	<div class="card-body">
		<div class="bg-success text-white res p-4" style="display: none;"></div>
		<form>
			<label>Username</label>
			<input type="text" name="username" id="username" class="form-control username">
			<div id="users"></div>
			<div class="form-group">
			<label>Disconnect Type</label>
		    <select class="form-control type" id="exampleFormControlSelect1">
		      <option value="">choose disconnect type ...</option>
		      <option value="coa">COA(Change Of Authorization)</option>
		    </select>
		  </div>
			<div class="form-group">
			<label>Nas</label>
		    <select class="form-control nas" id="exampleFormControlSelect1">
		      <option value="">choose nas ...</option>
		      @forelse($nas as $n)
		      <option value="{{ $n->nasname }}">{{ $n->nasname }}({{ $n->shortname }})</option>
		      @empty
		      <option value="">No nas available</option>
		      @endforelse
		    </select>
		  </div>
		  <div class="form-group">
			<label>Port</label>
		    <select class="form-control port" id="exampleFormControlSelect1">
		      <option value="">choose port ...</option>
		      <option value="1700">1700</option>
		      <option value="3400">3799</option>
		    </select>
		  </div>
			<hr>
			<button type="button" class="btn btn-success btn-md disconn">Disconnect</button>
			{{ csrf_field() }}
		</form>
	</div>
</div>
@endsection
@section('scripts')
<script type="text/javascript">
	$().ready(function(){
		$(".disconn").click(function(){
			var username=$(".username").val();
			var port=$(".port").val();
			var nas=$(".nas").val();
			var type=$(".type").val();
			if(nas!="" && port!="" && nas!="" && type!=""){
				setTimeout(function(){
				$(".err").html("No response from the server, try again").addClass("alert alert-danger");
				},4000);
			}else{
				$(".err").html("All fields below are required").addClass("alert alert-danger");
			}
			
		})
	})
</script>
@endsection