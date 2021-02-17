@extends('layouts.master')
@section('pagetitle')
Online Customers
@endsection
@section('content')
<div class="card">
	<div class="card-body">
		<table class="table table-bordered table-striped table-md">
			<thead>
				<tr>
					<th>#</th>
					<th>Username</th>
					<th>User IP Address</th>
					<th>Start Time</th>
					<th>Nas / Hotspot</th>
					<th>Total Bandwidth</th>
				</tr>
			</thead>
<?php $num=0;?>
			<tbody>
				@forelse($onlineusers as $u)
				<?php $num++;?>
					<tr>
						<td>{{ $num }}</td>
						<td>{{ $u->username }}</td>
						<td>{{ $u->framedipaddress }}</td>
						<td>{{ $u->acctstarttime }}</td>
						<td>{{ $u->nasipaddress }}</td>
						<td>{{ $u->AcctInputOctets+$u->AcctOutputOctets }}</td>
					</tr>
				@empty
					<tr>
						<td class="alert alert-danger" colspan="6">There are no customers online</td>
					</tr>
				@endforelse
			</tbody>
			<tfoot>
				<tr>
					<td>{!! $onlineusers->links() !!}</td>
				</tr>
			</tfoot>
		</table>
	</div>
</div>
@endsection