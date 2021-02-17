@extends('layouts.master')
@section('pagetitle')
New Customer
@endsection

@section('content')
<div class="card">
	<div class="card-body">
		<h5>Basic Details</h5><hr>
		@if (session('success'))
		    <div class="alert alert-success">
		        {{ session('success') }}
		    </div>
		@endif
		<form action="{{route('post.newcustomer')}}" method="post">

        	<label>Username</label>
        	<input type="text" name="username" class="form-control @error('username') is-invalid @enderror" placeholder="username" autocomplete="autocomplete" autofocus="autofocus">
        	 @error('username')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        	<label>Password</label>
        	<input type="text" name="cleartextpassword" class="form-control @error('cleartextpassword') is-invalid @enderror" placeholder="password">
        	 @error('cleartextpassword')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        	<div class="form-row mt-2 main">
			    <!-- <label for="exampleFormControlSelect1">Group</label> -->
			    <select class="form-control col-md-10 mt-4" name="radusergroup[]" id="exampleFormControlSelect1">
			      <option value="">Add User to Group</option>
			      @foreach($groups as $rc)
			      	<option value="{{$rc->groupname}}">{{$rc->groupname}}</option>
			      @endforeach
			    </select>&nbsp;
			    <a href="#" class="col-md-1 btn btn-info mt-4 addgroup">add</a>
			</div>
			<div class="form-row mt-2 extra-group"></div>
        	<hr>
        	<h5>Extra Details</h5>
        	<hr>
        	<ul class="nav nav-tabs" id="myTab" role="tablist">
			  <li class="nav-item" role="presentation">
			    <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Personal Info</a>
			  </li>
			  <li class="nav-item" role="presentation">
			    <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">User Limits</a>
			  </li>
			</ul>
			<div class="tab-content" id="myTabContent">
			  <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
			  		<label>Name</label>
		        	<input type="text" name="name" class="form-control @error('name') is-invalid @enderror" placeholder="customer name">
		        	@error('name')
		                <span class="invalid-feedback" role="alert">
		                    <strong>{{ $message }}</strong>
		                </span>
		            @enderror
		        	<label>Email</label>
		        	<input type="email" name="email" class="form-control" placeholder="customer email">
		        	<label>Phone</label>
		        	<input type="digit" name="phone" class="form-control @error('phone') is-invalid @enderror" placeholder="customer phone">
		        	@error('phone')
		                <span class="invalid-feedback" role="alert">
		                    <strong>{{ $message }}</strong>
		                </span>
		            @enderror
			  </div>
			  <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
			  	<br>
			  	<div class="row">
	  			<div class="col-md-10">
	  				<div class="input-group mb-3">
					  <div class="input-group-prepend">
					    <label class="input-group-text" for="inputGroupSelect01">Attributes</label>
					  </div>
					  <select class="custom-select" id="attrselect">
					    <option value="">Choose attribute...</option>
					    @forelse($limitattributes as $l)
					    	<option value="{{ $l->limitname }}">{{ $l->limitname }}</option>
					    @empty
					    	<option value="">No Limits available</option>
					    @endforelse
					  </select>
					</div>
	  			</div>
	  			<div class="col-md-2">
	  				<a href="#" class="btn btn-success add"><i class="fa fa-plus"></i></a>
	  			</div>
	  			
				<hr>
				</div>
				<div class="attrs">
					
				</div>
			  </div>
			</div>
        	
        	<hr>
        	<button class="right btn btn-success" type="submit">Save</button>
        	{{csrf_field()}}
		</form>
	</div>
</div>
@endsection
@section('scripts')
<script type="text/javascript">
	$(document).ready(function(){
		$(".add").click(function(){
			var attributevalue=$("#attrselect").val();
			var attribute="<div class='row col-md-12 mb-3 p-3'><div class='col-md-4'><input name='attribute[]' class='form-control' type='text' value='"+attributevalue+"'></div><div class='col-md-4'><input type='text' name='value[]' class='form-control' placeholder='value'></div><div class='col-md-2'><select class='custom-select' name='op[]'><option value=':='>:=</option><option value='='>=</option></select></div><div class='col-md-2'><select class='custom-select' name='type[]'><option value='reply'>reply</option><option value='check'>check</option></select></div></div>";
			$(".attrs").append(attribute);
		})
		$(".addgroup").click(function(){
			$(".main select").clone().appendTo(".extra-group");
		})
	})
</script>
@endsection