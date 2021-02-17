@extends('layouts.master')

@section('content')
<?php

$attributes = array(
	array('limitname' => 'WISPr-','vendor'=>'B','op'=>':=','type'=>'reply','table'=>'check'),

	array('limitname' => 'A','vendor'=>'B','op'=>':=','type'=>'reply','table'=>'check'),
	array('limitname' => 'A','vendor'=>'B','op'=>':=','type'=>'reply','table'=>'check'),
	array('limitname' => 'A','vendor'=>'B','op'=>':=','type'=>'reply','table'=>'check'),
	array('limitname' => 'A','vendor'=>'B','op'=>':=','type'=>'reply','table'=>'check'),
	array('limitname' => 'A','vendor'=>'B','op'=>':=','type'=>'reply','table'=>'check'),

	 );
?>
	<div class="card">
		<div class="card-header"><h4>Limit Attributes<small><a href="{{route('newlimitattr')}}" class="btn btn-info float-right"><i class="fas fa-plus"></i>&nbsp;add</a></small></h4></div>
		<div class="card-body">
			<table class="table table-striped table-bordered table-sm">
				<thead>
					<tr>
						<th>Limit name</th>
						<th>Vendor</th>
						<th>Op</th>
						<th>Type</th>
						<th>Description</th>
						<th>Preferred Table</th>
					</tr>
				</thead>
				<tbody>
					@forelse($userlimits as $l)
					<tr>
						<td>{{ $l->limitname }}</td>
						<td>{{ $l->vendor }}</td>
						<td>{{ $l->op }}</td>
						<td>{{ $l->type }}</td>
						<td>{{ $l->description }}</td>
						<td>{{ $l->table }}</td>
					</tr>
					@empty
					<tr class="alert alert-danger"><td colspan="6">No limits available yet</td></tr>
					@endforelse
				</tbody>
				<tfoot>
					<tr>
						<td colspan="6">{!! $userlimits->links() !!}</td>
					</tr>
				</tfoot>
			</table>
		</div>
	</div>
@endsection