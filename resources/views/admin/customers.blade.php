@extends('layouts.adminlayout')
@section('content')
<div class="row">
	<div class="col-md-9">
		<h3>Customers</h3>
	</div>
	<div class="col-md-3 d-flex justify-content-end">
		<a href="#" class="btn btn-primary" data-toggle="modal" data-target="#staticBackdrop"><i class="fa fa-plus"></i>&nbsp;Create</a>
	</div>
</div>
<hr>
<table class="table table-striped table-sm table-bordered">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">Username</th>
      <th scope="col">Attribute</th>
      <th scope="col">Value</th>
    </tr>
  </thead>
  <tbody>
  	@foreach($customers as $c)
    <tr>
      <th scope="row">{{ $c->id }}</th>
      <td>{{ $c->username }}</td>
      <td>{{ $c->attribute }}</td>
      <td>{{ $c->value }}</td>
    </tr>
    @endforeach
    <tfoot>
    	<tr>
    		<td colspan="4">{{ $customers->links() }}</td>
    	</tr>
    </tfoot>
  </tbody>
</table>
<!-- Modal -->
<div class="modal fade" id="staticBackdrop" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel">New Customer</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form method="post" action="{{ route('admin.post.customer') }}">
        	<label>Username</label>
        	<input type="text" name="username" class="form-control" placeholder="username">
        	<input type="hidden" name="op" value=":=">
        	<input type="hidden" name="attribute" value="Cleartext-Password">
        	<label>Password</label>
        	<input type="text" name="value" class="form-control" placeholder="password">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" name="submit" class="btn btn-success">Save</button>
        {{ csrf_field() }}
      </div>
  		</form>
    </div>
  </div>
</div>
@endsection