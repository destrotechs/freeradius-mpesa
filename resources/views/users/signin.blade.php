@extends('layouts.default')
@section('content')
<div class="row">
	<div class="col-md-12 d-flex justify-content-center">
		<div class="card" style="width: 30rem;">
		  <div class="card-body">
		    <center><h5 class="card-title">user login</h5></center><hr>
		    <form method="post" action="{{ route('user.post.signin') }}">
		    	
			    <label>Username</label>
			    <input type="text" name="username" placeholder="username" class="form-control">
			    <label>Password</label>
			    <input type="password" name="password" placeholder="*******" class="form-control">
			    <br>
			    <div class="form-row">
			    	<div class="col">
			    		<button class="btn btn-success btn-md" type="submit">login</button>
			    	</div>
			    	<div class="col">
			    		<p>Don't have an account? <a href="{{ route('user.signup') }}">signup</a></p>
			    	</div>
				</div>
			    {{ csrf_field() }}
			</form>
		  </div>
		</div>
	</div>
</div>
@endsection