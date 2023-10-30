<style>
	body {
		padding-top: 80px;
	}

	/* Styling for the navbar */
	.navbar {
		background-color: #f8f9fa !important;
		font: "Roboto", sans-serif !important;
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
	  display: flex;
      align-items: center;
      flex: 1; 
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
		color: rgba(0, 0, 0, 0.8);
		font-size: 20px;
	}


	/* Styling for the links in the navbar */
    .navbar-nav {
        padding-right: 20px;
    }
    .navbar-nav li .nav-date {
        color: rgba(0, 0, 0, 0.8) !important; /* Dark grey color */
        margin: 0 20px;
    }
    .navbar-nav .nav-item .nav-link,
    .navbar-nav .nav-item .nav-link:hover,
    .navbar-nav .nav-item.active .nav-link {
        color: rgba(0, 0, 0, 0.8) !important; /* Dark grey color */
    }
    .navbar-nav .nav-item .nav-link:hover {
        background-color: transparent;
    }
    .navbar-nav .nav-item.active .nav-link {
        font-weight: bold;
        background-color: transparent;
    }


	/* Styling for dropdown menu items */
	.dropdown.fade-in {
		opacity: 0;
		visibility: hidden;
		/* transition: opacity 0.3s ease, visibility 0.3s ease;  */
		-webkit-transition:color 0.3s ease;
		transition:color 0.3s ease;
	}
	.dropdown.fade-in.show {
		opacity: 1;
		visibility: visible;
	}
	.dropdown-menu .dropdown-item {
		color: #6e7379;
		font-size: 16px;
		padding: 12px !important;
	}
	.dropdown-menu .dropdown-item:hover {
		background-color: #adc1c8;
		color: #343a40;
	}
	.dropdown-menu .dropdown-item i {
		padding-right: 8px;
	}
	.dropdown-menu .divider {
		border-color: #f8f9fa;
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

@php($userType = Session::get('userType'))

 
<header class="topbar">
   <nav class="navbar top-navbar navbar-expand-md fixed-top">

   <!-- LOGO AND CRM NAME  -->
   <div class="user-profile">
        <a href="{{route('home')}}">
            <img src="{{ url('public/img/logo/TCL_logo.png') }}" alt="homepage" class="dark-logo" style="padding-left: 20px;max-width: 70px;" />
        </a>
    </div>
		<a class="navbar-brand" href="{{route('home')}}" style="padding: 30px;">
			<span class="font-weight-bold">CRM </span>
		</a>
      <!-- <div class="navbar-arrow">
         <ul class="navbar-nav mr-auto mt-md-0 ">
            <li class="nav-item"> <a class="nav-link nav-toggler hidden-md-up text-muted waves-effect waves-dark" href="javascript:void(0)"><i class="ti-menu"></i></a> </li>
            <li class="nav-item"> <a class="nav-link sidebartoggler hidden-sm-down text-muted waves-effect waves-dark" href="javascript:void(0)"><i class="icon-arrow-left-circle"></i></a> </li>
         </ul>
      </div> -->


	<!-- MAIN MENU HERE  -->

      <div class="navbar-collapse" id="navbarNav">
         <ul class="navbar-nav mr-auto">
            
			<!-- REPORT MENU  -->
			<li class="nav-item dropdown treeview">
				<a class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown"
				aria-haspopup="true" aria-expanded="false">
					Report
					<i class="fa fa-caret-down"></i>
				</a>
				<div class="dropdown-menu fade-in">
					<a class="dropdown-item" href="{{route('reportTable')}}">
						<i class="fa fa-table"></i> Table
					</a>

				@if($userType == 'ADMIN' || $userType == 'SUPERVISOR' || $userType == 'HR' || $userType == 'MANAGER')
				

					<a class="dropdown-item" href="{{route('targetVsAchievement')}}">
						<i class="fa fa-bullseye"></i> Target vs Achievement
					</a>
					<a class="dropdown-item" href="{{route('hour.report')}}">
						<i class="fa fa-houzz"></i> Hourly
					</a>
					<a class="dropdown-item" href="{{route('reportcountryTable')}}">
						<i class="fa fa-flag"></i> Country
					</a>
					<a class="dropdown-item" href="{{route('follow-up.report')}}">
						<i class="fa fa-houzz"></i> Follow-up
					</a>
					<a class="dropdown-item" href="{{route('report.tab')}}">
						<i class="fa fa-list-alt"></i> Others
					</a>
				@endif

				</div>

			</li>


			<!-- ANALYSIS MENU  -->
			@if($userType == 'SUPERVISOR' || $userType == 'USER' || $userType == 'MANAGER' || $userType == 'ADMIN' || $userType == 'HR')
			<li class="nav-item dropdown treeview">
				<a class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown"
				aria-haspopup="true" aria-expanded="false">
					Analysis
					<i class="fa fa-caret-down"></i>
				</a>
				<div class="dropdown-menu  fade-in">
					<a class="dropdown-item" href="{{ route('analysisHomePage') }}">
						<i class="fa fa-superpowers"></i> Analysis Home
					</a>
					<hr>
					<a class="dropdown-item" href="{{ route('analysis.personal') }}">
						<i class="fa fa-envelope"></i> Personal Analysis
					</a>
				</div>
			</li>
			@endif
			

			<!-- MY LEAD MENU  -->
			@if($userType == 'SUPERVISOR' || $userType == 'USER' || $userType == 'MANAGER')
				<li class="nav-item dropdown treeview">
					<a class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown"
					aria-haspopup="true" aria-expanded="false">
						My Leads
						<i class="fa fa-caret-down"></i>
					</a>

					<div class="dropdown-menu fade-in">
						<a class="dropdown-item" href="{{route('contacted')}}">
							<i class="fa fa-circle-o"></i> My Leads
						</a>
					
						<a class="dropdown-item" href="{{route('follow-up.index')}}">
							<i class="fa fa-calendar-o"></i> My Followups
						</a>
						<a class="dropdown-item" href="{{route('Mycontacted')}}">
							<i class="fa fa-user-circle-o"></i> Contacted Leads
						</a>
						<a class="dropdown-item" href="{{route('assignedLeads')}}">
							<i class="fa fa-list"></i> Assigned to Me
						</a>
					</div>

                </li>
            @endif


			<!-- DIRECTORY  -->
				<li class="nav-item dropdown treeview">
					<a class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown"
					aria-haspopup="true" aria-expanded="false">
						Directory
						<i class="fa fa-caret-down"></i>
					</a>

					<div class="dropdown-menu fade-in">
					@if($userType == 'SUPERVISOR' || $userType == 'ADMIN' || $userType == 'MANAGER')
						<a class="dropdown-item" href="{{route('addLead')}}">
							<i class="fa fa-plus"></i> All Leads
						</a>
						<a class="dropdown-item" href="{{route('unTouchedLead')}}">
							<i class="fa fa-plus"></i> Untouched Leads
						</a>
					@endif
						<a class="dropdown-item" href="{{route('verifylead')}}">
							<i class="fa fa-check-square-o"></i> Verify Lead
						</a>
						<a class="dropdown-item" href="{{route('filterLeads')}}">
							<i class="fa fa-filter"></i> Filtered Leads
						</a>
						<a class="dropdown-item" href="{{route('allEmployees')}}">
							<i class="fa fa-users"></i> All Contacts
						</a>
						@if($userType == 'SUPERVISOR' || $userType == 'ADMIN' || $userType == 'MANAGER')
						<a class="dropdown-item" href="{{route('parent.page')}}">
							<i class="fa fa-child"></i> Set Parent Company
						</a>
						@endif
					</div>

                </li>


			<!-- LEAD MINING  -->
				<li class="nav-item dropdown treeview">
					<a class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown"
					aria-haspopup="true" aria-expanded="false">
						Lead Mining
						<i class="fa fa-caret-down"></i>
					</a>

					<div class="dropdown-menu fade-in">
						<a class="dropdown-item" href="{{route('googleSearch')}}">
							<i class="fa fa-google"></i> Google Search
						</a>
						<a class="dropdown-item" href="{{route('crawlWebsites')}}">
							<i class="fa fa-recycle"></i> Crawl Website
						</a>
						<a class="dropdown-item" href="{{route('keywordAnalysis')}}">
							<i class="fa fa-key"></i> All Keywords
						</a>
						<a class="dropdown-item" href="{{route('addNightShift')}}">
							<i class="fa fa-adjust"></i> Add Lead
						</a>
					</div>

                </li>

				
			<!-- MY LIST  -->
			@if($userType == 'USER' || $userType == 'MANAGER' || $userType == 'SUPERVISOR')
				<li class="nav-item dropdown treeview">
					<a class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown"
					aria-haspopup="true" aria-expanded="false">
						My List
						<i class="fa fa-caret-down"></i>
					</a>

					<div class="dropdown-menu fade-in">
						@if($userType == 'USER' || $userType == 'MANAGER')
							<a class="dropdown-item" href="{{route('myTeam')}}">
								<i class="fa fa-group"></i> My Team
							</a>
						@endif
						<a class="dropdown-item" href="{{route('starLeads')}}">
							<i class="fa fa-star"></i> Star Leads
						</a>
						<a class="dropdown-item" href="{{route('clientLeads')}}">
							<i class="fa fa-list-alt"></i> Client Leads
						</a>
						<a class="dropdown-item" href="{{route('testlist')}}">
							<i class="fa fa-list-alt"></i> Test List
						</a>
						<a class="dropdown-item" href="{{route('closelist')}}">
							<i class="fa fa-list-alt"></i> Close List
						</a>
						<a class="dropdown-item" href="{{route('duplicateList')}}">
							<i class="fa fa-list-alt"></i> Duplicate List
						</a>
					</div>

                </li>
			@endif


			<!-- ASSIGN LEADS  -->
			@if($userType == 'MANAGER' || $userType == 'SUPERVISOR' || $userType == 'ADMIN')
				<li class="nav-item dropdown treeview">
					<a class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown"
					aria-haspopup="true" aria-expanded="false">
						Assign Leads
						<i class="fa fa-caret-down"></i>
					</a>

					<div class="dropdown-menu fade-in">
						<a class="dropdown-item" href="{{route('assignAllShow')}}">
							<i class="fa fa-share"></i> Assign Marketers' Lead
						</a>
						<a class="dropdown-item" href="{{route('assignShow')}}">
							<i class="fa fa-share"></i> Assign Filtered Lead
						</a>
					</div>

                </li>
			@endif



			<!-- MY TEAM  -->
            @if($userType == 'SUPERVISOR' || $userType == 'ADMIN')
				<li class="nav-item dropdown treeview">
					<a class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown"
					aria-haspopup="true" aria-expanded="false">
						Settings
						<i class="fa fa-caret-down"></i>
					</a>

					<div class="dropdown-menu fade-in">
						<a class="dropdown-item" href="{{route('user-management.index')}}">
							<i class="fa fa-users"></i> User Management
						</a>
						<a class="dropdown-item" href="{{route('user-management.target')}}">
							<i class="fa fa-bullseye"></i> Monthly Target Log
						</a>
						<a class="dropdown-item" href="{{route('teamManagement')}}">
							<i class="fa fa-users"></i> Team Management
						</a>
						<a class="dropdown-item" href="{{route('rejectedLeads')}}">
							<i class="fa fa-ban"></i> Rejected Leads
						</a>
						<a class="dropdown-item" href="{{route('changeLogs')}}">
							<i class="fa fa-history"></i> Change Logs
						</a>

						@if($userType == 'ADMIN' || $userType == 'SUPERVISOR')
							<a class="dropdown-item" href="{{route('system')}}">
								<i class="fa fa-wrench"></i> System Admin
							</a>
						@endif
					</div>

                </li>
			@endif



			

         </ul>
	  </div> 


		<!-- PROFILE MENU AT RIGHT  -->

		<div class="navbar-user">
         <ul class="navbar-nav ml-auto" >

			<!-- USER MENU  -->
            <li class="nav-item dropdown">
               <a class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown"
                  aria-haspopup="true" aria-expanded="false">
               {{( Auth::user()->firstName )}} <i class="fa fa-caret-down"></i>
               </a> 
               <div class="dropdown-menu dropdown-menu-right">
				   <a class="dropdown-item" href="{{route('notice.index')}}">
						<i class="fa fa-bullhorn"></i> Communication
					</a>

					<div class="dropdown-divider"></div>

                  <a class="dropdown-item" href="{{route('accountSetting')}}">
        	          <i class="ti-settings"></i> My Profile
                  </a>

                  <div class="dropdown-divider"></div>

                  <a class="dropdown-item" href="{{ route('logout') }}"
                     onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
					 <i class="fa fa-power-off"></i>
						Logout
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



