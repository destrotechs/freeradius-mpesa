@extends('layouts.master')
@section('pagetitle')
New Message
@endsection
@section('content')
<div class="p-3 bg-light">
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
	<form class="form-floating" action="{{ route('sendmessage') }}" method="POST">
		{{ csrf_field() }}
		<div class="form-check">
		  <input class="form-check-input allcustomers" name="allcustomers" type="checkbox" value="allcustomers" id="flexCheckChecked">
		  <label class="form-check-label" for="flexCheckChecked">
		   To All customers
		  </label>
		</div>
		<hr>
		<div class="mb-3 rec">
			 
		  <label for="exampleFormControlInput1" class="form-label">Add Recipient</label>
		  <input type="text" name="recipient" class="form-control" id="exampleFormControlInput1" placeholder="Recipient">
		</div>
		<div class="mb-3">
		  <label for="exampleFormControlTextarea1" class="form-label">Message</label>
		  <textarea class="form-control" id="exampleFormControlTextarea1" rows="4" name="message"></textarea>
		  <hr>
		  <button class="btn btn-md btn-outline-primary sendtoone" type="submit">Send </button> <button class="btn btn-md btn-outline-primary allbtn" type="submit" style="display: none;">Send to all customers</button>
		</div>
	</form>
</div>
@endsection
@section('scripts')
<script type="text/javascript">
	$(document).ready(function(){
		$(".allcustomers").click(function(){
			if($(this).prop('checked')==true){
				$(".rec").hide();
				$(".sendtoone").hide();
				$(".allbtn").show();
			}else{
				$(".rec").show();
				$(".sendtoone").show();
				$(".allbtn").hide();
			}
		})
	})
</script>
@endsection