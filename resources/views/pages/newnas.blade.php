@extends('layouts.master')
@section('pagetitle')
New Nas
@endsection
@section('content')
<div class="card">
	<div class="card-body">
		@if (session('success'))
		    <div class="alert alert-success">
		        {{ session('success') }}
		    </div>
		@endif
		<form action=" {{ route('savenewnas') }}" method="POST">
			<label>Nas Ip Address</label>
			<input type="text" name="nasname" class="form-control" placeholder="ip address">
			<label>Nas Secret</label>
			<input type="text" name="secret" class="form-control" placeholder="nas secret">
			<label>Nas Shortname</label>
			<input type="text" name="shortname" class="form-control" placeholder="nas shortname">
			<hr>
			<button class="btn btn-success btn-md" type="submit">Save</button>
			{{ csrf_field() }}
		</form>
	</div>
</div>

@endsection