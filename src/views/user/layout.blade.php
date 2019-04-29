<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Aimstar::</title>

        <link rel="stylesheet" href="{{asset('fonts/fonts.css')}}" type="text/css" media="all">
        <link rel="stylesheet" type="text/css" href="{{mix('css/app.css')}}">

        <!-- Bootstrap core CSS -->
        <link type="text/css"  href="{{mix('css/bootstrap.min.css')}}" rel="stylesheet">
        <link type="text/css"  href="{{mix('css/all.min.css')}}" rel="stylesheet">

        <!-- Custom styles for this template -->
        <link type="text/css"  href="{{mix('css/styles.css')}}" rel="stylesheet">

        <script type="text/javascript" src="{{asset('front/js/jquery-2.1.4.min.js')}}"></script>

        <!-- Pre load jquery -->
        <script type="text/javascript" src="{{mix('js/polyfil.js')}}"></script>
        <script src="{{mix('js/jquery-3.2.1.slim.min.js')}}"></script>

        @include('global.facebook')

    </head>
    <body>
        <div id="app">
            <header-component ref="header-component"></header-component>
            <div  class="d-flex flex-container">
                <menu-component ref="menu-component"></menu-component>
                <div class="home scrollable scrollable-page">
                    <app ref="app"></app>
                    <div class="affiliateContent"> @yield('content')</div>
                </div>
                <!-- <chat-component ref="chat-component"></chat-component> -->
            </div>
        </div>
        <script type="text/javascript" src="{{mix('js/app.js')}}"></script>
        <script type="text/javascript" src="{{mix('js/scripts.js')}}"></script>
        <!-- Placed at the end of the document so the pages load faster -->
        <script type="text/javascript"  src="{{mix('js/popper.min.js')}}"></script>
        <script type="text/javascript"  src="{{mix('js/bootstrap.min.js')}}"></script>
        <script>
            MIX_LAUNCHER_URL="{{env('MIX_LAUNCHER_URL')}}";
        </script>
    </body>
</html>
