@extends('layouts.master')

@section('content')
@if (session('success'))
		    <div class="alert alert-success">
		        {{ session('success') }}
		    </div>
		@endif
<ul class="nav nav-tabs" id="myTab" role="tablist">
  <li class="nav-item" role="presentation">
    <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Groups available</a>
  </li>
  <li class="nav-item" role="presentation">
    <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false"><i class="fas fa-plus"></i> New limit Group</a>
  </li>
</ul>
<div class="tab-content" id="myTabContent">
  <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
  	<table class="table table-sm table-bordered table-striped table-light">
  		<tbody>
  			
  			@forelse($groups as $c)
  			<tr>
  				<td>{{ $c->groupname }}</td>
  				<td><a href="{{ route('editgroup',['groupname'=>$c->groupname]) }}" class="btn btn-primary btn-sm"><i class="fas fa-edit"></i></a><a href="{{ route('deletegroup',['groupname'=>$c->groupname]) }}" class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></a></td>
  			</tr>
  			@empty
  			<tr><td colspan="2" class="alert alert-danger">No groups added yet</td></tr>
  			@endforelse
  		</tbody>
  	</table>
  </div>
  <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
  	<div class="card">
	<div class="card-header"><h6>Create Limit Group</h6></div>
	<div class="card-body">
	<form method="post" action="{{ route('postnewgrouplimit') }}">
		{{ csrf_field() }}
		
		<div class="card-body">
			<div class="form-group row">
		    <label for="inputPassword" class="col-sm-2 col-form-label">Group Name</label>
		    <div class="col-sm-10">
		      <input type="text" class="form-control" placeholder="input group name" autofocus="autofocus" name="groupname">
		    </div>
		  </div>
		</div>
		<hr class="p-1">
		<div class="row">
	  			<div class="col-md-11">
	  				<div class="input-group mb-3">
					  <div class="input-group-prepend">
					    <label class="input-group-text" for="inputGroupSelect01">Limit Name</label>
					  </div>
					  <select class="custom-select" id="attrselect">
					    <option value="">Choose limit...</option>
					    @forelse($limitattributes as $l)
					    	<option value="{{ $l->limitname }}">{{ $l->limitname }}</option>
					    @empty
					    	<option value="">No Limits available</option>
					    @endforelse
					  </select>
					</div>
	  			</div>
	  			<div class="col-md-1">
	  				<a href="#" class="btn btn-success add"><i class="fa fa-plus"></i></a>
	  			</div>
	  			
				<hr>
				</div>
		<hr>
		<div class="attrs">
					
		</div>
		<hr>
		<button type="submit" class="btn btn-success">Save</button>
	</form>
</div>
</div>
  </div>
</div>

@endsection
@section('scripts')
<script type="text/javascript">
	$(document).ready(function(){
		$(".add").click(function(){
			var attributevalue=$("#attrselect").val();
			var attribute="<div class='row col-md-12 mb-3 p-3'><div class='col-md-4'><input name='attribute[]' class='form-control' type='text' value='"+attributevalue+"'></div><div class='col-md-4'><input type='text' name='value[]' class='form-control' placeholder='value'></div><div class='col-md-2'><select class='custom-select' name='op[]'><option value=':='>:=</option><option value='=='>==</option></select></div><div class='col-md-2'><select class='custom-select' name='type[]'><option value='reply'>reply</option><option value='check'>check</option></select></div></div>";
			$(".attrs").append(attribute);
		})
	})
</script>
@endsection