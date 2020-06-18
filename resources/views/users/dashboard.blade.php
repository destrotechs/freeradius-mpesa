@extends('layouts.default')
@section('content')
<h4>Dashboard</h4>
<hr>
<div class="my-3 p-3 bg-white rounded shadow-sm">
<div class="media">
  <img src="{{ asset('images/8.png') }}" class="mr-3" alt="...">
  <div class="media-body" style="font-size: 110%;">
    <h3 class="mt-0">Welcome {{ Auth::user()->name }}</h3>
    We are doing our best to make sure we are keeping you connected. HewaNet offers Home WiFi also. Feel free to <a href="#">Contact us</a> for any enquiries.
    <hr>
    <strong>Username: </strong>{{ Auth::user()->username }}<br>
    <strong>Password: </strong>{{ Auth::user()->cleartextpassword }}
  </div>
</div>
<div class="media text-muted pt-3 border-top">
      <p class="media-body p-3 border-bottom border-gray">
        <strong class="d-block text-gray-dark"><h4>How it Works</h4></strong><br>
        Internet is available only on our hotspot areas. At any place you locate Hewanet WiFi hotspot, then you can purchase a plan and connect to access internet. if you have and existing active bundle plan you can connect to any of our WiFi hotspots with the existing username and password.
        
      </p>
    </div>
<small class="d-block text-right mt-1">
      <a href="#">All updates</a>
    </small>
</div>
@endsection