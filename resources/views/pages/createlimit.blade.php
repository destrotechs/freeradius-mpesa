@extends('layouts.master')

@section('content')
<div class="card-title row col-md-12"><h3>New User Limit</h3></div><br><hr>
<div class="card">
	<div class="card-body">
		
		<form method="post" action="{{ route('postnewlimit') }}">
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
			@if ($errors->any())
			    <div class="alert alert-danger">
			        <ul>
			            @foreach ($errors->all() as $error)
			                <li>{{ $error }}</li>
			            @endforeach
			        </ul>
			    </div>
			@endif
		  <div class="form-group row">
		    <label for="inputPassword" class="col-sm-2 col-form-label">Vendor Name</label>
		    <div class="col-sm-10">
		      <input type="text" class="form-control" placeholder="input vendor name" autofocus="autofocus" name="vendor">
		    </div>
		  </div>
		  <div class="form-group row">
		    <label for="inputPassword" class="col-sm-2 col-form-label">Limit Name</label>
		    <div class="col-sm-10">
		      <input type="text" class="form-control" placeholder="input limit name" autofocus="autofocus" name="limitname">
		    </div>
		  </div>
		  <div class="form-group row">
		    <label for="inputPassword" class="col-sm-2 col-form-label">Limit Type</label>
		    <div class="col-sm-10">
		      <select name="type" class="form-control" id="exampleFormControlSelect1">
			      <option value="">Select limit type...</option>
			      <option value="integer">integer</option>
			      <option value="string">string</option>
			      <option value="ipaddr">ipaddr</option>
			      <option value="ipv6">ipv6</option>
			    </select>
		    </div>
		  </div>
		  <div class="form-group row">
		    <label for="inputPassword" class="col-sm-2 col-form-label">Prefered Op</label>
		    <div class="col-sm-10">
		      <select name="op" class="form-control" id="exampleFormControlSelect1">
			      <option value="">Select prefered operand...</option>
			      <option value=":=">:=</option>
			      <option value="==">==</option>
			    </select>
		    </div>
		  </div>
		  <div class="form-group row">
		    <label for="inputPassword" class="col-sm-2 col-form-label">Prefered Table</label>
		    <div class="col-sm-10">
		      <select name="table" class="form-control" id="exampleFormControlSelect1">
			      <option value="">Select prefered table...</option>
			      <option value="check">check</option>
			      <option value="reply">reply</option>
			    </select>
		    </div>
		  </div>
		  <div class="form-group row">
		    <label for="inputPassword" class="col-sm-2 col-form-label">Limit Description</label>
		    <div class="col-sm-10">
		      <textarea class="form-control" name="description"></textarea>
		    </div>
		  </div>
		  <hr>
		  <button class="btn btn-success" type="submit">Save</button>
		  {{ csrf_field() }}
		</form>
	</div>
</div>
@endsection