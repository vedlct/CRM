
    <style>
            .light-color {
                color: #ffffff;
                padding: 0 20px;
            }


.onhover-dropdown{
    cursor:pointer;
    position:relative
}

.onhover-show-div {
    top: 80px;
    left: -150px; 
    position: absolute;
    z-index: 8;
    background-color: #fff;
    -webkit-transition: all linear 0.3s;
    transition: all linear 0.3s;
    -webkit-box-shadow:0 0 20px rgba(89,102,122,0.1);
    box-shadow:0 0 20px rgba(89,102,122,0.1);
    -webkit-transform:translateY(30px);
    transform:translateY(30px);
    opacity:0;
    visibility:hidden;

}

.onhover-dropdown:hover .onhover-show-div{
    opacity:1;
    -webkit-transform:translateY(0px);
    transform:translateY(0px);
    visibility:visible;
    border-radius:5px;
    overflow:hidden
}
.onhover-dropdown:hover .onhover-show-div:before{
    width:0;
    height:0;
    border-left:7px solid transparent;
    border-right:7px solid transparent;
    border-bottom:7px solid #fff;
    content:"";
    top:-7px;
    position:absolute;
    left:10px;
    z-index:2
}
.onhover-dropdown:hover .onhover-show-div:after{
    width:0;
    height:0;
    border-left:7px solid transparent;
    border-right:7px solid transparent;
    border-bottom:7px solid #d7e2e9;
    content:"";
    top:-7px;
    position:absolute;
    left:10px;
    z-index:1
}

.notification-box{
    position:relative
}
.notification-dropdown{
    padding-top:20px;
    top:52px;
    width:300px;
    right:-20px !important;
    left:unset
}
    </style>

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

            </ul>
        <!-- {{--For recent Notice--}}

        <marquee width="75%" style="color: white;">{{$recentNotice->msg}} <span style="color: green">-By {{$recentNotice->user->firstName}} -{{$recentNotice->created_at}}</span></marquee> -->
        



            <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
                <a class="light-color" aria-current="page" href="{{route('home')}}">Dashboard</a>
                <a class="light-color" href="{{route('reportTable')}}">Report</a>
                <a class="light-color" href="{{route('assignedLeads')}}">Assigned Leads</a>
                <a class="light-color" href="{{route('follow-up.index')}}">Follow-ups</a>
                <a class="light-color" href="{{route('contacted')}}">My Leads</a>
                <a class="light-color" href="{{route('Mycontacted')}}">Contacted Leads</a>
                <a class="light-color" href="{{route('filterLeads')}}">Filtered Leads</a>
                <a class="light-color" href="{{route('verifylead')}}">Verify Lead</a>
                <a class="light-color" href="{{route('addNightShift')}}">Add New Lead</a>
            </div>



            <ul class="navbar-nav my-lg-0">

               <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle text-muted waves-effect waves-dark" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <b>Profile </b></a>
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