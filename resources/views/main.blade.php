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




    @yield('header')




</head>
<body>
<div class="page home-page">
    <!-- Main Navbar-->
    <header class="header">
        <nav class="navbar">
            <!-- Search Box-->
            <div class="search-box">
                <button class="dismiss"><i class="icon-close"></i></button>
                <form id="searchForm" action="#" role="search">
                    <input type="search" placeholder="What are you looking for..." class="form-control">
                </form>
            </div>
            <div class="container-fluid">
                <div class="navbar-holder d-flex align-items-center justify-content-between">
                    <!-- Navbar Header-->
                    <div class="navbar-header">
                        <!-- Navbar Brand --><a href="index-2.html" class="navbar-brand">
                            <div class="brand-text brand-big hidden-lg-down"><span>Customer Relationship</span><strong> Management</strong></div>
                            <div class="brand-text brand-small"><strong>CRM</strong></div></a>
                        <!-- Toggle Button--><a id="toggle-btn" href="#" class="menu-btn active"><span></span><span></span><span></span></a>
                    </div>
                    <!-- Navbar Menu -->
                    <ul class="nav-menu list-unstyled d-flex flex-md-row align-items-md-center">
                        <!-- Search-->
                        <li class="nav-item d-flex align-items-center"><a id="search" href="#"><i class="icon-search"></i></a></li>
                        <!-- Notifications-->
                        <li class="nav-item dropdown"> <a id="notifications" rel="nofollow" data-target="#" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link"><i class="fa fa-bell-o"></i><span class="badge bg-red">12</span></a>
                            <ul aria-labelledby="notifications" class="dropdown-menu">
                                <li><a rel="nofollow" href="#" class="dropdown-item">
                                        <div class="notification">
                                            <div class="notification-content"><i class="fa fa-envelope bg-green"></i>You have 6 new messages </div>
                                            <div class="notification-time"><small>4 minutes ago</small></div>
                                        </div></a></li>
                                <li><a rel="nofollow" href="#" class="dropdown-item">
                                        <div class="notification">
                                            <div class="notification-content"><i class="fa fa-twitter bg-blue"></i>You have 2 followers</div>
                                            <div class="notification-time"><small>4 minutes ago</small></div>
                                        </div></a></li>
                                <li><a rel="nofollow" href="#" class="dropdown-item">
                                        <div class="notification">
                                            <div class="notification-content"><i class="fa fa-upload bg-orange"></i>Server Rebooted</div>
                                            <div class="notification-time"><small>4 minutes ago</small></div>
                                        </div></a></li>
                                <li><a rel="nofollow" href="#" class="dropdown-item">
                                        <div class="notification">
                                            <div class="notification-content"><i class="fa fa-twitter bg-blue"></i>You have 2 followers</div>
                                            <div class="notification-time"><small>10 minutes ago</small></div>
                                        </div></a></li>
                                <li><a rel="nofollow" href="#" class="dropdown-item all-notifications text-center"> <strong>view all notifications                                            </strong></a></li>
                            </ul>
                        </li>
                        <!-- Messages                        -->
                        <li class="nav-item dropdown"> <a id="messages" rel="nofollow" data-target="#" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link"><i class="fa fa-envelope-o"></i><span class="badge bg-orange">10</span></a>
                            <ul aria-labelledby="notifications" class="dropdown-menu">
                                <li><a rel="nofollow" href="#" class="dropdown-item d-flex">
                                        <div class="msg-profile"> <img src="img/avatar-1.jpg" alt="..." class="img-fluid rounded-circle"></div>
                                        <div class="msg-body">
                                            <h3 class="h5">Jason Doe</h3><span>Sent You Message</span>
                                        </div></a></li>
                                <li><a rel="nofollow" href="#" class="dropdown-item d-flex">
                                        <div class="msg-profile"> <img src="img/avatar-2.jpg" alt="..." class="img-fluid rounded-circle"></div>
                                        <div class="msg-body">
                                            <h3 class="h5">Frank Williams</h3><span>Sent You Message</span>
                                        </div></a></li>
                                <li><a rel="nofollow" href="#" class="dropdown-item d-flex">
                                        <div class="msg-profile"> <img src="img/avatar-3.jpg" alt="..." class="img-fluid rounded-circle"></div>
                                        <div class="msg-body">
                                            <h3 class="h5">Ashley Wood</h3><span>Sent You Message</span>
                                        </div></a></li>
                                <li><a rel="nofollow" href="#" class="dropdown-item all-notifications text-center"> <strong>Read all messages    </strong></a></li>
                            </ul>
                        </li>
                        <!-- Logout    -->
                        <li class="nav-item"><a href="/login" class="nav-link logout">Logout<i class="fa fa-sign-out"></i></a></li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>












    <div class="page-content d-flex align-items-stretch">
        <!-- Side Navbar -->
        <nav class="side-navbar">
            <!-- Sidebar Header-->
            <div class="sidebar-header d-flex align-items-center">
                <div class="avatar"><img src="img/avatar-1.jpg" alt="..." class="img-fluid rounded-circle"></div>
                <div class="title">
                    <h1 class="h4">Mark Stephen</h1>
                    <p>Web Designer</p>
                </div>
            </div>
            <!-- Sidebar Navidation Menus--><span class="heading">Main</span>
            <ul class="list-unstyled">
                <li   class="{{ Request::is('main') ? 'active' : '' }} "><a href="/main"><span class="fa fa-calendar-check-o" aria-hidden="true"></span>Today's Follow Up</a></li>
                <li><a href="#dashvariants" aria-expanded="false" data-toggle="collapse"> <i class="icon-interface-windows"></i>List </a>
                    <ul id="dashvariants" class="collapse list-unstyled">
                        <li><a href="#">My List</a></li>
                        <li><a href="#">Test List</a></li>
                        <li><a href="#">Page</a></li>
                        <li><a href="#">Page</a></li>
                    </ul>
                </li>




                <li class="{{ Request::is('mylist') ? 'active' : '' }}"> <a href="/mylist"> <span class="fa fa-list-alt" aria-hidden="true"></span>My List </a></li>
                <li class="{{ Request::is('testlist') ? 'active' : '' }}"> <a href="/testlist"> <span class="fa fa-th-list" aria-hidden="true"></span>Test List </a></li>
                <li class="{{ Request::is('clients') ? 'active' : '' }}"> <a href="/clients"><span class="fa fa-address-card" aria-hidden="true"></span>Clients </a></li>
                <li class="{{ Request::is('leads') ? 'active' : '' }}"> <a href="/leads"> <span class="fa fa-phone-square" aria-hidden="true"></span>Leads & Contacts</a></li>
                <li class="{{ Request::is('starleads') ? 'active' : '' }}"> <a href="/starleads"> <span class="fa fa-star-half-o" aria-hidden="true"></span>Star Leads </a></li>
                <li class="{{ Request::is('newinfo') ? 'active' : '' }}"> <a href="/newinfo"> <span class="fa fa-plus-circle" aria-hidden="true"></span>New Info</a></li>
                <li class="{{ Request::is('assignreport') ? 'active' : '' }}"> <a href="/assignreport"><span class="fa fa-tasks" aria-hidden="true"></span>Assign Report</a></li>
                <li class="{{ Request::is('reports') ? 'active' : '' }}"> <a href="/reports"> Report</a></li>

                <li class="{{ Request::is('notices') ? 'active' : '' }}"> <a href="notices"> <span class="fa fa-bell" aria-hidden="true"></span>Notice Board</a></li>
                <li class="{{ Request::is('leaves') ? 'active' : '' }}"> <a href="/leaves"> <i class=""></i>Leave Show</a></li>
                <li class="{{ Request::is('myteam') ? 'active' : '' }}"> <a href="/myteam"> <i class=""></i>My Team</a></li>
                <li class="{{ Request::is('profile') ? 'active' : '' }}"> <a href="/profile"> <i class=""></i>Profile</a></li>





            </ul>

        </nav>
        <div class="content-inner">




            @yield('content')





            <!-- Page Footer-->
            <footer class="main-footer" style="position: fixed; bottom: 0; width: 100%;">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-sm-6">
                            <p>Your company &copy; 2017-2019</p>
                        </div>
                        <div class="col-sm-6 text-right">
                            <p>Design by <a href="https://bootstrapious.com/admin-templates" class="external">Bootstrapious</a></p>
                            <!-- Please do not remove the backlink to us unless you support further theme's development at https://bootstrapious.com/donate. It is part of the license conditions. Thank you for understanding :)-->
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </div>
</div>









<script src=" {{ asset('js/tether.min.js') }}"></script>
<script src="{{asset('js/bootstrap.min.js')}}"></script>
<script src="{{asset('js/jquery.cookie.js')}}"> </script>
<script src="{{asset('js/jquery.validate.min.js')}}"></script>
<script src="{{asset('cdnjs.cloudflare.com/ajax/libs/Chart.js/2.5.0/Chart.min.js')}}"></script>
<script src="{{asset('js/charts-home.js')}}"></script>
<script src="{{asset('js/front.js')}}"></script>
<!-- Google Analytics: change UA-XXXXX-X to be your site's ID.-->
<!---->

</body>

<!-- Mirrored from demo.bootstrapious.com/admin/ by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 10 Jan 2018 07:53:05 GMT -->
</html>

