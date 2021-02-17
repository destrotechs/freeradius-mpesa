@extends('layouts.master')

@section('content')
@if (session('success'))
		    <div class="alert alert-success">
		        {{ session('success') }}
		    </div>
		@endif

<div class="card">
	<div class="card-header"><h5>Edit {{ $groupname }}<small><a href="{{ route('deletegroup',['groupname'=>$groupname]) }}" class="btn btn-danger btn-sm float-right"><i class="fas fa-trash"></i>&nbsp; delete group</a></small></h5></div>
	<div class="card-body">
		<ul class="nav nav-tabs" id="myTab" role="tablist">
		  <li class="nav-item" role="presentation">
		    <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Check limits</a>
		  </li>
		  <li class="nav-item" role="presentation">
		    <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Reply limits</a>
		  </li>
		  <li class="nav-item" role="presentation">
		    <a class="nav-link" id="contact-tab" data-toggle="tab" href="#contact" role="tab" aria-controls="contact" aria-selected="false">Add Limits</a>
		  </li>
		</ul>
		<form method="post" action="{{ route('post.edited.group') }}">
			<input type="hidden" name="groupname" value="{{ $groupname }}">
		<div class="tab-content" id="myTabContent">
		  <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
		  	<table class="table table-striped table-bordered mt-3">
		  		<tbody>
		  			@forelse($checklimits as $c)
		  			<tr>
		  				<td>{{ $c->attribute }}</td>
		  				<input type="hidden" name="attribute[]" value="{{ $c->attribute}}">
		  				<td><input type="text" class="form-control" name="op[]" value="{{ $c->op }}"></td>
		  				<td><input type="text" class="form-control" name="value[]" value="{{ $c->value }}"></td>
		  				<input type="hidden" name="type[]" value="check">
		  				<td><a role="button" href="{{ route('deletechecklimit',['id'=>$c->id]) }}" class="btn btn-danger btn-sm mt-2 trash2"><i class="fas fa-trash"></i></a></td>
		  			</tr>
				  	@empty
				  	<tr><td colspan="4" class="alert alert-danger">No check attributes</td></tr>
				  	@endforelse
				  	
		  		</tbody>
		  	</table>
		  	
		  </div>
		  <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
		  	<table class="table table-striped table-bordered mt-3">
		  		<tbody>
		  			@forelse($replylimits as $c)
		  			<tr>
		  				<td>{{ $c->attribute }}</td>
		  				<input type="hidden" name="attribute[]" value="{{ $c->attribute}}">
		  				<td><input type="text" class="form-control" name="op[]" value="{{ $c->op }}"></td>
		  				<td><input type="text" class="form-control" name="value[]" value="{{ $c->value }}"></td>
		  				<input type="hidden" name="type[]" value="reply">
		  				<td><a href="{{ route('deletereplylimit',['id'=>$c->id]) }}" class="btn btn-danger btn-sm mt-2"><i class="fas fa-trash"></i></a></td>
		  			</tr>
				  	@empty
				  	<tr><td colspan="4" class="alert alert-danger">No reply attributes</td></tr>
				  	@endforelse
		  		</tbody>
		  	</table>
		  </div>
		  <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">
		  	<div class="row mt-3">
        <div class="col-md-10">
          <div class="input-group mb-3">
          <div class="input-group-prepend">
            <label class="input-group-text" for="inputGroupSelect01">Limits</label>
          </div>
          <select class="custom-select" id="attrselect">
            <option value="">Choose limit...</option>
            @forelse($limitattributes as $a)
            <option value="{{ $a->limitname }}">{{ $a->limitname }}</option>
            @empty
            <option value="">no attributes available</option>
            @endforelse
          </select>
        </div>
        </div>
        <div class="col-md-2">
          <a href="#" class="btn btn-success add"><i class="fa fa-plus"></i></a>
        </div>
        
      <hr>
    </div>
    <div class="row col-md-12 attrs p-3">
      
    </div>
		  </div>
		</div>
		<hr>
	@csrf
		<input type="submit" name="submit" value="Save Changes" class="btn btn-success">
	</form>
	</div>
</div>
@endsection
@section('scripts')
<script type="text/javascript">
  $(document).ready(function(){
    $(".add").click(function(){
      var attributevalue=$("#attrselect").val();
      var attribute="<br class='mt-2'><hr><div class='col-md-4'><input name='attribute[]' class='form-control' type='text' value='"+attributevalue+"'></div><div class='col-md-4'><input type='text' name='value[]' class='form-control' placeholder='value'></div><div class='col-md-2'><select class='custom-select' name='op[]'><option value=':='>:=</option><option value='='>=</option></select></div><div class='col-md-2'><select class='custom-select' name='type[]'><option value='reply'>reply</option><option value='check'>check</option></select></div><hr>";
      $(".attrs").append(attribute);
    });

  });
</script>
@endsection