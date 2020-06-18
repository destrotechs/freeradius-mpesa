@extends('layouts.default')
@section('content')
<div class="card card-body">
	<center><h4 class="card-title">HEWANET INTERNET</h4></center>
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