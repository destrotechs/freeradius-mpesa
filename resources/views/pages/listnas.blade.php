@extends('layouts.master')

@section('content')
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
			<a href="{{ route('newnas') }}" class="nav-link float-right"><i class="fas fa-plus"></i>&nbsp;Add Nas&nbsp;<i class="fas fa-angle-right"></i><i class="fas fa-angle-right"></i></a>
<table class="table table-sm table-striped table-bordered">
	<thead>
		<tr>
			<th>#</th>
			<th>Nas Ip</th>
			<th>Nas shortname</th>
			<th>Nas Type</th>
			<th>Nas Secret</th>
			<th>Nas Server</th>
			<th>Nas Community</th>
			<th>Nas Description</th>
			<th>Action</th>
		</tr>
	</thead>
	<tbody>
		@forelse($nas as $n)
		<tr>
			<td>{{ $n->id }}</td>
			<td>{{ $n->nasname }}</td>
			<td>{{ $n->shortname }}</td>
			<td>{{ $n->type }}</td>
			<td>{{ $n->secret }}</td>
			<td>{{ $n->server }}</td>
			<td>{{ $n->community }}</td>
			<td>{{ $n->description }}</td>
			<td>
				<div class="btn-group" role="group" aria-label="Basic example">
				  	<a href="{{ route('editnas',['id'=>$n->id]) }}" class="btn btn-info btn-sm text-white"><i class="fas fa-edit"></i></a>
				  	<a href="{{ route('deletenas',['id'=>$n->id]) }}" class="btn btn-danger btn-sm text-white"><i class="fas fa-trash"></i></a>
				 
				</div>
			</td>
		</tr>
		@empty
		<tr>
			<td class="text-danger" colspan="8">No nas added yet</td>
		</tr>
		@endforelse
	</tbody>
</table>
@endsection