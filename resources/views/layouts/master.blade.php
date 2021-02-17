<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <!-- <script src="{{ asset('js/app.js') }}" defer></script> -->
    <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js" integrity="sha512-AA1Bzp5Q0K1KanKKmvN/4d3IRKVlv9PYgwFPvm32nPO6QS8yH1HO7LbgB1pgiOxPtfeg5zEn2ba64MUcqJx6CA==" crossorigin="anonymous"></script> -->
    <!-- Fonts -->
    <!-- <link href="{{ asset('css/argon.css') }}" rel="stylesheet"> -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link rel="stylesheet" href="{{asset('plugins/fontawesome-free/css/all.min.css')}}">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="{{asset('plugins/overlayScrollbars/css/OverlayScrollbars.min.css')}}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{asset('css/app.css')}}">
  <!-- <link rel="stylesheet" href="{{asset('css/argon.css')}}"> -->
  <link rel="stylesheet" href="{{asset('dist/css/adminlte.min.css')}}">


  <link rel="stylesheet" href="{{asset('css/custom.css')}}">

    <!-- Styles -->
    <!-- <link href="{{ asset('css/app.css') }}" rel="stylesheet"> -->
    <style type="text/css">
 #users ul{
    list-style: none;
    background-color: white;
    border: solid 1px black;
    padding: 10px;
}
#users ul li{
    padding: 5px;
    list-style: none;
    text-decoration: none;
}
#users{
    background-color: #fff;
    margin-top: 0px;
    display: none;
}
#users p:hover{
    background-color: #000;
    color: white;
    padding: 4px;
   
}
   </style>  
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">

  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="{{route('home')}}" class="nav-link">Home</a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="#" data-toggle="modal" data-target="#exampleModal2" class="nav-link">Data bundle config</a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="#" data-toggle="modal" data-target="#exampleModal" class="nav-link">Contact</a>
      </li>
    </ul>
    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <!-- Notifications Dropdown Menu -->
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
          <i class="far fa-bell"></i>
          <span class="badge badge-warning navbar-badge">{{ auth()->user()->unreadNotifications->count() }}</span>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <span class="dropdown-header">{{ auth()->user()->unreadNotifications->count() }} Notifications</span>
          <div class="dropdown-divider"></div>
          @forelse(auth()->user()->unreadNotifications as $notification)
            <a href="{{route('specificcustomer',['username'=>$notification->data['username']])}}" class="dropdown-item">
            <i class="fas fa-bell mr-2"></i>
                 {{ $notification->data['username'] }}&nbsp;{{ $notification->data['message'] }}
            <span class="float-right text-muted text-sm">{{$notification->created_at->diffForHumans()}}</span>
          </a> 
          @empty
          <a href="#" class="dropdown-item"><i class="fas fa-bell-slash"></i>&nbsp;No notifications</a>
          <br>
              <div class="dropdown-divider"></div>   
            @endforelse
            <br>
          <div class="dropdown-divider"></div>
          @if(auth()->user()->unreadNotifications->count() >0)
          <a href="{{route('mark')}}" class="dropdown-item dropdown-footer">Mark All Notifications Read</a>
          @endif
        </div>
      </li>
      <li class="nav-item">
        <a class="nav-link" role="button" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();" data-toggle="tooltip" data-placement="top" title="Logout">
         <i class="fas fa-sign-out-alt"></i>
        </a>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
        </form>
      </li>
    </ul>
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-light-info elevation-4">
    <!-- Brand Logo -->
    <a href="#" class="brand-link">
      <span class="brand-text font-weight-light">DestroTechs ltd</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="{{asset('images/user.jpg')}}" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="{{route('home')}}" class="d-block">{{Auth::user()->name}}</a>
        </div>
      </div>

      <!-- SidebarSearch Form -->
      <!-- <div class="form-inline">
        <div class="input-group" data-widget="sidebar-search">
          <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
          <div class="input-group-append">
            <button class="btn btn-sidebar">
              <i class="fas fa-search fa-fw"></i>
            </button>
          </div>
        </div>
      </div> -->

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column clearfix" data-widget="treeview" role="menu" data-accordion="false">
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-users"></i>
              <p>
                Customers
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{route('newcustomer')}}" class="nav-link">
                  <i class="fas fa-plus nav-icon"></i>
                  <p>New Customer</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{route('auto.customer')}}" class="nav-link">
                  <i class="fas fa-plus nav-icon"></i>
                  <p>Auto Customer</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{route('allcustomers')}}" class="nav-link">
                  <i class="far fa-user nav-icon"></i>
                  <p>List Customers</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{route('geteditcustomer')}}" class="nav-link">
                  <i class="far fa-edit nav-icon"></i>
                  <p>Edit Customer</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{route('bundlebalance')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Bundle Balance</p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-globe"></i>
              <p>
                Networks(Nas)
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{route('newnas')}}" class="nav-link">
                  <i class="fas fa-plus nav-icon"></i>
                  <p>New Nas</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{route('listnas')}}" class="nav-link">
                  <i class="far fa-bars nav-icon"></i>
                  <p>List Nas</p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-ban"></i>
              <p>
                Groups & Limits
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{route('userlimitgroups')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Limit Groups</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{route('newlimitattr')}}" class="nav-link">
                  <i class="fas fa-plus nav-icon"></i>
                  <p>Add Limit Attribute</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{route('userlimits')}}" class="nav-link">
                  <i class="fas fa-ban nav-icon"></i>
                  <p>User Limits</p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-envelope"></i>
              <p>
                Messages
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ route('messagenew') }}" class="nav-link">
                  <i class="fa fa-plus-circle nav-icon"></i>
                  <p>New Message</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('messageinbox') }}" class="nav-link">
                  <i class="fa fa-inbox nav-icon"></i>
                  <p>Inbox</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{route('messagesent')}}" class="nav-link">
                  <i class="fas fa-id-card nav-icon"></i>
                  <p>Sent</p>
                </a>
              </li>
              
              
              
              
            </ul>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-money">&dollar;</i>
              <p>
                Payments
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{route('allpayments')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>All Payments</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{route('paymentgraphs')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Graphs</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{route('initiatepayment')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Initiate payment</p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-hammer"></i>
              <p>
               Maintenance
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{route('get.cleanstale')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Clean Stale Conns</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{route('customerconnectivity')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Test Connectivity</p>
                </a>
              </li>
               <li class="nav-item">
                <a href="{{route('disconnectcustomer')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Disconnect Customer</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{route('deleteacctrec')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Delete Accounting Rec</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{route('removeuser')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Remove Customer</p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-bars"></i>
              <p>
                Reports
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{route('onlineusers')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Online Customers</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{route('lastconnatt')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Last Conection Attempts</p>
                </a>
              </li>
            </ul>
          </li>
           <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-edit"></i>
              <p>
                Accounting
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{route('useraccounting')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>User Accounting</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{route('ipaccounting')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>IP Accounting</p>
                </a>
              </li>
                <li class="nav-item">
                <a href="{{route('nasaccounting')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Nas Accounting</p>
                </a>
              </li>
               
            </ul>
          </li>
          <li class="nav-item">
            <a href="{{route('plans')}}" class="nav-link">
              <i class="fas fa-chart-pie nav-icon"></i>
              <p>Billing Plans</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{route('operators')}}" class="nav-link">
              <i class="fas fa-code nav-icon"></i>
              <p>Administrators</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{route('vouchers')}}" class="nav-link">
              <i class="fas fa-plus nav-icon"></i>
              <p>Tickets</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{route('allvouchers')}}" class="nav-link">
              <i class="fas fa-certificate nav-icon"></i>
              <p>Available Tickets</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{route('servicestatus')}}" class="nav-link">
              <i class="fas fa-check-circle nav-icon"></i>
              <p>Services Status</p>
            </a>
          </li>
          <!-- <li class="nav-item">
            <a href="{{route('sendsms')}}" class="nav-link">
              <i class="fas fa-comments nav-icon"></i>
              <p>Send SMS</p>
            </a>
          </li> -->
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper bg-light">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-.1 bg-light p-2">
          <div class="col-sm-6">
            <h4 class="m-0 text-dark">@yield('pagetitle')</h4>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content p-2">
      <div class="container-fluid">
       @yield('content')
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
    <div class="p-3">
      <h5>Title</h5>
      <p>Sidebar content</p>
    </div>
  </aside>
  <!-- /.control-sidebar -->
  <!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Developer Contacts</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="row offset-1 col-md-11 d-flex">
            <center>
             <div class="btn-group mr-2" role="group" aria-label="First group">
                <a href="https://www.facebook.com/morris.destro/" target="_blank" class="btn btn-primary"><i class="fab fa-facebook-f fa-3x"></i></a>
                <a href="mailto:morrisdestro@gmail.com" class="btn btn-danger"><i class="fab fa-google fa-3x"></i></a>
                <a href="https://twitter.com/destromorris2" target="_blank" class="btn btn-secondary"><i class="fab fa-twitter fa-3x"></i></a>
                <a href="https://www.linkedin.com/in/morris-mbae-7b7654194/" target="_blank" class="btn btn-info"><i class="fab fa-linkedin fa-3x"></i></a>
              </div>
          </center>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<!-- Modal -->
<div class="modal fade" id="exampleModal2" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Request Developer</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
            <center>
             <div class="btn-group mr-2" role="group" aria-label="First group">
                <a href="https://wa.me/254701530647?text=Hello destro, i need configuration details for freeradius in order to start selling internet in terms of bundles(mbs)." target="_blank" class="btn btn-success"><i class="fab fa-whatsapp fa-4x"></i></a>
              </div>
          </center>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
  <!-- Main Footer -->
  <footer class="main-footer">
    <!-- To the right -->
    <!-- Default to the left -->
    <strong>Copyright &copy; <?php echo date('Y');?> <a href="#">DestroTecths</a>.</strong> All rights reserved.
  </footer>
</div>
    <!-- REQUIRED SCRIPTS -->
<!-- jQuery -->
<script src="{{asset('plugins/jquery/jquery.min.js')}}"></script>
<!-- Bootstrap -->
<script src="{{asset('plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<!-- overlayScrollbars -->
<script src="{{asset('plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js')}}"></script>
<!-- AdminLTE App -->
<script src="{{asset('dist/js/adminlte.js')}}"></script>

<!-- PAGE PLUGINS -->
<!-- jQuery Mapael -->
<script src="{{asset('plugins/jquery-mousewheel/jquery.mousewheel.js')}}"></script>
<script src="{{asset('plugins/raphael/raphael.min.js')}}"></script>
<script src="{{asset('plugins/jquery-mapael/jquery.mapael.min.js')}}"></script>
<script src="{{asset('plugins/jquery-mapael/maps/usa_states.min.js')}}"></script>
<!-- ChartJS -->
<script src="{{asset('plugins/chart.js/Chart.min.js')}}"></script>

<!-- AdminLTE for demo purposes -->
<script src="{{asset('dist/js/demo.js')}}"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="{{asset('dist/js/pages/dashboard2.js')}}"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.3/dist/Chart.min.js"></script>
<script type="text/javascript" src="{{asset('js/custom.js')}}"></script>
@yield('scripts')
 @include('sweetalert::alert')

</body>
</html>
