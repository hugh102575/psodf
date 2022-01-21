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
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <link href="{{asset('vendor/fontawesome-free-5.15.4-web/css/all.css')}}" rel="stylesheet">
<style>
    .my_nav_color{
        background-color:  #6B5B95 !important;
    }
    .my_nav_text{
        color:  #6B5B95 !important;
    }
    .hidden_object{
        display: none;
    }
    .my_gray{
        //background-color:  #f5f5f5;
    }

</style>
@yield('app_css')
</head>
<body class="app">
    <div id="app" class="my_gray">
        <nav class="navbar navbar-expand-md navbar-light my_nav_color shadow-sm">
            <div class="container">
                <div class="navbar-brand text-light" >
                安心學員關懷系統 - 管理員
                </div>

                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>
    
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                    @if(session()->get('admin'))
                            <li class="nav-item dropdown">
                                
                                    <form id="admin-logout-form" action="{{ route('admin.logout') }}" method="POST" class="" onsubmit="return confirm('確定要登出嗎?');">
                                        @csrf
                                        {{--<a class="dropdown-item text-light my_nav_color" href="{{ route('admin.logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('admin-logout-form').submit();" >
                                        {{ __('Logout') }}
                                    </a>--}}
                                        <button class="btn text-light my_nav_color " type="submit">{{ __('Logout') }}</button>
                                    </form>
                            </li>
                    @endif
                    </ul>
                </div>
            </div>
        </nav>


        <main class="py-5" id="main_content">

            @yield('content')
        </main>
    </div>


    <script src="{{ asset('js/app.js') }}"></script>

    <!-- fontawesome -->
    <script src="https://kit.fontawesome.com/6fa6feb997.js" crossorigin="anonymous"></script>

    <script src="{{asset('vendor/fontawesome-free-5.15.4-web/js/all.js')}}"></script>
    @yield('app_js')
</body>
</html>

