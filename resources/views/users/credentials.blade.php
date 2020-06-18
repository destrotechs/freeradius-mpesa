@extends('layouts.default')
@section('content')
<nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item" aria-current="page">Get Credentials</li>
  </ol>
</nav>
	<div class="card card-body">
		<div class="err"></div>
		<form id="credform">
			<label>Phone Number</label>
			<input type="text" name="phone" class="form-control" placeholder="e.g 0712345678" value="@if(isset(Auth::user()->phone ))0{{ Auth::user()->phone }}@else {{ 'phone' }}@endif">
			<small>This is the MPesa registered number to be charged</small><br>
			<label>Bundle Plan</label>
			<div class="input-group mb-3">
			  <select class="custom-select" name="plan" id="plan">
			    <option value="">Choose bundle plan...</option>
			    <option value="50mbs">50MBs @ Kes 10/-</option>
			    <option value="100mbs">100MBs @ Kes 20/-</option>
			    <option value="500mbs">500MBs @ Kes 100/-</option>
			  </select>
			</div>
			<label>Amount</label>
			<input type="text" name="amount" readonly="readonly" class="form-control amount" value="0">
			<hr>
			<button class="btn btn-success btn-md" type="submit">Send Credentials</button><small class="d-block text-right" id="timer"></small>
			{{ csrf_field() }}
		</form>
	</div>

@endsection
@section('scripts')
<script type="text/javascript">
	$(document).ready(function(){
		$("#credform").submit(function(e){			

			var phone=$("input[name='phone']").val();
			var plan=$("#plan").val();
			var plantext=$("#plan option:selected").text();
			var _token=$("input[name='_token']").val();
			var amount=$(".amount").val();
			
			if(phone!='' && plan!=''){
				if (confirm("Are you sure you want to purchase "+plantext)) {
					if(confirm("A prompt will be sent to your phone,input your M-Pesa pin to proceed")){
					$(".btn-success").empty().html('processing, please wait...').addClass('btn-danger');
					$("#timer").html( 0 + ":" + 45);
					startTimer();
					var req=$.ajax({
						method:'POST',
						url:"{{ route('user.post.credentials') }}",
						data:{phone:phone,plan:plan,amount:amount,_token:_token},
					});
					req.done(function(data){
						if(data=='error'){
							$("#timer").empty().removeClass('d-block').fadeOut();
						$(".btn-danger").empty().html('Failed!');
						$(".err").html("Your transaction could not be completed, try again").addClass("alert alert-danger p-3");
						}else{
							$("#timer").empty().removeClass('d-block').fadeOut();;
							$(".btn-danger").empty().html('completed').removeClass('btn-danger').addClass("btn-success");
							$(".err").html(data).addClass("bg-success text-white p-3");
						}
					})
				}
				}
				
			}else{
				$(".err").html("Enter a valid phone number and select a bundle plan").addClass("alert alert-danger");
			}
			e.preventDefault();
		})
		$("#plan").change(function(){
			var plan=$(this).val();
			if (plan=='50mb') {
				$(".amount").val(10);
			}else if (plan=='100mb') {
				$(".amount").val(20);
			}else if (plan=='500mb') {
				$(".amount").val(100);
			}
		})
		function startTimer() {
		  var presentTime = document.getElementById('timer').innerHTML;
		  var timeArray = presentTime.split(/[:]+/);
		  var m = timeArray[0];
		  var s = checkSecond((timeArray[1] - 1));
		  if(s==59){m=m-1}
		  //if(m<0){alert('timer completed')}
		  
		  document.getElementById('timer').innerHTML =
		    m + ":" + s;
		  console.log(m)
		  setTimeout(startTimer, 1000);
		}

		function checkSecond(sec) {
		  if (sec < 10 && sec >= 0) {sec = "0" + sec}; // add zero in front of numbers < 10
		  if (sec < 0) {sec = "59"};
		  return sec;
		}
	})
</script>
@endsection