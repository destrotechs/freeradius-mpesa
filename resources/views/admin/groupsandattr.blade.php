@extends('layouts.adminlayout')
@section('content')
<form method="post" action="{{ route('admin.post.groupandattribute') }}">
<div class="card card-body">
	<nav>
  <div class="nav nav-tabs" id="nav-tab" role="tablist">
    <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true">Groups</a>
    <a class="nav-item nav-link" id="nav-profile-tab" data-toggle="tab" href="#nav-profile" role="tab" aria-controls="nav-profile" aria-selected="false">Attributes</a>
    {{-- <a class="nav-item nav-link" id="nav-contact-tab" data-toggle="tab" href="#nav-contact" role="tab" aria-controls="nav-contact" aria-selected="false">Contact</a> --}}
  </div>
</nav>
<div class="tab-content" id="nav-tabContent">
  <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab"><div class="row">
		<div class="col-md-12">
			<label>Type hint</label>
			<input type="text" name="usernamehint" class="form-control hint">
			<label>Username</label>
			<select class="form-control" id="username" name="username">
			  <option value="">Choose username...</option>
			</select>
			<label>Group</label>
			<select class="form-control" name="radgroupreply">
			  <option value="">Choose group...</option>
			  @forelse($groups as $g)
			  <option value="{{ $g->groupname }}">{{ $g->groupname }}</option>
			  @empty
			  <option value="">No group available</option>
			  @endforelse
			</select>
			<hr>
			<button class="btn btn-success" type="submit">Apply</button>
		</div>
	</div></div>
  <div class="tab-pane p-3 fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
  		<div class="row">
  			<div class="col-md-10">
  				<div class="input-group mb-3">
				  <div class="input-group-prepend">
				    <label class="input-group-text" for="inputGroupSelect01">Attributes</label>
				  </div>
				  <select class="custom-select" id="attrselect">
				    <option value="">Choose attribute...</option>
				    <option value="WISPr-Session-Terminate-Time">WISPr-Session-Terminate-Time</option>
				    <option value="Max-All-MB">Max-All-MB</option>
				  </select>
				</div>
  			</div>
  			<div class="col-md-2">
  				<a href="#" class="btn btn-success add"><i class="fa fa-plus"></i></a>
  			</div>
  			
			<hr>
		</div>
		<div class="row col-md-12 attrs">
			
		</div>
		<div class="row col-md-12">
			<button class="btn btn-success" type="submit">Apply</button>
		</div>
  {{-- <div class="tab-pane fade" id="nav-contact" role="tabpanel" aria-labelledby="nav-contact-tab">...</div> --}}
</div>
	
	{{ csrf_field() }}
</div>
</form>
@endsection
@section('scripts')
<script type="text/javascript">
	$(document).ready(function(){
		$(".hint").on("keyup",function(){
			var _token=$("input[name='_token']").val();
			var myhint=$(this).val();
			if(myhint!=""){
				var req=$.ajax({
					method:"POST",
					url:"{{ route('admin.search.user') }}",
					data:{myhint:myhint,_token:_token},
				});

				req.done(function(result){
						$("#username").empty().html(result);
				});
			}else{
				$("#username").empty().html("<option=''>Type hint</option>");
			}
			
		});
		$(".add").click(function(){
			var attributevalue=$("#attrselect").val();
			var attribute="<hr><div class='col-md-4'><input name='attribute[]' class='form-control' type='text' value='"+attributevalue+"'></div><div class='col-md-4'><input type='text' name='value[]' class='form-control' placeholder='value'></div><div class='col-md-2'><select class='custom-select' name='op[]'><option value=':='>:=</option><option value='='>=</option></select></div><div class='col-md-2'><select class='custom-select' name='type[]'><option value='reply'>reply</option><option value='check'>check</option></select></div><hr>";
			$(".attrs").append(attribute);
		})
		
	})
</script>
@endsection