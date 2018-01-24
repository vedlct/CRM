<aside class="left-sidebar">
    <!-- Sidebar scroll-->
    <div class="scroll-sidebar">
        <!-- User profile -->
        <div class="user-profile">
            <!-- User profile image -->
            <div class="profile-img"> <img src="{{asset('img/'.Auth::user()->picture)}}" alt="user" /> </div>
            <!-- User profile text-->
            <div class="profile-text">
                <b>ID :</b><strong> {{Auth::user()->userId}} </strong> <span class="caret"></span><br>

            </div>
        </div>
        <!-- End User profile text-->
        <!-- Sidebar navigation-->
        <nav class="sidebar-nav">
            <ul id="sidebarnav">
                <li class="nav-small-cap">PERSONAL</li>

                <li>
				 <a href="{{route('follow-up.index')}}"><i class="mdi mdi-gauge" aria-hidden="true"></i>Todays Follow-up</a>

                </li>
				<!--
                <li>
                    <a href="{{route('main')}}"><i class="mdi mdi-gauge"></i>Todays Follow Up </a>

                </li>
				-->
                <li>
                    <a href="{{route('assignedLeads')}}" ><i class="fa fa-list"></i>Assigned Leads</a>

                </li>

                <li>
                    <a href="{{route('starLeads')}}"><i class="fa fa-star"></i>Star Leads</a>
                </li>


                <li>
                    <a href="{{route('testlist')}}"><i class="fa fa-list-alt"></i>Test List</a>

                </li>

                <li>
                    <a href="{{route('clients')}}"><i class="fa fa-user-circle-o"></i>Clients</a>

                </li>

                <li>
                    <a href="{{route('addLead')}}"><i class="fa fa-plus"></i>Add Lead</a>

                </li>


                <li>
                    <a href="{{route('assignShow')}}"><i class="fa fa-share"></i> Assign Lead</a>

                </li>


                <li>
                    <a href="leads"><i class="fa fa-briefcase"></i>Leads</a>

                </li>
                <li>
                    <a href="{{route('tempLeads')}}"><i class="fa fa-text-width"></i>Temp Leads</a>

                </li>
                <li>
                    <a href="{{route('filterLeads')}}"><i class="fa fa-filter"></i>Filtered Leads</a>

                </li>


                <li>
                    <a href="newinfo"><i class="fa fa-plus-square"></i>Add Info</a>

                </li>

                <li>
				 <a href="{{route('user-management.index')}}"><i class="fa fa-users" aria-hidden="true"></i>User Management</a>

                </li>

                <li>
                    <a href="{{ route('notice.index') }}"><i class="fa fa-plus-square"></i>Notice</a>

                </li>

                <li>
                    <a href="leaves"><i class="mdi mdi-bullseye"></i>Leave Show</a>

                </li>


                <li>
                    <a href="{{route('myTeam')}}"><i class="fa fa-users"></i>My Team</a>

                </li>




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