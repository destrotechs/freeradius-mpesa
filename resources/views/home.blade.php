@extends('layouts.master')

@section('pagetitle')

@endsection
@section('content')
      <div class="container-fluid">
        <!-- Info boxes -->
        <div class="row">
          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box">
              <span class="info-box-icon bg-info elevation-1"><i class="fas fa-cog"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">CPU Traffic</span>
                <span class="info-box-number">
                  10
                  <small>%</small>
                </span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
              <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-wifi"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Online Users</span>
                <span class="info-box-number">{{ $onlineusers }}</span>
              </div>
              <!-- /.info-box-content -->
              <a href="{{ route('onlineusers') }}"><i class="fa fa-eye"></i></a>
            </div>
            <!-- /.info-box -->

          </div>
          <!-- /.col -->

          <!-- fix for small devices only -->
          <div class="clearfix hidden-md-up"></div>

          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
              <span class="info-box-icon bg-success elevation-1"><i class="fas fa-shopping-cart"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Total Sales</span>
                <span class="info-box-number">Kes. {{ $sales }}</span>
              </div>
              <!-- /.info-box-content -->
              <a href="{{ route('allpayments') }}"><i class="fa fa-eye"></i></a>
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
              <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-users"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">New Members</span>
                <span class="info-box-number">{{ $customers }}</span>
              </div>
              <!-- /.info-box-content -->
              <a href="{{ route('allcustomers') }}"><i class="fa fa-eye"></i></a>
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
        <hr>
        {{-- <div class="row"><div class="col-md-12">{!! $usersChart->container() !!}</div></div> --}}
        <div class="row">
          <div class="col-md-4">
            <div class="card w-auto">
              <div class="card-header bg-info text-white p-2">
                <b>Devices(NAS)</b>
              </div>
              <ul class="list-group list-group-flush">
                @forelse($nas as $n)
                  <li class="list-group-item"><b>{{ $n->nasname }}</b><span class="float-right badge badge-info">{{ $n->shortname }}</span></li>
                  
                @empty
                  <li class="list-group-item bg-danger">No nas available</li>
                @endforelse
              </ul>
            </div>
          </div>
          
          <div class="col-md-8">
            <div class="card w-auto">
              <div class="card-header bg-warning text-white p-2">
                <b>Plan Purchases</b>
              </div>
              <div class="card-body">

                {!! $purchaseChart->container() !!}
              </div>
            </div>
          </div>
        </div>

</div>
@endsection
@section('scripts')
{!!$usersChart->script()!!}
{!! $purchaseChart->script() !!}
@endsection
