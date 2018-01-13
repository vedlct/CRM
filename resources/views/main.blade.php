<!DOCTYPE html>
<html>

<!-- Mirrored from demo.bootstrapious.com/admin/ by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 10 Jan 2018 07:52:21 GMT -->
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Tech Cloud CRM</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="all,follow">


    <!-- Latest compiled and minified CSS -->


    <!-- Bootstrap CSS-->
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <!-- Google fonts - Roboto -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,700">


    <!-- theme stylesheet-->
    <link rel="stylesheet" href="{{ asset('css/style.default.css') }}" id="theme-stylesheet">
    <!-- Custom stylesheet - for your changes-->
    <link rel="stylesheet" href="{{ asset('css/custom.css')}}">
    <!-- Favicon-->

    <!-- Font Awesome CDN-->
    <!-- you can replace it by local Font Awesome-->
    <script src=" {{ asset('js/use.fontawesome.com/99347ac47f.js')}}"></script>
    <!-- Font Icons CSS-->




    <link rel="stylesheet" href="{{ asset('css/icons.css')}}">
    <!-- Tweaks for older IEs--><!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script><![endif]-->



    <!-- jQuery library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

    <!-- Latest compiled JavaScript -->
    {{--<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>--}}




    {{--<script src="https://code.jquery.com/jquery-1.12.4.js"></script>--}}


    @yield('header')




</head>
<body>
<div class="page home-page">
    <!-- Main Navbar-->









    @include('header')
    @include('navbar')



    <div class="content-inner">






    @yield('content')





    @include('footer')



<!-- Javascript files-->



<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>




<!-- Google Analytics: change UA-XXXXX-X to be your site's ID.-->
<!---->
        <script src="../../ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>

        <script src="{{asset('js/bootstrap.min.js')}}"></script>
        <script src="{{asset('js/jquery.cookie.js')}}"> </script>
        <script src="{{asset('js/jquery.validate.min.js')}}"></script>
        <script src="../../cdnjs.cloudflare.com/ajax/libs/Chart.js/2.5.0/Chart.min.js"></script>
        <script src="{{asset('js/front.js')}}"></script>


<!-- Google Analytics: change UA-XXXXX-X to be your site's ID.-->
<!---->


</body>

<!-- Mirrored from demo.bootstrapious.com/admin/ by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 10 Jan 2018 07:53:05 GMT -->
</html>


@yield('foot')


