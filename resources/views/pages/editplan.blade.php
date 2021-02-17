@extends('layouts.master')
@section('content')
<div class="card">
	<div class="card-header"><h4>Edit Plan</h4></div>
	<div class="card-body">
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
		@foreach($plan as $p)
		<form method="post" action="{{ route('posteditplan') }}">
        	<label>Title</label>
        	<input type="text" name="plantitle" class="form-control" placeholder="plantitle" value="{{ $p->plantitle }}">
        	<label>Plan Name</label>
        	<input type="text" name="planname" class="form-control" placeholder="plan name" value="{{ $p->planname }}">
        	<label>Plan Cost</label>
        	<input type="text" name="cost" class="form-control" placeholder="e.g 20" value="{{ $p->cost }}">
        	<label>Description</label>
        	<textarea type="text" name="desc" class="form-control" placeholder="plan name">{{ $p->desc }}</textarea>
        	<input type="hidden" name="id" value="{{ $p->id }}">
      </div>
      <div class="modal-footer">
        <button type="submit" name="submit" class="btn btn-success">Save Changes</button>
        {{ csrf_field() }}
      </div>
  		</form>
  		@endforeach
	</div>
</div>
@endsection