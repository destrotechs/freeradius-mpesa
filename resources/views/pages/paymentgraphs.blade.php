@extends('layouts.master')
@section('pagetitle')
Purchase Graphs
@endsection
@section('content')
<div class="card-body">
	{!! $purchaseChart->container() !!}
</div> 
<hr>

@endsection
@section('scripts')
{!! $purchaseChart->script() !!}
@endsection