
@php($userType = Session::get('userType'))

<aside class="left-sidebar">
    <!-- Sidebar scroll-->
    <div class="scroll-sidebar">
        <!-- User profile -->
        <div class="user-profile">
            <!-- User profile image -->
            <div class="profile-img"> <img src="{{url('img/'.Auth::user()->picture)}}" alt="user" /> </div>
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

                {{--Start For Global--}}
            @if(Auth::user()->crmType !='local')
                @if($userType =='USER' || $userType=='MANAGER' || $userType=='SUPERVISOR')

                <li>
                    <a href="{{route('assignedLeads')}}" ><i class="fa fa-list"></i><span class="hide-menu">
                            Assigned Leads</span></a>
                </li>
                @endif


                @if($userType=='SUPERVISOR' || $userType=='USER' || $userType=='MANAGER')

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

                @if($userType =='RA' || $userType =='MANAGER' || $userType =='SUPERVISOR' || $userType =='ADMIN')

                <li>
                    <a href="{{route('tempLeads')}}"><i class="fa fa-text-width"></i><span class="hide-menu">Temp Leads</span></a>
                </li>
                @endif

                <li>
                    <a href="{{route('addLead')}}"><i class="fa fa-plus"></i><span class="hide-menu">All Lead</span></a>

                </li>


            @endif  {{--End For Global--}}

                @if($userType =='ADMIN' || Auth::user()->crmType =='local' )        {{--Start Local--}}

                <li class="treeview">
                    <a href="#"><i class="fa fa-map" aria-hidden="true"></i> <span class="hide-menu">Digital Marketing</span>
                        <span class="pull-right-container">
					  <i class="fa fa-angle-left pull-right"></i>
					</span>
                    </a>
                    <ul class="treeview-menu">

                            <li>
                                <a href="{{route('local.allLead')}}"><i class="fa fa-plus"></i><span class="hide-menu">All Lead (Digital)</span></a>
                            </li>

                            <li>
                                <a href="{{route('local.todaysFollowup')}}"><i class="fa fa-calendar-o"></i><span class="hide-menu">Todays Followup (Digital)</span></a>
                            </li>

                            <li>
                                <a href="{{route('local.myLead')}}"><i class="fa fa-user-circle-o"></i><span class="hide-menu">My Lead (Digital)</span></a>
                            </li>

                            <li>
                                <a href="{{route('local.assignLead')}}"><i class="fa fa-share"></i><span class="hide-menu">Assign Lead (Digital)</span></a>
                            </li>

                            <li>
                                <a href="{{route('local.sales')}}"><i class="fa fa-dollar-sign"></i><span class="hide-menu"> Sales</span></a>
                            </li>
                        <li>
                                <a href="{{route('local.report')}}"><i class="fa fa-flag-checkered"></i><span class="hide-menu"> Report Digital</span></a>
                            </li>





                    </ul>
                </li>

                @endif       {{--End Local--}}

            @if(Auth::user()->crmType !='local'){{--Start Global--}}

                @if($userType =='USER' || $userType =='MANAGER' || $userType =='SUPERVISOR')
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
                        <li><a href="{{route('closelist')}}"><i class="fa fa-list-alt"></i><span class="hide-menu">Close List</span></a></li>
                        <li><a href="{{route('rejectlist')}}"><i class="fa fa-list-alt"></i><span class="hide-menu">Reject List</span></a></li>

                    </ul>
                </li>
                @endif


                @if($userType =='RA' || $userType =='MANAGER' || $userType =='SUPERVISOR' )
                <li>
                    <a href="{{route('assignShow')}}"><i class="fa fa-share"></i><span class="hide-menu">Assign Lead</span></a>
                </li>
                @endif

                @if($userType =='USER' || $userType =='MANAGER')

                <li>
                    <a href="{{route('myTeam')}}"><i class="fa fa-users"></i>
                        <span class="hide-menu">My Team</span></a>
                </li>

                @endif



                    <li class="treeview">
                        <a href="#"><i class="fa fa-flag-checkered" aria-hidden="true"></i> <span class="hide-menu">Report</span>
                            <span class="pull-right-container">
					<i class="fa fa-angle-left pull-right"></i>
					</span>
                        </a>
                        <ul class="treeview-menu">
                            <li>
                                <a href="{{route('report')}}"><i class="fa fa-signal"></i> <span class="hide-menu">Graph</span></a>
                            </li>
                            <li>
                                <a href="{{route('reportTable')}}"><i class="fa fa-table" aria-hidden="true"></i>
                                    <span class="hide-menu">Value</span></a>

                            </li>

                        </ul>
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







                {{--@if($userType =='RA' )--}}

                {{--@endif--}}

                @if($userType=='MANAGER')
                <li>
                    <a href="{{route('detached')}}"><i class="fa fa-eject" aria-hidden="true"></i><span class="hide-menu">Detach Lead</span></a>

                </li>
                @endif



                @if($userType=='ADMIN' || $userType=='SUPERVISOR' || $userType=='MANAGER')

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



                @endif

            @endif    {{--End Global--}}




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