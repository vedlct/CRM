
@php($userType = Session::get('userType'))

<aside class="left-sidebar">
    <!-- Sidebar scroll-->
    <div class="scroll-sidebar">
        <!-- User profile -->
        <div class="user-profile">
            <!-- User profile image -->
            <div class="profile-img"> <img src="{{asset('img/'.Auth::user()->picture)}}" alt="user" /> </div>
            <!-- User profile text-->
            <div class="profile-text">
                <b>ID :</b><strong> {{strtoupper( Auth::user()->userId )}} </strong> <span class="caret"></span><br>

            </div>
        </div>
        <!-- End User profile text-->
        <!-- Sidebar navigation-->
        <nav class="sidebar-nav">
            <ul id="sidebarnav">
                <li class="nav-small-cap">PERSONAL</li>

                <li>
                    <a href="{{route('home')}}"><i class="mdi mdi-gauge" aria-hidden="true"></i>
                        <span class="hide-menu">Dashboard</span></a>
                </li>

                {{--For user --}}
                @if($userType =='USER' )

                <li>
                    <a href="{{route('assignedLeads')}}" ><i class="fa fa-list"></i><span class="hide-menu">
                            Assigned Leads</span></a>
                </li>
                @endif

                @if($userType=='USER')
                <li>
				 <a href="{{route('follow-up.index')}}"><i class="fa fa-calendar-o" aria-hidden="true"></i>
                     <span class="hide-menu">Todays Follow-up</span></a>
                </li>
                    <li>
                    <a href="{{route('contacted')}}"><i class="fa fa-user-circle-o"></i><span class="hide-menu">Contacts</span></a>
                    </li>
                @endif

                <li>
                    <a href="{{route('filterLeads')}}"><i class="fa fa-filter"></i><span class="hide-menu">Filtered Leads</span></a>

                </li>

                @if($userType =='MANAGER')

                <li>
                    <a href="{{route('tempLeads')}}"><i class="fa fa-text-width"></i><span class="hide-menu">Temp Leads</span></a>
                </li>
                @endif

                @if($userType =='USER' )
                <li class="treeview">
                    <a href="#"><i class="fa fa-link"></i> <span class="hide-menu">My List</span>
                        <span class="pull-right-container">
					  <i class="fa fa-angle-left pull-right"></i>
					</span>
                    </a>
                    <ul class="treeview-menu">
                        <li>
                            <a href="{{route('starLeads')}}"><i class="fa fa-star"></i><span class="hide-menu">Star Leads</span></a>
                        </li>
                        <li><a href="{{route('testlist')}}"><i class="fa fa-list-alt"></i><span class="hide-menu">Test List</span></a></li>
                        <li><a href="#"><span class="hide-menu">Leave</span></a></li>

                    </ul>
                </li>
                @endif


                @if($userType =='RA' || $userType =='MANAGER')
                <li>
                    <a href="{{route('assignShow')}}"><i class="fa fa-share"></i><span class="hide-menu">Assign Lead</span></a>
                </li>
                @endif

                @if($userType =='USER')

                <li>
                    <a href="{{route('myTeam')}}"><i class="fa fa-users"></i>
                        <span class="hide-menu">My Team</span></a>
                </li>

                @endif


                <li>
                    <a href="{{route('report')}}"><i class="fa fa-flag-checkered" aria-hidden="true"></i>
                        <span class="hide-menu">Report</span></a>
                </li>

                @if($userType =='SUPERVISOR')

                <li class="treeview">
                    <a href="#"><i class="fa fa-cog" aria-hidden="true"></i> <span class="hide-menu">Settings</span>
                        <span class="pull-right-container">
					  <i class="fa fa-angle-left pull-right"></i>
					</span>
                    </a>
                    <ul class="treeview-menu">
                        <li>
                            <a href="{{route('teamManagement')}}"><i class="fa fa-users"></i>
                                <span class="hide-menu">Team Management</span></a>
                        </li>
                        <li>
                            <a href="{{route('rejectedLeads')}}"><i class="fa fa-ban" aria-hidden="true"></i>
                                <span class="hide-menu">Rejected Leads</span></a>

                        </li>

                    </ul>
                </li>
                @endif







                @if($userType =='RA' )
                <li>
                    <a href="{{route('addLead')}}"><i class="fa fa-plus"></i><span class="hide-menu">New Lead</span></a>

                </li>
                @endif

                @if($userType=='MANAGER' )
                <li>
                    <a href="{{route('detached')}}"><i class="fa fa-eject" aria-hidden="true"></i><span class="hide-menu">Detach Lead</span></a>

                </li>
                @endif


                @if($userType=='ADMIN')
                <li>
				 <a href="{{route('user-management.index')}}"><i class="fa fa-users" aria-hidden="true"></i>
                     <span class="hide-menu">User Management</span></a>

                </li>
                @endif

                <li>
                    <a href="{{ route('notice.index') }}"><i class="fa fa-plus-square"></i>
                        <span class="hide-menu">Notice</span></a>
                </li>


                @if($userType =='ADMIN' )

                    <li><a href="{{route('system')}}"> <i class="fa fa-wrench" aria-hidden="true"></i>
                            <span class="hide-menu">System</span></a></li>

                {{--<li class="treeview">--}}
				  {{--<a href="#"><i class="fa fa-link"></i> <span class="hide-menu">System Manage</span>--}}
					{{--<span class="pull-right-container">--}}
					  {{--<i class="fa fa-angle-left pull-right"></i>--}}
					{{--</span>--}}
				  {{--</a>--}}
				  {{--<ul class="treeview-menu">--}}

					{{--<li><a href="{{ url('system-management/country') }}">Country</a></li>--}}
					{{--<li><a href="{{ url('system-management/category') }}">Category</a></li>--}}
					{{--<li><a href="{{ url('system-management/usertype') }}">User Type</a></li>--}}
					{{--<li><a href="{{ url('system-management/possibility') }}">Possibility</a></li>--}}

				  {{--</ul>--}}
				{{--</li>--}}

                @endif




                <li class="nav-devider"></li>

            </ul>
        </nav>
        <!-- End Sidebar navigation -->
    </div>
    <!-- End Sidebar scroll-->
    <!-- Bottom points-->
    <div class="sidebar-footer">

        <!-- item-->
        <a href="{{ route('logout') }}"
           onclick="event.preventDefault();
            document.getElementById('logout-form').submit();" class="link" data-toggle="tooltip" title="Logout">

            <i class="mdi mdi-power"></i></a>

    </div>
    <!-- End Bottom points-->
</aside>