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
			    <button class="btn btn-success btn-md" type="submit">login</button>
			    {{ csrf_field() }}
			</form>
		  </div>
		</div>
	</div>
</div>
@endsection