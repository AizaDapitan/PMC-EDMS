<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <link href="google.css" rel="stylesheet" type="text/css"/>
    @yield('pageCSS')

    <style type="text/css">

        .popover-content,
        .popover-title { color: black; }

        .page-header.navbar { background-color: #1f1f1f; }

        #dashboard_div {padding-left:340px; }
        #dashboard_div table { border-collapse:separate; }
        #dashboard_div td, th {
            margin:0;
            white-space:nowrap;
        }

        #dashboard_div   .headcol {
            position:absolute;
            width:28em;
            left:28px;
            top:auto;
            border-right: 0px none;
            background-color: white;
        }

        #dashboard_div    .headcol:before {content:'';}
        #dashboard_div    .long { background:yellow; letter-spacing:1em; }

    </style>

</head>
<body>

    <div class="page-header-fixed page-quick-sidebar-over-content page-full-width">
        
        @include('layouts.header')

        <div class="page-container">

            <div class="page-content-wrapper">

                <div class="page-content">

                    @yield('content')

                </div>


            </div>

        </div>

    </div>

    @include('layouts.footer')
   
    @yield('pageJS')

</body>
</html>
