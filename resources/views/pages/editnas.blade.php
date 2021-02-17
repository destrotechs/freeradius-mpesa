@extends('layouts.master')
@section('pagetitle')
Edit Nas
@endsection
@section('content')
<div class="card">
	<div class="card-body">
		@if (session('success'))
		    <div class="alert alert-success">
		        {{ session('success') }}
		    </div>
		@endif
		<form action=" {{ route('saveeditednas') }}" method="POST">
			@foreach($nas as $n)
			<label>Nas Ip Address</label>
			<input type="text" name="nasname" class="form-control" value="{{ $n->nasname }}">
			<label>Nas Secret</label>
			<input type="text" name="secret" class="form-control" value="{{ $n->secret }}">
			<input type="hidden" name="id" value="{{ $n->id }}">
			<label>Nas Shortname</label>
			<input type="text" name="shortname" class="form-control" value="{{ $n->shortname }}">
			<hr>
			<button class="btn btn-success btn-md" type="submit">Save Changes</button>
			{{ csrf_field() }}
			@endforeach
		</form>
	</div>
</div>

@endsection