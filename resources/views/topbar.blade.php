<!-- 
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
        <div class="navbar-header">
            <a class="navbar-brand" href="{{route('home')}}">
                <img src="{{url('img/logo/TCL_logo.png')}}" alt="homepage" class="dark-logo" width="40px"/>
                <span>
                    <b>CRM</b>
                </span>
            </a>

        </div>

        
        <div class="navbar-collapse">
            <ul class="navbar-nav mr-auto mt-md-0 ">
                <li class="nav-item"> <a class="nav-link nav-toggler hidden-md-up text-muted waves-effect waves-dark" href="javascript:void(0)"><i class="ti-menu"></i></a> </li>
                <li class="nav-item"> <a class="nav-link sidebartoggler hidden-sm-down text-muted waves-effect waves-dark" href="javascript:void(0)"><i class="icon-arrow-left-circle"></i></a> </li>
            </ul>

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
                            <li><a href="{{route('accountSetting')}}"><i class="ti-settings"></i> Update Profile</a></li>
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

 -->


 

<header class="topbar">
    <nav class="navbar top-navbar navbar-expand-md navbar-light fixed-top" style="background-color: #2986CC;">
      <a class="navbar-brand" href="{{route('home')}}">
        @if(file_exists('public/img/logo/TCL_logo_white.png'))
          <img src="{{ url('public/img/logo/TCL_logo_white.png') }}" alt="homepage" class="dark-logo" style="padding-left: 10px;" />
        @else
          <img src="{{ url('public/img/logo/TCL_logo.png') }}" alt="homepage" class="dark-logo" style="padding-left: 10px"; />
        @endif

        <span class="font-weight-bold">CRM</span>
      </a>

      <div class="navbar-collapse">
            <ul class="navbar-nav mr-auto mt-md-0 ">
                <li class="nav-item"> <a class="nav-link nav-toggler hidden-md-up text-muted waves-effect waves-dark" href="javascript:void(0)"><i class="ti-menu"></i></a> </li>
                <li class="nav-item"> <a class="nav-link sidebartoggler hidden-sm-down text-muted waves-effect waves-dark" href="javascript:void(0)"><i class="icon-arrow-left-circle"></i></a> </li>
            </ul>
    </div>

      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav mr-auto">
        <li class="nav-item">
            <a class="nav-link" href="{{route('analysisHomePage')}}">Analysis</a>
        </li>
          <li class="nav-item">
            <a class="nav-link" href="{{route('reportTable')}}">Report</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{route('assignedLeads')}}">Assigned</a>
          </li>
        <li class="nav-item">
            <a class="nav-link" href="{{route('follow-up.index')}}">Followups</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{route('contacted')}}">MyLeads</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{route('Mycontacted')}}">Contacted</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{route('filterLeads')}}">Filtered</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{route('verifylead')}}">Verify</a>
        </li>
        <!-- <li class="nav-item">
            <a class="nav-link" href="{{route('addNightShift')}}">AddNew</a>
        </li> -->
        <li class="nav-item">
            <a class="nav-link" href="{{route('salesPipeline')}}">Pipeline</a>
        </li>
    </ul>

    <ul class="navbar-nav ml-auto">
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown"
              aria-haspopup="true" aria-expanded="false">
              Welcome, {{( Auth::user()->firstName )}}
            </a>
            <div class="dropdown-menu dropdown-menu-right">
              <a class="dropdown-item" href="{{route('accountSetting')}}">
                <i class="ti-settings"></i> Update Profile
              </a>
              <div class="dropdown-divider"></div>
              <a class="dropdown-item" href="{{ route('logout') }}"
                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                Logout
                <i class="fa fa-power-off"></i>
              </a>
              <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                {{ csrf_field() }}
              </form>
            </div>
          </li>
        </ul>
      </div>
    </nav>
  </header>

  <!-- <style>
    /* Custom top padding for the body */
    body {
      padding-top: 70px; /* Adjust as needed */
    }

    /* Styling for the navbar */
    .navbar {
      background-color: #2986CC;
      box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
      height: 70px; /* Set the height for the navbar */
      padding: 0 20px; /* Add some padding to the left and right */
    }

    /* Ensure the navbar stays fixed at the top */
    .navbar.fixed-top {
      position: fixed;
      top: 0;
      width: 100%;
      z-index: 999;
    }

    /* Styling for the logo */
    .navbar-brand img {
      width: 40px;
      margin-right: 10px;
    }

    .navbar-brand span {
      font-weight: bold;
      color: #ffffff; /* Set the color of the text */
      font-size: 20px; /* Adjust the font size */
    }

    /* Styling for the links in the navbar */
    .navbar-nav .nav-item .nav-link {
      color: #ffffff;
      font-size: 16px; /* Adjust the font size */
    }

    .navbar-nav .nav-item .nav-link:hover {
      color: #f8f9fa;
      background-color: transparent; /* Add a transparent background on hover */
    }

    /* Styling for the active link in the navbar */
    .navbar-nav .nav-item.active .nav-link {
      color: #f8f9fa;
      font-weight: bold;
      background-color: transparent; /* Add a transparent background to active link */
    }

    /* Styling for dropdown menu items */
    .dropdown-menu .dropdown-item {
      color: #343a40;
      font-size: 16px; /* Adjust the font size */
    }

    .dropdown-menu .dropdown-item:hover {
      background-color: #f8f9fa;
      color: #343a40;
    }

    .dropdown-menu .divider {
      border-color: #f8f9fa;
    }

    /* Optional: Reduce the padding between navbar items */
    .navbar-nav {
      padding-right: 20px;
    }

    /* Mobile layout adjustments */
    @media (max-width: 600px) {
      /* Stack all menus under one menu */
      .navbar-nav {
        flex-direction: column;
        align-items: flex-start;
      }

      /* Adjust the height of the navbar for mobile devices */
      .navbar {
        height: auto;
      }

      /* Center the logo and adjust font size for mobile devices */
      .navbar-brand {
        display: flex;
        align-items: center;
        justify-content: center;
      }

      .navbar-brand img {
        width: 30px;
        margin-right: 5px;
      }

      .navbar-brand span {
        font-size: 18px;
      }

      /* Adjust font size for mobile devices */
      .navbar-nav .nav-item .nav-link,
      .dropdown-menu .dropdown-item {
        font-size: 14px;
      }

      /* Collapse the navbar when in mobile view */
      .navbar-collapse {
        display: none;
      }

      /* Show the collapsed navbar when the hamburger icon is clicked */
      .navbar-toggler {
        display: block;
      }

      /* Show the navbar links in a vertical layout when the hamburger icon is clicked */
      .navbar.show .navbar-collapse {
        display: flex;
        flex-direction: column;
        align-items: flex-start;
      }
    }
  </style> -->


  <style>
  
  /* Custom top padding for the body */
body {
  padding-top: 80px; /* Adjust as needed */
}

/* Styling for the navbar */
.navbar {
  background-color: #8F6251 !important; /* New primary color */
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
  height: 70px; /* Set the height for the navbar */
  padding: 0 20px; /* Add some padding to the left and right */
}

/* Ensure the navbar stays fixed at the top */
.navbar.fixed-top {
  position: fixed;
  top: 0;
  width: 100%;
  z-index: 999;
}

/* Styling for the logo */
.navbar-brand img {
  width: 40px;
  margin-right: 10px;
}

.navbar-brand span {
  font-weight: bold;
  color: #ffffff; /* Set the color of the text */
  font-size: 20px; /* Adjust the font size */
}

/* Styling for the links in the navbar */
.navbar-nav .nav-item .nav-link {
  color: #ffffff;
  font-size: 16px; /* Adjust the font size */
}

.navbar-nav .nav-item .nav-link:hover {
  color: #f8f9fa;
  background-color: transparent; /* Add a transparent background on hover */
}

/* Styling for the active link in the navbar */
.navbar-nav .nav-item.active .nav-link {
  color: #f8f9fa;
  font-weight: bold;
  background-color: transparent; /* Add a transparent background to active link */
}

/* Styling for dropdown menu items */
.dropdown-menu .dropdown-item {
  color: #343a40;
  font-size: 16px; /* Adjust the font size */
}

.dropdown-menu .dropdown-item:hover {
  background-color: #f8f9fa;
  color: #343a40;
}

.dropdown-menu .divider {
  border-color: #f8f9fa;
}

/* Optional: Reduce the padding between navbar items */
.navbar-nav {
  padding-right: 20px;
}

/* Mobile layout adjustments */
@media (max-width: 600px) {
  /* Stack all menus under one menu */
  .navbar-nav {
    flex-direction: column;
    align-items: flex-start;
  }

  /* Adjust the height of the navbar for mobile devices */
  .navbar {
    height: auto;
  }

  /* Center the logo and adjust font size for mobile devices */
  .navbar-brand {
    display: flex;
    align-items: center;
    justify-content: center;
  }

  .navbar-brand img {
    width: 30px;
    margin-right: 5px;
  }

  .navbar-brand span {
    font-size: 18px;
  }

  /* Adjust font size for mobile devices */
  .navbar-nav .nav-item .nav-link,
  .dropdown-menu .dropdown-item {
    font-size: 14px;
  }

  /* Collapse the navbar when in mobile view */
  .navbar-collapse {
    display: none;
  }

  /* Show the collapsed navbar when the hamburger icon is clicked */
  .navbar-toggler {
    display: block;
  }

  /* Show the navbar links in a vertical layout when the hamburger icon is clicked */
  .navbar.show .navbar-collapse {
    display: flex;
    flex-direction: column;
    align-items: flex-start;
  }
}

  
  
  </style>
