<!DOCTYPE html>
<html lang="en">


<!-- Mirrored from wrappixel.com/demos/admin-templates/monster-admin/main/index.html by HTTrack Website Copier/3.x [XR&CO'2014], Sat, 13 Jan 2018 12:28:59 GMT -->
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">




    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="{{url('img/logo/TCL_logo.png')}}">
    <title>Customer relationship management</title>

@yield('header')

<!-- Bootstrap Core CSS -->
    <link href="{{url('assets/plugins/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet">

    <!-- chartist CSS -->
{{--<link href="{{url('assets/plugins/chartist-js/dist/chartist.min.css')}}" rel="stylesheet">--}}
{{--<link href="{{url('assets/plugins/chartist-js/dist/chartist-init.css')}}" rel="stylesheet">--}}
{{--<link href="{{url('')}}assets/plugins/chartist-plugin-tooltip-master/dist/chartist-plugin-tooltip.css" rel="stylesheet">--}}
{{--<link href="{{url('')}}../assets/plugins/css-chart/css-chart.css" rel="stylesheet">--}}

<!-- toast CSS -->
{{--<link href="{{url('assets/plugins/toast-master/css/jquery.toast.css')}}" rel="stylesheet">--}}
<!-- Custom CSS -->
    <link href="{{url('css/style.css')}}" rel="stylesheet">
    <!-- You can change the theme colors from here -->
    <link href="{{url('css/colors/blue.css')}}" id="theme" rel="stylesheet">
    <link rel="stylesheet" href="{{url('date/date-picker.css')}}">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <!--<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">-->
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <![endif]-->

    <style>
        .help-block{
            color: red;
        }
    </style>


</head>

<body class="fix-header fix-sidebar card-no-border">

<div id="main-wrapper">




    @include('topbar')

    @include('leftSidebar')

    <div class="page-wrapper">

        <div class="container-fluid">


            @if(Session::has('message'))
                <p class="alert {{ Session::get('alert-class', 'alert-success') }}">{{ Session::get('message') }}</p>
            @endif

            <div class="alert alert-success" id="alert" style="display: none ">
                <strong>Success!</strong> Indicates a successful or positive action.
            </div>

            @yield('content')



            <footer class="footer">
                © 2018 CRM By TECH CLOUD LTD
            </footer>

        </div>

    </div>




</div>



<script src="{{url('assets/plugins/jquery/jquery.min.js')}}"></script>
<script src="{{url('assets/plugins/bootstrap/js/popper.min.js')}}"></script>
<script src="{{url('assets/plugins/bootstrap/js/bootstrap.min.js')}}"></script>
<script src="{{url('js/jquery.slimscroll.js')}}"></script>
<!--Wave Effects -->
{{--<script src="{{url('js/waves.js')}}"></script>--}}
<!--Menu sidebar -->
<script src="{{url('js/sidebarmenu.js')}}"></script>
<!--stickey kit -->
<script src="{{url('assets/plugins/sticky-kit-master/dist/sticky-kit.min.js')}}"></script>
<!--Custom JavaScript -->
<script src="{{url('js/custom.min.js')}}"></script>
<script src="{{url('date/jquery-ui.js')}}"></script>
<script src="{{url('date/script.js')}}"></script>





@yield('bottom')


@yield('foot-js')

</body>

</html>