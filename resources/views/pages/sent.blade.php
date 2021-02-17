@extends('layouts.master')
@section('pagetitle')
Sent
@endsection
@section('content')
<div class="p-2">
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
	<form class="form">
		<select class="form-select">
			<option value="">Sort By </option>
		</select>
	</form>
	<table class="table table-bordered table-striped table-sm">
		<thead>
			<tr>
				<th>Date</th>
				<th>Sent To</th>
				<th>Message</th>
				<th>Gateway</th>
				<th>Sender</th>
				<th></th>
			</tr>
		</thead>
		<tbody>
			@forelse($messages as $m)
			<tr>
				<td>{{ $m->created_at }}</td>
				<td>{{ $m->recipient }}</td>
				<td>{{ $m->message }}</td>
				<td>{{ $m->gateway }}</td>
				<td>{{ $m->sender }}</td>
				<td><a href="{{ route('deletemessage',['id'=>$m->id]) }}" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></a></td>
			</tr>
			@empty
			<tr>
				<td colspan="4" class="alert alert-danger">You have sent No messages</td>
			</tr>
			@endforelse
		</tbody>
	</table>
</div>
@endsection