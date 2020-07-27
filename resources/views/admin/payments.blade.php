@extends('layouts.adminlayout')
@section('content')
<h3>Payments</h3>
<hr>
<table class="table table-striped table-sm table-bordered">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">Username</th>
      <th scope="col">Receipt id</th>
      <th scope="col">Number</th>
      <th scope="col">Plan</th>
      <th scope="col">Amount</th>
    </tr>
  </thead>
  <tbody>
  	@foreach($payments as $c)
    <tr>
      <th scope="row">{{ $c->id }}</th>
      <td>{{ $c->username }}</td>
      <td>{{ $c->transaction_id }}</td>
      <td>{{ $c->phone_number }}</td>
       <td scope="col">{{ $c->plan }}</td>
       <td>Kes.{{ $c->amount }}</td>
    </tr>
    @endforeach
  </tbody>
  <tfoot>
  	<tr>
  		<th colspan="5">{{ $payments->links() }}</th>
  		<th>Total Kes.{{ $totalsum }}</th>
  	</tr>
  </tfoot>
</table>
@endsection