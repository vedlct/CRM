<header class="topbar">
    <nav class="navbar top-navbar navbar-expand-md navbar-light">
        <!-- ============================================================== -->
        <!-- Logo -->
        <!-- ============================================================== -->
        <div class="navbar-header">
            <a class="navbar-brand" href="{{route('home')}}">
                <!-- Logo icon -->

                <img src="{{url('img/logo/TCL_logo.png')}}" alt="homepage" class="dark-logo" width="40px"/>


                <span>

                    <b>CRM</b>
                    <!-- Light Logo text -->
                </span>
            </a>

        </div>
        <!-- ============================================================== -->
        <!-- End Logo -->
        <!-- ============================================================== -->
        <div class="navbar-collapse">
            <!-- ============================================================== -->
            <!-- toggle and nav items -->
            <!-- ============================================================== -->
            <ul class="navbar-nav mr-auto mt-md-0 ">
                <!-- This is  -->
                <li class="nav-item"> <a class="nav-link nav-toggler hidden-md-up text-muted waves-effect waves-dark" href="javascript:void(0)"><i class="ti-menu"></i></a> </li>
                <li class="nav-item"> <a class="nav-link sidebartoggler hidden-sm-down text-muted waves-effect waves-dark" href="javascript:void(0)"><i class="icon-arrow-left-circle"></i></a> </li>
                <!-- ============================================================== -->
                <!-- Comment -->
                <!-- ============================================================== -->
                {{--<li class="nav-item dropdown">--}}
                    {{--<a class="nav-link dropdown-toggle text-muted text-muted waves-effect waves-dark" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="mdi mdi-message"></i>--}}
                        {{--<div class="notify"> <span class="heartbit"></span> <span class="point"></span> </div>--}}
                    {{--</a>--}}
                    {{--<div class="dropdown-menu mailbox animated bounceInDown">--}}
                        {{--<ul>--}}
                            {{--<li>--}}
                                {{--<div class="drop-title">Notifications</div>--}}
                            {{--</li>--}}
                      {{----}}
                            {{--<li>--}}
                                {{--<a class="nav-link text-center" href="javascript:void(0);"> <strong>Check all notifications</strong> <i class="fa fa-angle-right"></i> </a>--}}
                            {{--</li>--}}
                        {{--</ul>--}}
                    {{--</div>--}}
                {{--</li>--}}

                {{--<input type="text" placeholder="search bar">--}}
                <!-- ============================================================== -->
                <!-- End Messages -->
                <!-- ============================================================== -->
            </ul>
            <!-- ============================================================== -->
            <!-- User profile and search -->
            <!-- ============================================================== -->
            {{--For recent Notice--}}

         {{--   <marquee width="75%" style="color: white;">{{$recentNotice->msg}} <span style="color: green">-By {{$recentNotice->user->firstName}} -{{$recentNotice->created_at}}</span></marquee>
        --}}


            <ul class="navbar-nav my-lg-0">

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle text-muted waves-effect waves-dark" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Welcome<b> {{Auth::user()->firstName}} <i class="fa fa-sort-desc" aria-hidden="true"></i></b></a>
                    <div class="dropdown-menu dropdown-menu-right">
                        <ul class="dropdown-user">
                            <li>
                                <div class="dw-user-box">
                                    <div class="u-text">
                                        <h4>{{Auth::user()->firstName}} {{Auth::user()->lastName}} </h4>
                                        <p class="text-muted">{{Auth::user()->userEmail}} </p>
                                      </div>
                                </div>
                            </li>


                            <li role="separator" class="divider"></li>
                            <li><a href="{{route('accountSetting')}}"><i class="ti-settings"></i> Account Setting</a></li>
                            <li role="separator" class="divider"></li>
                            <li>


                                <a href="{{ route('logout') }}"
                                   onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                    Logout
                                    <i class="fa fa-power-off"> </i></a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    {{ csrf_field() }}
                                </form>




                            </li>
                        </ul>
                    </div>
                </li>

            </ul>
        </div>
        </div>
    </nav>
</header>