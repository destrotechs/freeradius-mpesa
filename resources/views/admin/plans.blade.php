@extends('layouts.adminlayout')
@section('content')
<div class="row">
	<div class="col-md-9">
		<h3>Plans</h3>
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
      <th scope="col">Title</th>
      <th scope="col">Name</th>
      <th scope="col">Cost</th>
      <th>Description</th>
    </tr>
  </thead>
  <tbody>
  	@foreach($plans as $c)
    <tr>
      <th scope="row">{{ $c->id }}</th>
      <td>{{ $c->plantitle }}</td>
      <td>{{ $c->planname }}</td>
      <td>{{ $c->cost }}</td>
       <td>{{ $c->desc }}</td>
    </tr>
    @endforeach
  </tbody>
</table>
<!-- Modal -->
<div class="modal fade" id="staticBackdrop" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel">New Plan</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form method="post" action="{{ route('admin.post.plan') }}">
        	<label>Title</label>
        	<input type="text" name="plantitle" class="form-control" placeholder="plantitle">
        	<label>Plan Name</label>
        	<input type="text" name="planname" class="form-control" placeholder="plan name">
        	<label>Plan Cost</label>
        	<input type="text" name="cost" class="form-control" placeholder="e.g 20">
        	<label>Description</label>
        	<textarea type="text" name="desc" class="form-control" placeholder="plan name"></textarea>
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