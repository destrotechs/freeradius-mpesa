@extends('layouts.default')
@section('styles')
<style type="text/css">
	.loader,
.loader:before,
.loader:after {
  border-radius: 50%;
  width: 2.5em;
  height: 2.5em;
  -webkit-animation-fill-mode: both;
  animation-fill-mode: both;
  -webkit-animation: load7 1.8s infinite ease-in-out;
  animation: load7 1.8s infinite ease-in-out;
}
.loader {
  color: #ffffff;
  font-size: 10px;
  margin: 80px auto;
  position: relative;
  text-indent: -9999em;
  -webkit-transform: translateZ(0);
  -ms-transform: translateZ(0);
  transform: translateZ(0);
  -webkit-animation-delay: -0.16s;
  animation-delay: -0.16s;
}
.loader:before,
.loader:after {
  content: '';
  position: absolute;
  top: 0;
}
.loader:before {
  left: -3.5em;
  -webkit-animation-delay: -0.32s;
  animation-delay: -0.32s;
}
.loader:after {
  left: 3.5em;
}
@-webkit-keyframes load7 {
  0%,
  80%,
  100% {
    box-shadow: 0 2.5em 0 -1.3em;
  }
  40% {
    box-shadow: 0 2.5em 0 0;
  }
}
@keyframes load7 {
  0%,
  80%,
  100% {
    box-shadow: 0 2.5em 0 -1.3em;
  }
  40% {
    box-shadow: 0 2.5em 0 0;
  }
}

</style>
@endsection
@section('content')
<h3>All Plans</h3>
@if (session('success_message'))
    <div class="alert alert-success">
        {{ session('success_message') }}
    </div>
@endif
<div class="row p-2 bg-light">
	<div class="col-md-3">
		<form method="post" action="{{ route('user.post.credentials') }}">
			<div class="card text-center">
				<div class="card-header"><h4>50MBs</h4></div>
				<div class="card-body">
					<h5 class="text-danger font-weight-bold">Kes 10</h5>
					<p class="card-text text-success">No Expiry</p>
					<input type="hidden" name="amount" value="10">
					<input type="hidden" name="plan" value="50mbs">
					
				</div>
				<div class="card-footer">
					<small class="font-weight-bold"></small>
					<input type="text" name="phone" class="form-control" value="@if(isset(Auth::user()->phone ))0{{ Auth::user()->phone }}@else {{ 'phone' }}@endif" style="display: none;"><br>
					<button type="button" class="btn btn-md btn-primary purchase">Purchase</button>
				</div>
			</div>
			{{ csrf_field() }}
		</form>
	</div>
	<div class="col-md-3">
		<form method="post" action="{{ route('user.post.credentials') }}">
			<div class="card text-center">
				<div class="card-header"><h4>100MBs</h4></div>
				<div class="card-body">
					<h5 class="text-danger font-weight-bold">Kes 20</h5>
					<p class="card-text text-success">No Expiry</p>
					<input type="hidden" name="amount" value="20">
					<input type="hidden" name="plan" value="100mbs">
					
				</div>
				<div class="card-footer">
					<small class="font-weight-bold"></small>
					<input type="text" name="phone" class="form-control" value="@if(isset(Auth::user()->phone ))0{{ Auth::user()->phone }}@else {{ 'phone' }}@endif" style="display: none;"><br>
					<button type="button" class="btn btn-md btn-primary purchase">Purchase</button>
				</div>
			</div>
			{{ csrf_field() }}
		</form>
	</div>
	<div class="col-md-3">
		<form method="post" action="{{ route('user.post.credentials') }}">
			<div class="card text-center">
				<div class="card-header"><h4>250MBs</h4></div>
				<div class="card-body">
					<h5 class="text-danger font-weight-bold">Kes 40</h5>
					<p class="card-text text-success">No Expiry</p>
					<input type="hidden" name="amount" value="40">
					<input type="hidden" name="plan" value="250mbs">
					
				</div>
				<div class="card-footer">
					<small class="font-weight-bold"></small>
					<input type="text" name="phone" class="form-control" value="@if(isset(Auth::user()->phone ))0{{ Auth::user()->phone }}@else {{ 'phone' }}@endif" style="display: none;"><br>
					<button type="button" class="btn btn-md btn-primary purchase">Purchase</button>
				</div>
			</div>
			{{ csrf_field() }}
		</form>
	</div>
	<div class="col-md-3">
		<form method="post" action="{{ route('user.post.credentials') }}">
			<div class="card text-center">
				<div class="card-header"><h4>500MBs</h4></div>
				<div class="card-body">
					<h5 class="text-danger font-weight-bold">Kes 50</h5>
					<p class="card-text text-success">No Expiry</p>
					<input type="hidden" name="amount" value="50">
					<input type="hidden" name="plan" value="500mbs">

				</div>
				<div class="card-footer">
					<small class="font-weight-bold"></small>
					<input type="text" name="phone" class="form-control" value="@if(isset(Auth::user()->phone ))0{{ Auth::user()->phone }}@else {{ 'phone' }}@endif" style="display: none;"><br>
					<button type="button" class="btn btn-md btn-primary purchase">Purchase</button>
				</div>
			</div>
			{{ csrf_field() }}
		</form>
	</div>
</div>
{{-- row 2 --}}
<div class="row p-2">
	<div class="col-md-3">
		<form method="post" action="{{ route('user.post.credentials') }}">
			<div class="card text-center">
				<div class="card-header"><h4>1 GB</h4></div>
				<div class="card-body">
					<h5 class="text-danger font-weight-bold">Kes 100</h5>
					<p class="card-text text-success">No Expiry</p>
					<input type="hidden" name="amount" value="100">
					<input type="hidden" name="plan" value="1gb">
					
				</div>
				<div class="card-footer">
					<small class="font-weight-bold"></small>
					<input type="text" name="phone" class="form-control" value="@if(isset(Auth::user()->phone ))0{{ Auth::user()->phone }}@else {{ 'phone' }}@endif" style="display: none;"><br>
					<button type="button" class="btn btn-md btn-primary purchase">Purchase</button>
				</div>
			</div>
			{{ csrf_field() }}
		</form>
	</div>
	<div class="col-md-3">
		<form method="post" action="{{ route('user.post.credentials') }}">
			<div class="card text-center">
				<div class="card-header"><h4>2 GB</h4></div>
				<div class="card-body">
					<h5 class="text-danger font-weight-bold">Kes 200</h5>
					<p class="card-text text-success">No Expiry</p>
					<input type="hidden" name="amount" value="200">
					<input type="hidden" name="plan" value="2gb">
					
				</div>
				<div class="card-footer">
					<small class="font-weight-bold"></small>
					<input type="text" name="phone" class="form-control" value="@if(isset(Auth::user()->phone ))0{{ Auth::user()->phone }}@else {{ 'phone' }}@endif" style="display: none;"><br>
					<button type="button" class="btn btn-md btn-primary purchase">Purchase</button>
				</div>
			</div>
			{{ csrf_field() }}
		</form>
	</div>
	<div class="col-md-3">
		<form method="post" action="{{ route('user.post.credentials') }}">
			<div class="card text-center">
				<div class="card-header"><h4>5 GB</h4></div>
				<div class="card-body">
					<h5 class="text-danger font-weight-bold">Kes 500</h5>
					<p class="card-text text-success">No Expiry</p>
					<input type="hidden" name="amount" value="500">
					<input type="hidden" name="plan" value="5gb">
					
				</div>
				<div class="card-footer">
					<small class="font-weight-bold"></small>
					<input type="text" name="phone" class="form-control" value="@if(isset(Auth::user()->phone ))0{{ Auth::user()->phone }}@else {{ 'phone' }}@endif" style="display: none;"><br>
					<button type="button" class="btn btn-md btn-primary purchase">Purchase</button>
				</div>
			</div>
			{{ csrf_field() }}
		</form>
	</div>
	<div class="col-md-3">
		<form method="post" action="{{ route('user.post.credentials') }}">
			<div class="card text-center">
				<div class="card-header"><h4>Unlimited Monthly</h4></div>
				<div class="card-body">
					<h5 class="text-danger font-weight-bold">Kes 1500</h5>
					<p class="card-text text-success">Monthly Subscription</p>
					<input type="hidden" name="amount" value="2000">
					<input type="hidden" name="plan" value="monthlyplan">

				</div>
				<div class="card-footer">
					<small class="font-weight-bold"></small>
					<input type="text" name="phone" class="form-control" value="@if(isset(Auth::user()->phone ))0{{ Auth::user()->phone }}@else {{ 'phone' }}@endif" style="display: none;"><br>
					<button type="button" class="btn btn-md btn-primary purchase">Purchase</button>
				</div>
			</div>
			{{ csrf_field() }}
		</form>
	</div>
</div>
@endsection
@section('scripts')
<script type="text/javascript">
	$(document).ready(function(){
		$('.purchase').click(function(){
			$(this).siblings('small').html('use this number to pay from or edit?').addClass('text-danger');
			$(this).siblings('input').show();
			$(this).html('Buy Now').removeClass('btn-primary').addClass('btn-success');
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