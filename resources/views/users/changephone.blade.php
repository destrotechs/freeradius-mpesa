@extends('layouts.default')
@section('content')
<div class="card">
	<div class="card-header"><h4>Change Phone Number</h4></div>
	<div class="card-body">
		<form action="{{ route('user.post.changephone') }}" method="post">
			<div id="err"></div>
			
			<label>Phone</label>
			<input type="text" class="form-control" name="phone" value="@if(isset(Auth::user()->phone ))0{{ Auth::user()->phone }}@else {{ 'username' }}@endif" id="username">
			<small>Edit the number and click change</small>
			<br>
			<button class="btn btn-success btn-md" type="submit">Change</button>
			{{ csrf_field() }}
		</form>
	</div>
</div>
@endsection