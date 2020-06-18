@extends('layouts.default')
@section('content')
<nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item active" aria-current="page">User Signup</li>
  </ol>
</nav>
<div class="card card-body">
	<form class="form-md" method="post" action="{{ route('user.post.signup') }}">
		{{ csrf_field() }}
		@if (session('message'))
		    <div class="alert alert-success">
		        {{ session('message') }}
		    </div>
		@endif
				<div class="err"></div>
			<div class="form-group">
			    <label for="exampleInputEmail1">Name*</label>
			    <input type="text" name="name" class="form-control name @error('name') is-invalid @enderror" value="{{ old('name') }}">
			    @error('name')
				    <div class="text-danger">{{ $message }}</div>
				@enderror
			</div>
			  <div class="form-group">
			    <label for="exampleInputEmail1">Phone*</label>
			    <input type="text" name="phone" class="form-control phone @error('phone') is-invalid @enderror" placeholder="in form of 07xxxxxxxx" value="{{ old('phone') }}">
			    @error('phone')
				    <div class="text-danger">{{ $message }}</div>
				@enderror
			  </div>
			  <div class="form-group">
			    <label for="exampleInputEmail1">Email address (optional)</label>
			    <input type="email" name="email" class="form-control email @error('email') is-invalid @enderror" id="exampleInputEmail1" aria-describedby="emailHelp" value="{{ old('email') }}">
			    @error('email')
				    <div class="text-danger">{{ $message }}</div>
				@enderror
			    <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
			  </div>
			  <div class="form-group">
			    <label for="exampleInputEmail1">Username*</label>
			    <input type="text" name="username" class="form-control username @error('username') is-invalid @enderror" value="{{ old('username') }}">
			    @error('username')
				    <div class="text-danger">{{ $message }}</div>
				@enderror
			    <small id="emailHelp" class="form-text text-muted">We'll never share your username with anyone else.</small>
			  </div>
			  <div class="form-group">
			    <label for="exampleInputPassword1">Password*</label>
			    <input type="password" name="password" class="form-control password @error('password') is-invalid @enderror" id="exampleInputPassword1">
			  </div>
			  @error('password')
				    <div class="text-danger">{{ $message }}</div>
				@enderror
			  <button type="submit" name="signup" class="btn btn-success signup">Signup</button>
			</form>
</div>
@endsection