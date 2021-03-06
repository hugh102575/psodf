@extends('layouts.app')

@section('app_css')
<link href="{{asset('vendor/collapsible-sticky-sidebar-nav-next/css/perfect-scrollbar.css')}}" rel="stylesheet">
<link href="{{asset('vendor/collapsible-sticky-sidebar-nav-next/css/next-sidebar.css')}}" rel="stylesheet">
<style>
  body {

background-image: url("{{ asset('/img/dexway-classroom-companion-ingles-uk.jpg') }}");
background-repeat: no-repeat;
background-position:center;
background-attachment: fixed; 
background-size: cover;
background-color: rgba(255, 255, 255, 0.5);
background-blend-mode: overlay;

}
.stay-open {
  display:block ;
}
.enlarge_text{
  font-size: x-large !important;
}
.hidden_object{
    display: none;
}
.aaa{
  //background-color:  #D3D3D3 !important;
}
.astext {
    background:none;
    border:none;
    margin:0;
    padding:0;
    cursor: pointer;
}
.card{
    border-radius: 3%;
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

<div class="sidebar bg-dark">
  <div class="sidebar-inner">
    <ul class="sidebar-menu scrollable position-relative pt-3">
      <li id="close_sidebar_btn" class="nav-item dropdown hidden_object mb-3">
        <a  class="sidebar-toggle nav-link " href="#">
          <i class="far fa-times-circle"></i>
        </a>
        <hr class="bg-secondary">
      </li>

      {{--<li class="nav-item dropdown mb-3">
        <a class="nav-link wave-effect" href="{{ route('home') }}">
          <span class="icon-holder">
            <i class="fas fa-home"></i>
          </span>
          <span class="title">{{Auth::user()->school->School_Name}}</span>
        </a>
      </li>--}}




      @if(str_contains(Auth::user()->role->authority, 'classs'))
      <li class="nav-item dropdown mb-3">
        <a class="nav-link dropdown-toggle" href="#">
          <span class="icon-holder">
            <i class="fas fa-folder-plus "></i>
          </span>
          <span class="title">??????</span>
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
        <ul class="dropdown-menu stay-open aaa">
        @else
        <ul class="dropdown-menu aaa">
        @endif

          <li class="nav-item dropdown  border-left rounded border-info">
            {{--<a class="nav-link dropdown-toggle" href="#">
              <span><a href="#" class="{{ (str_contains(Route::currentRouteName(),'classs.student')) ? 'my_nav_color enlarge_text ' : '' }}">????????????</a></span>
            </a>--}}
            <a class="nav-link dropdown-toggle" href="#">
              <span><a href="{{route('classs.classs')}}" class="{{ (preg_match('(classs.classs|classs.student)', Route::currentRouteName()) === 1) ? 'bg-primary  ' : '' }}">????????????</a></span>
            </a>

            <a class="nav-link dropdown-toggle" href="#">
              <span><a href="{{route('batch')}}" class="{{ (preg_match('(batch)', Route::currentRouteName()) === 1) ? 'bg-primary  ' : '' }}">??????</a></span>
            </a>

            {{--<a class="nav-link dropdown-toggle" href="#">
              <span><a href="{{route('signin')}}" class="{{ (preg_match('(signin)', Route::currentRouteName()) === 1) ? 'my_nav_color enlarge_text ' : '' }}">???????????????</a></span>
            </a>--}}
          </li>
        </ul>
        <hr class="bg-secondary">
      </li>
      @endif

      @if(str_contains(Auth::user()->role->authority, 'sign'))
      <li class="nav-item dropdown mb-3">
        <a class="nav-link dropdown-toggle" href="#">
          <span class="icon-holder">
          <i class="fas fa-search "></i>
          </span>
          <span class="title">???????????????</span>
          <span class="arrow">
            <i class="fas fa-angle-right"></i>
          </span>
        </a>
        @php
        if(preg_match('(signin.signin|signin.overview|signin.result)', Route::currentRouteName()) === 1) {
            $sign_dropdown=true;
        }else{
            $sign_dropdown=false;
        }
        @endphp

        @if($sign_dropdown)
        <ul class="dropdown-menu stay-open aaa">
        @else
        <ul class="dropdown-menu aaa">
        @endif



          <li class="nav-item dropdown border-left rounded border-info">

            <a class="nav-link dropdown-toggle" href="#">
              <span><a href="{{route('signin.overview')}}" class="{{ (preg_match('(signin.overview)', Route::currentRouteName()) === 1) ? 'bg-primary  ' : '' }}">??????</a></span>
            </a>
            <a class="nav-link dropdown-toggle" href="#">
              <span><a href="{{route('signin.signin')}}" class="{{ (preg_match('(signin.signin|signin.result)', Route::currentRouteName()) === 1) ? 'bg-primary  ' : '' }}">??????</a></span>
            </a>
          </li>
        </ul>


        <hr class="bg-secondary">
      </li>
      @endif




      @if(str_contains(Auth::user()->role->authority, 'message'))
      <li class="nav-item dropdown mb-3">
        <a class="nav-link dropdown-toggle" href="#">
          <span class="icon-holder">
          <i class="fas fa-comments "></i>
          </span>
          <span class="title">??????</span>
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
        <ul class="dropdown-menu stay-open aaa">
        @else
        <ul class="dropdown-menu aaa">
        @endif



          <li class="nav-item dropdown border-left rounded border-info">


            <a class="nav-link dropdown-toggle" href="#">
              <span><a href="{{route('message')}}" class="{{ (preg_match('(message)', Route::currentRouteName()) === 1) ? 'bg-primary  ' : '' }}">????????????</a></span>
            </a>
          </li>
        </ul>
        <hr class="bg-secondary">
      </li>
      @endif

      @if(str_contains(Auth::user()->role->authority, 'line'))
      <li class="nav-item dropdown mb-3">
        <a class="nav-link dropdown-toggle" href="#">
          <span class="icon-holder">
          <i class="fab fa-line "></i>
          </span>
          <span class="title">LINE??????</span>
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
        <ul class="dropdown-menu stay-open aaa">
        @else
        <ul class="dropdown-menu aaa">
        @endif



          <li class="nav-item dropdown border-left rounded border-info">


            <a class="nav-link dropdown-toggle" href="#">
              <span><a href="{{route('line')}}" class="{{ (preg_match('(line)', Route::currentRouteName()) === 1) ? 'bg-primary  ' : '' }}">?????????LINE??????</a></span>
            </a>
          </li>
        </ul>


        <hr class="bg-secondary">
      </li>
      @endif

      @if(str_contains(Auth::user()->role->authority, 'sys'))
      <li class="nav-item dropdown mb-3">
        {{--<a class="nav-link wave-effect" href="{{ route('home') }}">
          <span class="icon-holder">
            <i class="fas fa-home"></i>
          </span>
          <span class="title">{{Auth::user()->school->School_Name}}</span>
        </a>--}}
        <a class="nav-link dropdown-toggle" href="#">
          <span class="icon-holder">
            {{--<i class="fas fa-home"></i>--}}
            <i class="fas fa-cog "></i>
          </span>
          <span class="title">??????</span>
          <span class="arrow">
            <i class="fas fa-angle-right"></i>
          </span>
        </a>
            @php
            if(preg_match('(basic|system)', Route::currentRouteName()) === 1) {
                $sys_dropdown=true;
            }else{
                $sys_dropdown=false;
            }
            @endphp
            @if($sys_dropdown)
            <ul class="dropdown-menu stay-open aaa">
            @else
            <ul class="dropdown-menu aaa">
            @endif
                <li class="nav-item dropdown border-left rounded border-info">


                    <a class="nav-link dropdown-toggle" href="#">
                    <span><a href="{{route('basic')}}" class="{{ (preg_match('(basic)', Route::currentRouteName()) === 1) ? 'bg-primary  ' : ' ' }}">????????????</a></span>
                    </a>

                    <a class="nav-link dropdown-toggle" href="#">
                    <span><a href="{{route('system')}}" class="{{ (preg_match('(system)', Route::currentRouteName()) === 1) ? 'bg-primary  ' : ' ' }}">????????????</a></span>
                    </a>
                </li>
            </ul>

            <hr class="bg-secondary">
      </li>
      @endif

      @if(str_contains(Auth::user()->role->authority, 'account'))
      <li class="nav-item dropdown mb-3">
        <a class="nav-link dropdown-toggle" href="#">
          <span class="icon-holder">
            <i class="fas fa-user-circle "></i>
          </span>
          <span class="title">????????????</span>
          <span class="arrow">
            <i class="fas fa-angle-right"></i>
          </span>
        </a>
          @php
          if(preg_match('(role|role.create|role.edit|account|account.create|account.edit)', Route::currentRouteName()) === 1) {
              $account_dropdown=true;
          }else{
              $account_dropdown=false;
          }
          @endphp
          @if($account_dropdown)
          <ul class="dropdown-menu stay-open aaa">
          @else
          <ul class="dropdown-menu aaa">
          @endif
            <li class="nav-item dropdown border-left rounded border-info">


                    <a class="nav-link dropdown-toggle" href="#">
                    <span><a href="{{route('account')}}" class="{{ (preg_match('(account|account.create|account.edit)', Route::currentRouteName()) === 1) ? 'bg-primary  ' : ' ' }}">????????????</a></span>
                    </a>

                    <a class="nav-link dropdown-toggle" href="#">
                    <span><a href="{{route('role')}}" class="{{ (preg_match('(role|role.create|role.edit)', Route::currentRouteName()) === 1) ? 'bg-primary  ' : ' ' }}">????????????</a></span>
                    </a>
                </li>
            </ul>


      </li>
      @endif

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
                                {{--<i class="fas fa-user text-light"></i>&nbsp;&nbsp;{{ Auth::user()->name }}--}}
                                <div class="text-center small bg-primary mb-1 ">????????????:&nbsp;&nbsp;{{Auth::user()->school->PID}}</div>{{Auth::user()->school->School_Name}}&nbsp;&nbsp;/&nbsp;&nbsp;<i class="fas fa-user text-light"></i>&nbsp;&nbsp;{{ Auth::user()->name }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{route('home')}}">
                                       ?????????
                                    </a>   
                                    <a class="dropdown-item" href="{{route('self_profile')}}">
                                       ??????????????????
                                    </a>
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
            <div class="alert alert-info" name="alert_msg">
                {{ session()->get('success_msg') }}
            </div>
        @endif
        @if(session()->has('error_msg'))
            <div class="alert alert-danger" name="alert_msg">
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
$.ajaxSetup({
  headers: {
    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
  }
});
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
$("document").ready(function(){
    setTimeout(function(){
        $("[name='alert_msg']").hide();
    }, 5000 );
});

</script>
@yield('js')
@endsection

