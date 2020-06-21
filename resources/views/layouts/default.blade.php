<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('font-awesome/css/font-awesome.css') }}" rel="stylesheet">
    <link href="{{ asset('utls/css/argon.css') }}" rel="stylesheet">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/custom.css') }}" rel="stylesheet">
@yield('styles')

</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-md-12 mt-3 d-flex justify-content-center">
                <a href="{{ route('user.index') }}">
                    <img src="{{ asset('images/2.png') }}" height="100" width="100">
                </a>
            </div>
          </div>
          <div class="row">
            <div class="col-md-12 mt-2">
               <nav class="navbar navbar-expand-lg navbar-light bg-light shadow-sm">
                 @if(isset(Auth::user()->username))
                  <a class="navbar-brand" href="{{ route('home') }}"><span class="fa fa-home fa-2x"></span></a>
                  @else
                  <a class="navbar-brand" href="{{ route('user.index') }}"><span class="fa fa-home fa-2x"></span></a>
                  @endif
                  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                  </button>
                  <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav mr-auto">
                      <!-- <li class="nav-item active">
                        <a class="btn btn-light" href="#">Home <span class="sr-only">(current)</span></a>
                      </li> -->
                      
                    </ul>
                    <ul class="navbar-nav ml-auto">
                          
                          <li class="nav-item">
                            <a class="nav-link" href="{{ route('user.balance') }}"><i class="fa fa-search"></i> check balance</a>
                          </li>
                          @if(!isset(Auth::user()->username))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('user.signup') }}"><i class="fa fa-user"></i> Sign up</a>
                          </li>

                          <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}"><i class="fa fa-sign-in"></i> Sign in</a>
                          </li>
                          <li class="nav-item">
                            <a class="nav-link" href="{{ route('user.credentials') }}"><i class="fa fa-search"></i> Get Credentials</a>
                          </li>
                          @else
                          <li class="nav-item">
                            <a class="nav-link" href="{{ route('user.changephone') }}"><i class="fa fa-phone"></i> Change Phone</a>
                          </li>
                          <li class="nav-item">
                            <a class="nav-link" href="{{ route('user.transactions') }}"><i class="fa fa-eye"></i> Customer Transactions</a>
                          </li>
                          <li class="nav-item">
                            <a class="nav-link" href="{{ route('user.allplans') }}"><i class="fa fa-eye"></i> See Bundle Plans</a>
                          </li>
                          
                          <li class="nav-item">
                            <a class="nav-link" href="{{ route('user.credentials') }}"><i class="fa fa-file"></i> Purchase Bundle Plan</a>
                          </li>
                          <li class="nav-item">
                          <div class="dropdown">
                              <a class="nav-link dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                {{ Auth::user()->username }}
                              </a>

                              <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                <a class="dropdown-item" href="{{ route('customer.logout') }}">logout</a>
                              </div>
                            </div>
                          </li>
                            @endif
                    </ul>
                  </div>
                </nav>
            </div>
        </div>
<hr>
        <main class="py-4">
            @yield('content')
        </main>
    </div>
    <footer class="footer mt-5 py-3">
      <div class="container">
        <span class="text-muted d-flex justify-content-center"><a href="https://www.hewanet.co.ke" target="_blank">HewaNet</a></span><hr>
        <span class="text-muted d-flex justify-content-center"><small><a href = "mailto: morrisdestro@gmail.com?subject=Inquiry">contact developer</a></small></span>
      </div>
    </footer>
    </div>
    <script src="{{ asset('js/app.js') }}" type="text/javascript"></script>
    <script src="{{ asset('utls/js/argon.js') }}" type="text/javascript"></script>
    @include('sweetalert::alert')
    @yield('scripts')

</body>
</html>