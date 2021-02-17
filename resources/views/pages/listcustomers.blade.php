@extends('layouts.master')
@section('content')
Customers u
@endsection
@section('content')
<table class="table table-striped table-bordered">
	<thead>
	<tr>
		<th>#</th>
		<th>Name</th>
		<th>Username</th>
		<th>Email</th>
		<th>Password</th>
		<th>Phone Number</th>
		<th>user purchases</th>
		<th>Action</th>
	</tr>
	</thead>
	<tbody>
		@forelse($customers as $c)
			<tr>
				<td>{{$c->id}}</td>
				<td>{{$c->name}}</td>
				<td>{{$c->username}}</td>
				<td>{{$c->email}}</td>
				<td>{{$c->cleartextpassword}}</td>
				<td>{{$c->phone}}</td>
				<td></td>
				<td></td>
			</tr>
		@empty
			<tr>
				<td colspan="8" class="text-danger">No Users available</td>
			</tr>

		@endforelse
	</tbody>
</table>


@endsection