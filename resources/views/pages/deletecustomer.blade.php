@extends('layouts.master')
@section('content')
<div class="card">
	<div class="card-header"><h4>Remove user</h4></div>

	<div class="card-body">
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
		@if(isset($customer))
		<form method="POST" action="{{ route('post.delete.user') }}">
			@foreach($customer as $u)
			<div class="form-group">
				<label>Username</label>
				<input type="text" name="username" class="form-control username" value="{{ $u->username }}">
			</div>
			<div class="users"></div>
			<div class="form-group">
			    <label for="exampleFormControlSelect1">Delete Accounting Records</label>
			    <select class="form-control" name="deleterecords" id="exampleFormControlSelect1">
			      <option value="no">No</option>
			      <option value="yes">Yes</option>
			    </select>
			  </div>
			  <hr>
			  {{ csrf_field() }}
			  <button class="btn btn-danger btn-md" type="submit">Remove</button>
			  @endforeach
		</form>
		@else
		<form method="POST" action="{{ route('post.delete.user') }}">
			{{ csrf_field() }}
			<div class="form-group">
				<label>Username</label>
				<input type="text" name="username" class="form-control username" placeholder="username">
			</div>
			<div id="users"></div>
			<div class="form-group">
			    <label for="exampleFormControlSelect1">Delete Accounting Records</label>
			    <select class="form-control" name="deleterecords" id="exampleFormControlSelect1">
			      <option value="no">No</option>
			      <option value="yes">Yes</option>
			    </select>
			  </div>
			  <hr>
			  <button class="btn btn-danger btn-md" type="submit">Remove</button>
		</form>
		@endif
	</div>
</div>
@endsection