<style>

	body {
		padding-top: 80px;
	}
	/* Styling for the navbar */
	.navbar {
		background-color: #517E8F !important;
		box-shadow: 0 2px 4px rgba(0, 0, 0, 0.4);
		height: 70px;
		padding: 0 20px;
	}
	/* Ensure the navbar stays fixed at the top */
	.navbar.fixed-top {
		position: fixed;
		top: 0;
		width: 100%;
		z-index: 999;
	}

	.navbar-expand-md .navbar-collapse {
	   /*flex-basis: auto !important;*/
	   display: flex;
      align-items: center;
      flex: 1; /* Allow the navbar-collapse to take up remaining space */
	}

	.navbar-arrow{
	   padding-right: 100px !important;
	}
	
	.navbar-user {
      display: flex;
      align-items: center;
   }

	/* Styling for the logo */
	.navbar-brand img {
		width: 40px;
		margin-right: 10px;
	}
	.navbar-brand span {
		font-weight: bold;
		color: #ffffff;
		font-size: 20px;
	}
	/* Styling for the links in the navbar */
	.navbar-nav .nav-item .nav-link {
		color: #ffffff;
		font-size: 16px;
	}
	.navbar-nav .nav-item .nav-link:hover {
		color: #f8f9fa;
		background-color: transparent;
	}
	/* Styling for the active link in the navbar */
	.navbar-nav .nav-item.active .nav-link {
		color: #f8f9fa;
		font-weight: bold;
		background-color: transparent;
	}
	/* Styling for dropdown menu items */
	.dropdown-menu .dropdown-item {
		color: #343a40;
		font-size: 16px;
	}
	.dropdown-menu .dropdown-item:hover {
		background-color: #f8f9fa;
		color: #343a40;
	}
	.dropdown-menu .divider {
		border-color: #f8f9fa;
	}
	/* Optional: Reduce the padding between navbar items */;
	.navbar-nav {
		padding-right: 20px;
	}
	.navbar-nav li .nav-date {
		color: rgb(255 255 255 / 80%);
		margin: 0 20px;
	}
	.circle-container {
		display: flex;
		justify-content: center;
		align-items: center;
		width: 50px;
		height: 50px;
		border-radius: 60%;
		overflow: hidden;
		background-color: #f0f0f0;
	}
	/* Style for the circular image */
	.user-image {
		max-width: 60px;
		max-height: 60px;
	}
  </style>


 
<header class="topbar">
   <nav class="navbar top-navbar navbar-expand-md navbar-light fixed-top" style="background-color: #2986CC;">
      <a class="navbar-brand" href="{{route('home')}}" style="padding-left: 30px;">
      <span class="font-weight-bold">CRM </span>
      </a>
      <div class="navbar-arrow">
         <ul class="navbar-nav mr-auto mt-md-0 ">
            <li class="nav-item"> <a class="nav-link nav-toggler hidden-md-up text-muted waves-effect waves-dark" href="javascript:void(0)"><i class="ti-menu"></i></a> </li>
            <li class="nav-item"> <a class="nav-link sidebartoggler hidden-sm-down text-muted waves-effect waves-dark" href="javascript:void(0)"><i class="icon-arrow-left-circle"></i></a> </li>
         </ul>
      </div>

      <div class="navbar-collapse" id="navbarNav">
         <ul class="navbar-nav mr-auto">
            <li class="nav-item">
               <span class="nav-date">Dhaka: {{ $timeData['Dhaka']->format('H:i') }}</span> | 
            </li>
            <li class="nav-item">
               <span class="nav-date">London: {{ $timeData['London']->format('H:i') }}</span> | 
            </li>
            <li class="nav-item">
               <span class="nav-date">Italy: {{ $timeData['Italy']->format('H:i') }}</span> | 
            </li>
            <li class="nav-item">
               <span class="nav-date">Australia: {{ $timeData['Australia']->format('H:i') }}</span> | 
            </li>
            <li class="nav-item">
               <span class="nav-date">Canada: {{ $timeData['Canada']->format('H:i') }}</span>
            </li>
         </ul>
	  </div> 

		<div class="navbar-user">
         <ul class="navbar-nav ml-auto" >
            <li class="nav-item dropdown">
               <a class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown"
                  aria-haspopup="true" aria-expanded="false">
               {{( Auth::user()->firstName )}} <i class="fa fa-chevron-down"></i>
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
         <img src="{{ url('public/img/users/' . Auth::user()->picture) }}" alt="user" class="rounded-circle user-image" />
      </div>
      
   </nav>

   
</header>
