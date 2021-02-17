@extends('layouts.master')

@section('content')
<a href="{{route('vouchers')}}" class="btn btn-info btn-md"><i class="fas fa-plus">&nbsp;new vouchers</i></a>
<br>
<div class="card mt-1">
	<div class="card-header"><h5>All vouchers<form class="float-right">
		<div class="form-group">
    <select class="form-control" id="exampleFormControlSelect1">
      <option value="">Plan Type...</option>
      <option value="bundles">WiFi Bundles</option>
      <option value="time">Time Limit</option>
    </select>
  </div></form></h5></div>
	<div class="card-body">
		<div class="row">
			<div class="col-md-12">
				@forelse($availablev->chunk(3) as $voucher)
					<div class="row">
						@foreach($voucher as $v)
						
						<div class="col-md-4">
							<div class="row no-gutters border rounded overflow-hidden flex-md-row mb-4 shadow-sm h-md-250 position-relative">
				        <div class="col p-4 d-flex flex-column position-static">
				          <strong class="d-inline-block mb-2 text-success">Kes. {{ $v->cost }}</strong>
				          <h3 class="mb-0">{{ $v->plan }}</h3>
				          <div class="mb-1 text-muted">Voucher no. {{ $v->serialnumber }}</div>
				          <p class="mb-auto">
				          	<li class="list-group-item"><b>Username:</b> {{ $v->username }}</li>
							<li class="list-group-item"><b>Password:</b> {{ $v->password }}</li>
				          </p>
				          <a href="{{ route('sellvoucher',['id'=>$v->id]) }}" class="btn btn-md btn-primary float-right"><i class="fas fa-shopping-cart"></i> sell</a>
				        </div>
				      </div>
							
						</div>
						@endforeach
					</div>
				@empty
					<div class="alert alert-danger">No vouchers available, click <a href="{{ route('vouchers') }}">here</a> to create new vouchers</div>
				@endforelse
				<hr>
				{!! $availablev->links() !!}
			</div>
		</div>
	</div>
</div>
@endsection