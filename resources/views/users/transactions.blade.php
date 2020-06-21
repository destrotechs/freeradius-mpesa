@extends('layouts.default')
@section('content')
<div class="card">
	<div class="card-body">
		<table class="table table-bordered table-sm table striped">
			<thead>
				<tr>
					<th colspan="7">{{ Auth::user()->name }}&nbsp; Transactions</th>
				</tr>
				<tr>
					<th>Username</th>
					<th>Plan Bought</th>
					<th>Amount Paid</th>
					<th>Receipt No</th>
					<th>Phone Number</th>
					<th>Date</th>
				</tr>
			</thead>
			<tbody>
				@forelse($transactions as $t)
				<tr>
					<td>{{ $t->username }}</td>
					<td>{{ $t->plan }}</td>
					<td>{{ $t->amount }}</td>
					<td>{{ $t->transaction_id }}</td>
					<td>0{{ substr($t->phone_number, 3) }}</td>
					<td>{{ date('d/n/y',$t->transaction_date) }}</td>
				</tr>
				@empty
				<tr>
					<td colspan="7"><div class="alert alert-danger">You have no transactions yet</div></td>
				</tr>
				@endforelse
			</tbody>
		</table>
	</div>
</div>
@endsection