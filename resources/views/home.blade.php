@extends('layouts.app')

@section('app_css')
<link href="{{asset('vendor/collapsible-sticky-sidebar-nav-next/css/perfect-scrollbar.css')}}" rel="stylesheet">
<link href="{{asset('vendor/collapsible-sticky-sidebar-nav-next/css/next-sidebar.css')}}" rel="stylesheet">
<style>
.stay-open {
  display:block ;
}
.enlarge_text{
  font-size: x-large !important;
}
.hidden_object{
    display: none;
}
</style>
@yield('css')
@endsection

@section('content')
    {{--@if(session()->has('success_msg'))
        <div class="alert alert-success">
            {{ session()->get('success_msg') }}
        </div>
    @endif
    @if(session()->has('error_msg'))
        <div class="alert alert-danger">
            {{ session()->get('error_msg') }}
        </div>
    @endif--}}

<div class="sidebar ">
  <div class="sidebar-inner">
    <ul class="sidebar-menu scrollable position-relative pt-3">
      <li id="close_sidebar_btn" class="nav-item dropdown hidden_object pb-3">
        <a  class="sidebar-toggle nav-link " href="#">
          <i class="far fa-times-circle"></i>
        </a>
      </li>
      <li class="nav-item dropdown">
        {{--<a class="nav-link wave-effect" href="{{ route('home') }}">
          <span class="icon-holder">
            <i class="fas fa-home"></i>
          </span>
          <span class="title">{{Auth::user()->school->School_Name}}</span>
        </a>--}}
        <a class="nav-link dropdown-toggle" href="#">
          <span class="icon-holder">
            <i class="fas fa-home"></i>
          </span>
          <span class="title">{{Auth::user()->school->School_Name}}</span>
          <span class="arrow">
            <i class="fas fa-angle-right"></i>
          </span>
        </a>
            @php
            if(preg_match('(basic|system)', Route::currentRouteName()) === 1) {
                $basic_dropdown=true;
            }else{
                $basic_dropdown=false;
            }
            @endphp
            @if($basic_dropdown)
            <ul class="dropdown-menu stay-open">
            @else
            <ul class="dropdown-menu">
            @endif
                <li class="nav-item dropdown">


                    <a class="nav-link dropdown-toggle" href="#">
                    <span><a href="{{route('basic')}}" class="{{ (preg_match('(basic)', Route::currentRouteName()) === 1) ? 'text-info enlarge_text' : '' }}">基本資料</a></span>
                    </a>

                    <a class="nav-link dropdown-toggle" href="#">
                    <span><a href="{{route('system')}}" class="{{ (preg_match('(system)', Route::currentRouteName()) === 1) ? 'text-info enlarge_text' : '' }}">系統設定</a></span>
                    </a>
                </li>
            </ul>


      </li>
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#">
          <span class="icon-holder">
            <i class="fas fa-folder-plus"></i>
          </span>
          <span class="title">班級</span>
          <span class="arrow">
            <i class="fas fa-angle-right"></i>
          </span>
        </a>

        @php
        if(preg_match('(classs.classs|classs.student|batch)', Route::currentRouteName()) === 1) {
            $classs_dropdown=true;
        }else{
            $classs_dropdown=false;
        }
        @endphp
        @if($classs_dropdown)
        <ul class="dropdown-menu stay-open">
        @else
        <ul class="dropdown-menu">
        @endif

          <li class="nav-item dropdown">
            {{--<a class="nav-link dropdown-toggle" href="#">
              <span><a href="#" class="{{ (str_contains(Route::currentRouteName(),'classs.student')) ? 'text-info enlarge_text' : '' }}">學生名單</a></span>
            </a>--}}
            <a class="nav-link dropdown-toggle" href="#">
              <span><a href="{{route('classs.classs')}}" class="{{ (preg_match('(classs.classs|classs.student)', Route::currentRouteName()) === 1) ? 'text-info enlarge_text' : '' }}">班級資料</a></span>
            </a>

            <a class="nav-link dropdown-toggle" href="#">
              <span><a href="{{route('batch')}}" class="{{ (preg_match('(batch)', Route::currentRouteName()) === 1) ? 'text-info enlarge_text' : '' }}">梯次</a></span>
            </a>

            {{--<a class="nav-link dropdown-toggle" href="#">
              <span><a href="{{route('signin')}}" class="{{ (preg_match('(signin)', Route::currentRouteName()) === 1) ? 'text-info enlarge_text' : '' }}">簽到退查詢</a></span>
            </a>--}}
          </li>
        </ul>
      </li>

      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#">
          <span class="icon-holder">
          <i class="fas fa-search"></i>
          </span>
          <span class="title">簽到退查詢</span>
          <span class="arrow">
            <i class="fas fa-angle-right"></i>
          </span>
        </a>
        @php
        if(preg_match('(signin)', Route::currentRouteName()) === 1) {
            $sign_dropdown=true;
        }else{
            $sign_dropdown=false;
        }
        @endphp

        @if($sign_dropdown)
        <ul class="dropdown-menu stay-open">
        @else
        <ul class="dropdown-menu">
        @endif



          <li class="nav-item dropdown">


            <a class="nav-link dropdown-toggle" href="#">
              <span><a href="{{route('signin')}}" class="{{ (preg_match('(signin)', Route::currentRouteName()) === 1) ? 'text-info enlarge_text' : '' }}">查詢</a></span>
            </a>
          </li>
        </ul>



      </li>



      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#">
          <span class="icon-holder">
          <i class="fab fa-line"></i>
          </span>
          <span class="title">LINE@ 串接</span>
          <span class="arrow">
            <i class="fas fa-angle-right"></i>
          </span>
        </a>
        @php
        if(preg_match('(line)', Route::currentRouteName()) === 1) {
            $line_dropdown=true;
        }else{
            $line_dropdown=false;
        }
        @endphp

        @if($line_dropdown)
        <ul class="dropdown-menu stay-open">
        @else
        <ul class="dropdown-menu">
        @endif



          <li class="nav-item dropdown">


            <a class="nav-link dropdown-toggle" href="#">
              <span><a href="{{route('line')}}" class="{{ (preg_match('(line)', Route::currentRouteName()) === 1) ? 'text-info enlarge_text' : '' }}">安親班LINE@</a></span>
            </a>
          </li>
        </ul>



      </li>

      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#">
          <span class="icon-holder">
          <i class="fas fa-comments"></i>
          </span>
          <span class="title">訊息</span>
          <span class="arrow">
            <i class="fas fa-angle-right"></i>
          </span>
        </a>
        @php
        if(preg_match('(message)', Route::currentRouteName()) === 1) {
            $message_dropdown=true;
        }else{
            $message_dropdown=false;
        }
        @endphp

        @if($message_dropdown)
        <ul class="dropdown-menu stay-open">
        @else
        <ul class="dropdown-menu">
        @endif



          <li class="nav-item dropdown">


            <a class="nav-link dropdown-toggle" href="#">
              <span><a href="{{route('message')}}" class="{{ (preg_match('(message)', Route::currentRouteName()) === 1) ? 'text-info enlarge_text' : '' }}">訊息發送</a></span>
            </a>
          </li>
      </ul>
      </li>
    </ul>
  </div>
</div>

<div class="container-wide">
  <nav class="navbar navbar-expand navbar-light my_nav_color">
    <ul class="navbar-nav me-auto">
      <li class="nav-item">
        <a id="sidebar-toggle" class="sidebar-toggle nav-link text-light" href="#">
          <i class="fas fa-bars"></i>
        </a>
      </li>
      <li class="nav-item" >
        <!--<a class="nav-link text-light" href="#" id='nav_title'></a>-->
        <h3 class="nav-link text-light "  id='nav_title'></h3>
      </li>
      <!--<li class="nav-item">
        <a class="nav-link" href="#">Left</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#">Link</a>
      </li>-->
    </ul>

    <ul class="navbar-nav ml-auto">
        <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle text-light" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                <i class="fas fa-user text-light"></i>&nbsp;&nbsp;{{ Auth::user()->name }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
        </li>
    </ul>
  </nav>

    <div class="container py-4">
    <div class="row justify-content-center">
        @if(session()->has('success_msg'))
            <div class="alert alert-info">
                {{ session()->get('success_msg') }}
            </div>
        @endif
        @if(session()->has('error_msg'))
            <div class="alert alert-danger">
                {{ session()->get('error_msg') }}
            </div>
        @endif
        @yield('stage')
    </div>
    </div>



    {{--<div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Dashboard') }}</div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        {{ __('You are logged in!') }}
                    </div>
                </div>
            </div>
        </div>
    </div>--}}

</div>
@endsection

@section('app_js')
<script src="{{asset('vendor/collapsible-sticky-sidebar-nav-next/js/perfect-scrollbar.min.js')}}"></script>
<script src="{{asset('vendor/collapsible-sticky-sidebar-nav-next/js/next-sidebar.js')}}"></script>
<script>
function change_toggle(){
    const max_width=991;
    if(window.innerWidth<=max_width){
        $('#close_sidebar_btn').show();

    }else{
        $('#close_sidebar_btn').hide();

    }
}
change_toggle();
var toggle=document.getElementById('sidebar-toggle');
toggle.addEventListener('click', function(event){
    change_toggle();
});
window.addEventListener('resize', function(event){
    change_toggle();
});
</script>
@yield('js')
@endsection
