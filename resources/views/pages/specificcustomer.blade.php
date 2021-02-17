@extends('layouts.master')

@section('content')
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
<form method="post" action="{{ route('saveeditedcustomer') }}">
  {{ csrf_field() }}
<ul class="nav nav-tabs" id="myTab" role="tablist">
  <li class="nav-item" role="presentation">
    <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Basic Info</a>
  </li>
  <li class="nav-item" role="presentation">
    <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Check Limits</a>
  </li>
  <li class="nav-item" role="presentation">
    <a class="nav-link" id="contact-tab" data-toggle="tab" href="#contact" role="tab" aria-controls="contact" aria-selected="false">Reply Limits</a>
  </li>
  <li class="nav-item" role="presentation">
    <a class="nav-link" id="contact-tab" data-toggle="tab" href="#group" role="tab" aria-controls="contact" aria-selected="false">Customer Groups</a>
  </li>
  <li class="nav-item" role="presentation">
    <a class="nav-link" id="contact-tab" data-toggle="tab" href="#nav-profile" role="tab" aria-controls="contact" aria-selected="false">Add Attributes</a>
  </li>
  <li class="nav-item" role="presentation">
    <a class="nav-link" id="contact-tab" data-toggle="tab" href="#usergroup" role="tab" aria-controls="contact" aria-selected="false">Assign Group</a>
  </li>
</ul>
<div class="tab-content" id="myTabContent">
  <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
  	<table class="table table-bordered table-striped">
  		<thead>
  			<tr>
          <th>Username</th>
  				<th>Name</th>
  				<th>Phone</th>
  				<th>Password</th>
  				<th>Email</th>
  			</tr>
  		</thead>
  		<tbody>
  			@foreach($customerinfo as $c)
  				<tr>
            <td><input type="text" name="username" value="{{ $c->username }}" class="form-control"></td>
  					<td><input type="text" name="name" value="{{ $c->name }}" class="form-control"></td>
  					<td><input type="text" name="phone" value="{{ $c->phone }}" class="form-control"></td>
  					<td><input type="text" name="cleartextpassword" value="{{ $c->cleartextpassword }}" class="form-control"></td>
  					<td><input type="email" name="email" value="{{ $c->email}}" class="form-control"></td>
  				</tr>
  			@endforeach
  		</tbody>
  	</table>
  </div>
  <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
  	<table class="table table-bordered table-striped">
  		<thead>
  			<tr>
  				<th>Limit Name</th>
  				<th>OP</th>
  				<th>Value</th>
          <th></th>
  			</tr>
  		</thead>
  		<tbody>
  			@forelse($checkattributes as $c)
  				<tr><input type="hidden" name="username" value="{{ $c->username }}" class="form-control">
  					<td><input type="text" name="attribute[]" value="{{ $c->attribute }}" class="form-control"></td>
  					<td><input type="text" name="op[]" value="{{ $c->op }}" class="form-control"></td>
  					<td><input type="text" name="value[]" value="{{ $c->value }}" class="form-control">
              <input type="hidden" name="type[]" value="check">
            </td>
            <td>
              <a class="btn btn-danger btn-sm mt-2" href="{{ route('deletecheckuserlimit',['id'=>$c->id]) }}"><i class="fas fa-trash"></i></a>
            </td>
  				</tr>
  			@empty
  				<tr>
  					<td class="alert alert-danger" colspan="4">User has no check attributes</td>
  				</tr>
  			@endforelse
  		</tbody>
  	</table>
  </div>
  <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">
  	<table class="table table-bordered table-striped">
  		<thead>
  			<tr>
  				<th>Limit Name</th>
  				<th>OP</th>
  				<th>Value</th>
          <th></th>
  			</tr>
  		</thead>
  		<tbody>
  			@forelse($replyattributes as $c)
  				<tr>
  					<td><input type="text" name="attribute[]" value="{{ $c->attribute }}" class="form-control"></td>
  					<td><input type="text" name="op[]" value="{{ $c->op }}" class="form-control"></td>
  					<td><input type="text" name="value[]" value="{{ $c->value }}" class="form-control">
              <input type="hidden" name="type[]" value="reply"></td>
              <td>
              <a class="btn btn-danger btn-sm mt-2" href="{{ route('deletereplyuserlimit',['id'=>$c->id]) }}"><i class="fas fa-trash"></i></a>
            </td>
  				</tr>
  				@empty
  				<tr>
  					<td class="alert alert-danger" colspan="4">User has no reply attributes</td>
  				</tr>
  			@endforelse
  		</tbody>
  	</table>
  </div>
  <div class="tab-pane fade" id="group" role="tabpanel" aria-labelledby="contact-tab">
  	<table class="table table-bordered table-striped">
  		<thead>
  			<tr>
  				<th>Group Name</th>
  			</tr>
  		</thead>
  		<tbody>
  			@forelse($groups as $c)
  				<tr>
  					<td>
  						<select class="form-control" id="exampleFormControlSelect1" name="groupname[]">
					      <option value="{{ $c->groupname }}">{{ $c->groupname }}</option>
					      
					    </select>
  					</td>
  				</tr>
  				@empty
  				<tr>
  					<td class="alert alert-danger" colspan="1">User has no groups</td>
  				</tr>
  			@endforelse
  		</tbody>
  	</table>
  </div>
   <div class="tab-pane p-3 fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
      <div class="row">
        <div class="col-md-10">
          <div class="input-group mb-3">
          <div class="input-group-prepend">
            <label class="input-group-text" for="inputGroupSelect01">Attributes</label>
          </div>
          <select class="custom-select" id="attrselect">
            <option value="">Choose attribute...</option>
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
  {{-- <div class="tab-pane fade" id="nav-contact" role="tabpanel" aria-labelledby="nav-contact-tab">...</div> --}}
</div>
 <div class="tab-pane fade" id="usergroup" role="tabpanel" aria-labelledby="contact-tab">
            <label class="mt-2">Select group</label>

              <select class="form-control mt-2" id="exampleFormControlSelect1" name="groupname[]">
                <option value="">Select a group ...</option>
                @forelse($allgroups as $c)
                <option value="{{ $c->groupname }}">{{ $c->groupname }}</option>
                @empty
                  <option value="">No groups available</option>
                @endforelse
              </select>

          
  </div>
</div>
<hr>
<button type="submit" class="btn btn-success">Save Changes</button>
</form>
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