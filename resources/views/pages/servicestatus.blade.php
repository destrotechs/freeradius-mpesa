@extends('layouts.master')
@section('content')
<h4>Services Status</h4><br>
@if (session('message'))
			    <div class="alert alert-success">
			        {{ session('message') }}
			    </div>
			@endif
			@if (session('error'))
			    <div class="alert alert-danger">
			        {{ session('error') }}
			    </div>
			@endif
<?php
function check_service($sname) {
	if ($sname != '') {
		system("pgrep ".escapeshellarg($sname)." >/dev/null 2>&1", $ret_service);
		if ($ret_service == 0) {
			return "Enabled";
		} else {
			return "Disabled";
		}
	} else {
		return "no service name";
	}
}

?>
<div class="card">
<div class="card-body">
	<table class="table table-bordered table-striped">
		<thead>
			<tr>
				<th>Service</th>
				<th>Status</th>
				<th></th>
			</tr>
		</thead>
		<tbody>
			<form method="post" action="#">
			<tr>
				<td>Radius</td>
				<td><?php echo check_service('radius');?></td>
				<td><a href="{{ route('restartradius') }}" class="btn btn-sm btn-outline-danger">Restart Service</a></td>
			</tr>
			<tr>
				<td>Apache/Web Server</td>
				<td><?php echo check_service('apache2');?></td>
				<td><a href="{{ route('restartradius') }}" class="btn btn-sm btn-outline-danger">Restart Service</a></td>
			</tr>
			<tr>
				<td>Mysql</td>
				<td><?php echo check_service('mysql');?></td>
				<td><a href="{{ route('restartmysql') }}" class="btn btn-sm btn-outline-danger">Restart Service</a></td>
			</tr>
		</form>
		</tbody>
	</table>
</div>

</div>

@endsection