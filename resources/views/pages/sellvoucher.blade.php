@extends('layouts.master')
@section('content')
@foreach($voucher as $key=> $v)
 <div class="row no-gutters border rounded overflow-hidden flex-md-row mb-4 shadow-sm h-md-250 position-relative">
        <div class="col p-4 d-flex flex-column position-static">
          <strong class="d-inline-block mb-2 text-success">Kes. {{ $v->cost }}</strong>
          <h3 class="mb-0">{{ $v->plan }}</h3>
          <div class="mb-1 text-muted">Voucher no. {{ $v->serialnumber }}</div>
          <p class="mb-auto">
          	<li class="list-group-item"><b>Username:</b> {{ $v->username }}</li>
			<li class="list-group-item"><b>Password:</b> {{ $v->password }}</li>
			<input type="hidden" name="id" id="id" value="{{ $v->id }}">
			    <input type="hidden" name="plan" id="plan" value="{{ $v->plan }}">
			    <input type="hidden" name="cost" id="cost" value="{{ $v->cost }}">
			    <input type="hidden" name="serialnumber" id="serialnumber" value="{{ $v->serialnumber }}">
			    <input type="hidden" name="username" id="username" value="{{ $v->username }}">
          </p>
            @csrf
          <a href="#" class="btn btn-md btn-primary float-right mark"><i class="fas fa-shopping-cart"></i> mark sold</a>
        </div>
</div>
@endforeach
@endsection
@section('scripts')
<script type="text/javascript">
	$(document).ready(function(){
		$(".mark").click(function(){
			var id=$("#id").val();
			var plan=$("#plan").val();
			var cost=$("#cost").val();
			var username=$("#username").val();
			var serialnumber=$("#serialnumber").val();
			var _token=$("input[name='_token']").val();
			var req=$.ajax({
				method:"post",
				url:"{{ route('markvouchersold') }}",
				data:{id,id,_token:_token,plan:plan,cost:cost,serialnumber:serialnumber,username:username},
			})
			req.done(function(result){
				var url="{{ route('allvouchers') }}";
				if(result=="success"){
					alert("success");
					window.location.replace(url);
				}else{
					alert(result);
				}
				
			})
		})
	})
</script>
@endsection