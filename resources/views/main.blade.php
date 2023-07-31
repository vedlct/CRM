<!DOCTYPE html>
<html lang="en">


<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" type="image/png" sizes="16x16" href="{{url('img/logo/TCL_logo.png')}}">

    <title>Client Relationship Management</title>

    @yield('header')

    <link href="{{url('assets/plugins/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet">

    <link href="{{url('css/style.css')}}" rel="stylesheet">
    <link href="{{url('css/colors/blue.css')}}" id="theme" rel="stylesheet">
    <link rel="stylesheet" href="{{url('date/date-picker.css')}}">
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <!--<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">-->
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    {{--<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">--}}
    <script src="https://unpkg.com/gijgo@1.9.13/js/gijgo.min.js" type="text/javascript"></script>
    <link href="https://unpkg.com/gijgo@1.9.13/css/gijgo.min.css" rel="stylesheet" type="text/css" />
    <![endif]-->

</head>

<body class="fix-header fix-sidebar card-no-border">

<div id="main-wrapper">


    @include('topbar')

    @include('leftSidebar')
    
    <div class="page-wrapper">

        <div class="container-fluid">


            @yield('content')


            <footer class="footer">
                Customer Relationship Management 2.0.03 © 2023 | TECH CLOUD LTD
            </footer>

        </div>

    </div>
</div>


<script src="{{url('assets/plugins/bootstrap/js/popper.min.js')}}"></script>
<script src="{{url('assets/plugins/bootstrap/js/bootstrap.min.js')}}"></script>
<script src="{{url('js/jquery.slimscroll.js')}}"></script>
<script src="{{url('js/sidebarmenu.js')}}"></script>
<script src="{{url('assets/plugins/sticky-kit-master/dist/sticky-kit.min.js')}}"></script>
<script src="{{url('js/custom.min.js')}}"></script>
<script src="{{url('date/jquery-ui.js')}}"></script>
<script src="{{url('date/script.js')}}"></script>



<script>

</script>


@yield('bottom')


@yield('foot-js')

</body>

</html>