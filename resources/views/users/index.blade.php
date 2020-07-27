@extends('layouts.default')
@section('content')
<div class="card card-body">
	<center><h4 class="card-title">HEWANET INTERNET</h4></center>
	<hr>
	@if (session('message'))
    <div class="alert alert-success">
        {{ session('message') }}
    </div>
	@endif
	@if (session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif

<div class="row">
	@forelse($plans as $key=> $p)
	<div class="col-md-3">
		<div class="card-deck mb-3 text-center">
			    <div class="card mb-4 shadow-sm">
			      <div class="card-header">
			        <h4 class="my-0 font-weight-normal">{{ $p->plantitle }}</h4>
			      </div>
			      <div class="card-body">
			        <h1 class="card-title pricing-card-title">{{ $p->plantitle }}<small class="text-muted">/ Kes {{ $p->cost }}</small></h1>
			        <ul class="list-unstyled mt-3 mb-4">
			          <li>{{ $p->desc }}</li>
			          <li>
			          	<input type="hidden" name="plan" value="{{ $p->planname }}">
			          	<input type="hidden" name="amount" value="{{ $p->cost }}">
			          </li>
			        </ul>
			        <a href="{{ route('user.buybundleplan',['plan'=>$p->id]) }}" class="btn btn-primary btn-lg">Purchase</a>
			        <small></small>
			      </div>
			    </div>
			</div>
	</div>
	@empty
<div class="alert alert-danger">No plans available yet</div>
	@endforelse
	<div class="col-md-3 shadow-sm">
		<h4>&star;&nbsp;Tips</h4><hr>
		<marquee behavior="scroll" direction="up" scrollamount="3">
			<ol>
			<li>Daily plan gives a user unlimited access to internet for 24 hours at a downspeed of 1 mb/s.</li>
			<li>Weekly plan gives a user unlimited access to internet for 7 days at a downspeed of 1 mb/s.</li>
			<li>Monthly plan gives a user unlimited access to internet for 30 days at a downspeed of 1 mb/s.</li>
		</ol></marquee>
	</div>
</div>
<!--end first row-->
	<div class="row">

		<div class="col-md-4">
			<form method="post" action="{{ route('user.post.credentials') }}">
			<div class="card-deck mb-3 text-center">
			    <div class="card mb-4 shadow-sm">
			      <div class="card-header">
			        <h4 class="my-0 font-weight-normal">50MBs</h4>
			      </div>
			      <div class="card-body">
			        <h1 class="card-title pricing-card-title">50 MBs<small class="text-muted">/ Kes 10</small></h1>
			        <ul class="list-unstyled mt-3 mb-4">
			          <li>No expiry Till Depletion</li>
			          <li>
			          	<input type="hidden" name="plan" value="50mbs">
			          	<input type="hidden" name="amount" value="10">
			          </li>
			        </ul>
			        <input type="text" required="required" name="phone" class="form-control" placeholder="enter phone number" style="display: none;"><hr>

			        {{-- <button type="button" class="btn btn-lg btn-block btn-outline-primary purchase">Purchase</button> --}}
			        <a href="{{ route('user.buybundleplan',['plan'=>'50mbs']) }}" class="btn btn-primary btn-lg">Purchase</a>
			        <small></small>
			      </div>
			    </div>
			</div>
			{{ csrf_field() }}
		</form>
		</div>
		<div class="col-md-4">
			<form method="post" action="{{ route('user.post.credentials') }}">
			<div class="card-deck mb-3 text-center">
			    <div class="card mb-4 shadow-sm">
			      <div class="card-header bg-info">
			        <h4 class="my-0 font-weight-normal text-white">100MBs</h4>
			      </div>
			      <div class="card-body">
			        <h1 class="card-title pricing-card-title">100 MBs<small class="text-muted">/ Kes 20</small></h1>
			        <ul class="list-unstyled mt-3 mb-4">
			          <li>No expiry Till Depletion</li>
			          <li>
			          	<input type="hidden" name="plan" value="100mbs">
			          	<input type="hidden" name="amount" value="20">
			          </li>
			        </ul>
			        <input type="text" required="required" name="phone" class="form-control" placeholder="enter phone number" style="display: none;"><hr>

			        <button type="button" class="btn btn-lg btn-block btn-outline-primary purchase">Purchase</button><small></small>
			      </div>
			    </div>
			</div>
			{{ csrf_field() }}
		</form>
		</div>
		<div class="col-md-4">
			<form method="post" action="{{ route('user.post.credentials') }}">
			<div class="card-deck mb-3 text-center">
			    <div class="card mb-4 shadow-sm">
			      <div class="card-header bg-primary">
			        <h4 class="my-0 font-weight-normal text-white">500MBs</h4>
			      </div>
			      <div class="card-body">
			        <h1 class="card-title pricing-card-title">500 MBs<small class="text-muted">/ Kes 50</small></h1>
			        <ul class="list-unstyled mt-3 mb-4">
			          <li>No expiry Till Depletion</li>
			          <li>
			          	<input type="hidden" name="plan" value="500mbs">
			          	<input type="hidden" name="amount" value="50">
			          </li>
			        </ul>
			        <input type="text" required="required" name="phone" class="form-control" placeholder="enter phone number" style="display: none;"><hr>

			        <button type="button" class="btn btn-lg btn-block btn-outline-primary purchase">Purchase</button><small></small>
			      </div>
			    </div>
			</div>
			{{ csrf_field() }}
		</form>
		</div>
	</div>
	<hr>
	<span class="text-center font-weight-bold"><a class="btn btn-primary btn-lg" href="{{ route('user.allplans') }}"><i class="fa fa-angle-right"></i> More Bundle Deals...</a></span>
	<hr>
	<div class="row">
		<div class="col-md-6">

			<div class="card card-body">
				<div class="card-title"><center><h4>Internet Access Credentials</h4></center></div><hr>
				<p class="card-text">Here you pay and internet access username and password are sent to you via text message. No need of registering an account. Click the button below</p><hr>
				<center>
					<a href="{{ route('user.credentials') }}" class="btn btn-lg btn-primary">Get Credentials</a>
				</center>
			</div>
		</div>
		<div class="col-md-6">
			<div class="card card-body">
				<div class="card-title"><center><h4>Online portal</h4></center></div><hr>
				<p class="card-text">Here you have an option to set your own username and password. Click the button below and join</p><br><hr>
				<center>
					<a href="{{ route('user.signup') }}" class="btn btn-lg btn-success">join us</a>
				</center>
			</div>
		</div>
	</div>
</div>
@endsection
@section('scripts')
<script type="text/javascript">
	$(document).ready(function(){
		$('.purchase').click(function(){
			$(this).siblings('small').html('Enter the mpesa registered number to pay from').addClass('text-danger');
			$(this).siblings('input').show();
			$(this).html('Buy Now').removeClass('btn-outline-primary').addClass('btn-success');
			$(this).click(function(){
				$(this).attr('type','submit');
				$(this).siblings('input').hide();
				$(this).siblings('small').html('Please wait for transaction to complete in at most 45 seconds').addClass('text-danger');
				$(this).empty().removeClass('btn btn-success').addClass('spinner-border text-info');
			})
		})
	})
</script>
@endsection