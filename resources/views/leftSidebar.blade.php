@php($userType = Session::get('userType'))

<aside class="left-sidebar">
    <!-- Sidebar scroll-->
    <div class="scroll-sidebar">
        <!-- User profile -->
        <div class="user-profile">
            <!-- User profile image -->
        {{--<div class="profile-img"> <img src="{{url('img/'.Auth::user()->picture)}}" alt="user" /> </div>--}}
        <!-- User profile text-->
            <div class="profile-text">
                {{( Auth::user()->firstName )}} {{( Auth::user()->lastName )}} </br>
                UserId: {{(Auth::user()->userId )}}
            </div>
        </div>
        <!-- End User profile text-->
        <!-- Sidebar navigation-->
        <nav class="sidebar-nav">
            <ul id="sidebarnav">

                <li class="nav-devider"></li>

                <li role="separator" class="divider"></li>

                <li>
                    <a href="{{route('home')}}"><i class="mdi mdi-gauge" aria-hidden="true"></i>
                        <span class="hide-menu">Dashboard</span></a>
                </li>


                <li>
                    <a href="{{route('analysisHomePage')}}"><i class="fa fa-superpowers"></i>
                    <span class="hide-menu"> Analysis Tools</span></a>
                </li>

                <li>
                    <a href="{{ route('notice.index') }}"><i class="fa fa-bullhorn"></i>
                        <span class="hide-menu">Communication</span></a>
                </li>


                @if($userType=='SUPERVISOR' || $userType=='USER' || $userType=='MANAGER')

                <li class="treeview">
                    <a href="#"><i class="fa fa-user-circle-o" aria-hidden="true"></i> <span
                        class="hide-menu">My Leads</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-right pull-right"></i>
                    </span>
                    </a>
                    <ul class="treeview-menu">
                        <li>
                            <a href="{{route('contacted')}}"><i class="fa fa-circle-o"></i>
                            <span class="hide-menu"> My Leads</span></a>
                        </li>
                        <li>
                            <a href="{{route('follow-up.index')}}"><i class="fa fa-calendar-o" aria-hidden="true"></i>
                                <span class="hide-menu"> My Followups</span></a>
                        </li>
                        <li>
                            <a href="{{route('Mycontacted')}}"><i class="fa fa-user-circle-o"></i>
                            <span class="hide-menu"> Contacted Leads</span></a>
                        </li>
                        <li>
                            <a href="{{route('assignedLeads')}}"><i class="fa fa-list"></i>
                            <span class="hide-menu"> Assigned to Me</span></a>
                        </li>
                    </ul>
                </li>

                @endif



                        <li class="treeview">
                        <a href="#"><i class="fa fa-folder" aria-hidden="true"></i> <span
                                class="hide-menu">Directory</span>
                            <span class="pull-right-container">
                                <i class="fa fa-angle-right pull-right"></i>
                            </span>
                        </a>
                        <ul class="treeview-menu">
        
                            @if( $userType =='SUPERVISOR' || $userType =='ADMIN' || $userType =='RA'    )
                            <li>
                                <a href="{{route('addLead')}}"><i class="fa fa-plus"></i>
                                    <span class="hide-menu">All Leads</span></a>
                            </li>
                            @endif
        
                            <li >
                                <a href="{{route('verifylead')}}"><i class="fa fa-plus"></i>
                                    <span class="hide-menu">Verify Lead</span></a>
                            </li>

                            <li>
                                <a href="{{route('filterLeads')}}"><i class="fa fa-filter"></i>
                                    <span class="hide-menu">Filtered Leads</span></a>
                            </li>

                            <li>
                                <a href="{{route('getAllemployees')}}"><i class="fa fa-users"></i>
                                <span class="hide-menu"> All Contacts</span></a>
                            </li>

                        </ul>
                    </li>


                    <li class="treeview">
                        <a href="#"><i class="fa fa-search" aria-hidden="true"></i> <span
                                class="hide-menu">Lead Mining</span>
                            <span class="pull-right-container">
                                <i class="fa fa-angle-right pull-right"></i>
                            </span>
                        </a>
                            <ul class="treeview-menu">

                                <li>
                                    <a href="{{route('googleSearch')}}"><i class="fa fa-google" aria-hidden="true"></i>
                                        <span class="hide-menu"> Google Search</span></a>
                                </li>
                                <li>
                                    <a href="{{route('crawlWebsites')}}"><i class="fa fa-recycle" aria-hidden="true"></i>
                                        <span class="hide-menu"> Crawl Website</span></a>
                                </li>

                                <li>
                                    <a href="{{route('keywordAnalysis')}}"><i class="fa fa-key" aria-hidden="true"></i>
                                        <span class="hide-menu"> All Keywords</span></a>
                                </li>

                                <li>
                                    <a href="{{route('addNightShift')}}"><i class="fa fa-adjust"></i>
                                        <span class="hide-menu">Add Lead</span></a>
                                </li>


                            </ul>
                    </li>

                


                @if(Auth::user()->crmType !='local')
                
                @if($userType =='USER' || $userType =='MANAGER' || $userType =='SUPERVISOR')
                    <li class="treeview">
                        <a href="#"><i class="fa fa-link"></i> <span class="hide-menu">My List</span>
                        <span class="pull-right-container"><i class="fa fa-angle-right pull-right"></i>
					</span>
                        </a>
                        <ul class="treeview-menu">
                            <li>
                                <a href="{{route('starLeads')}}"><i class="fa fa-star"></i>
                                <span class="hide-menu">Star Leads</span></a>
                            </li>
                            <li>
                                <a href="{{route('clientLeads')}}"><i class="fa fa-star"></i>
                                <span class="hide-menu">Client Leads</span></a>
                            </li>
                            <li><a href="{{route('testlist')}}"><i class="fa fa-list-alt"></i>
                            <span class="hide-menu">Test List</span></a>
                            </li>
                            <li><a href="{{route('closelist')}}"><i class="fa fa-list-alt"></i>
                            <span class="hide-menu">Close List</span></a>
                            </li>
                            <li><a href="{{route('rejectlist')}}"><i class="fa fa-list-alt"></i>
                            <span class="hide-menu">Reject List</span></a>
                            </li>
                        </ul>
                    </li>
                @endif


                @if( $userType =='MANAGER' || $userType =='SUPERVISOR' || $userType =='ADMIN' )
                <li class="treeview">
                    <a href="#"><i class="fa fa-share" aria-hidden="true"></i> <span
                            class="hide-menu">Assign Leads</span>
                        <span class="pull-right-container">
    	    				<i class="fa fa-angle-right pull-right"></i>
	    				</span>
                    </a>
                    <ul class="treeview-menu">
                            <li>
                                <a href="{{route('assignAllShow')}}"><i class="fa fa-share"></i>
                                <span class="hide-menu">Assign Marketers' Lead</span></a>
                                </li>
                            <li>
                                <a href="{{route('assignShow')}}"><i class="fa fa-share"></i>
                                <span class="hide-menu">Assign Filtered Lead</span></a>
                            </li>
                    </ul>
                </li>
                @endif



                @if($userType =='USER' || $userType =='MANAGER')
                    <li>   
                        <a href="{{route('myTeam')}}"><i class="fa fa-users"></i>
                            <span class="hide-menu">My Team</span></a>
                    </li>

                @endif



                <li class="treeview">
                    <a href="#"><i class="fa fa-flag-checkered" aria-hidden="true"></i> <span
                            class="hide-menu">Report</span>
                        <span class="pull-right-container">
					<i class="fa fa-angle-right pull-right"></i>
					</span>
                    </a>
                    <ul class="treeview-menu">
                        <li>
                            <a href="{{route('reportTable')}}"><i class="fa fa-table" aria-hidden="true"></i>
                            <span class="hide-menu"> Table</span></a>
                        </li>


                        @if($userType == 'SUPERVISOR' || $userType == 'MANAGER' || $userType == 'ADMIN')
                            <li>
                                <a href="{{route('hour.report')}}"><i class="fa fa-houzz" aria-hidden="true"></i>
                                <span class="hide-menu">Hourly</span></a>
                            </li>
                            <li>
                                <a href="{{ route('reportcountryTable') }}"><i class="fa fa-flag" aria-hidden="true"></i>
                                <span class="hide-menu"> Country</span></a>
                            </li>

                            <li>
                                <a href="{{route('follow-up.report')}}"><i class="fa fa-houzz" aria-hidden="true"></i>
                                <span class="hide-menu"> Follow-up</span></a>
                            </li>
                            <li>
                                <a href="{{route('report.tab')}}"><i class="fa fa-houzz"></i>
                                <span class="hide-menu"> Others</span></a>
                            </li>
                        @endif
                    </ul>
                </li>




                @if($userType =='SUPERVISOR' || $userType =='ADMIN')
                    @if(Auth::user()->areaType != "usa" )

                    <li class="treeview">
                        <a href="#"><i class="fa fa-cog" aria-hidden="true"></i> <span class="hide-menu">Settings</span>
                            <span class="pull-right-container">
					  <i class="fa fa-angle-right pull-right"></i>
					</span>
                        </a>
                        <ul class="treeview-menu">
                            <li>
                                <a href="{{route('user-management.index')}}"><i class="fa fa-users" aria-hidden="true"></i>
                                <span class="hide-menu">User Management</span></a>
                            </li>

                            <li>
                                <a href="{{route('user-management.target')}}"><i class="fa fa-bullseye"></i>
                                <span class="hide-menu">Monthly Target Log</span></a>
                            </li>
                            
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
                @endif


                @if($userType =='ADMIN' )
                    <li><a href="{{route('system')}}"> <i class="fa fa-wrench" aria-hidden="true"></i>
                    <span class="hide-menu">System</span></a></li>
                @endif

                @endif    
                              
            {{--END GLOBAL CRM MENU--}}





    {{--LOCAL CRM SIDE MENU--}}
    
        @if($userType =='ADMIN' )        

                <li class="treeview">
                    <a href="#"><i class="fa fa-map" aria-hidden="true"></i> <span
                                class="hide-menu">Digital Marketing</span>
                        <span class="pull-right-container">
					  <i class="fa fa-angle-right pull-right"></i>
					</span>
                    </a>
                    <ul class="treeview-menu">
                        @endif

                        @if( Auth::user()->crmType =='local' )

                            <li>
                                <a href="{{route('local.allLead')}}"><i class="fa fa-plus"></i>
                                <span class="hide-menu">All Lead (Digital)</span></a>
                            </li>
                            <li>
                                <a href="{{route('local.company')}}"><i class="fa fa-plus"></i>
                                <span class="hide-menu">All Company (Digital)</span></a>
                            </li>


                            @if(!(Auth::user()->typeId==9))
                                <li>
                                    <a href="{{route('local.todaysFollowup')}}"><i class="fa fa-calendar-o"></i><span
                                                class="hide-menu">Todays Followup (Digital)</span></a>
                                </li>
                                <li>
                                    <a href="{{route('local.myLead')}}"><i class="fa fa-user-circle-o"></i><span
                                                class="hide-menu">My Lead (Digital)</span></a>
                                </li>
                            @endif
                            @if(Auth::user()->typeId==1 || Auth::user()->typeId==6 ||Auth::user()->typeId==7)
                                <li>
                                    <a href="{{route('local.assignLead')}}"><i class="fa fa-share"></i><span
                                                class="hide-menu">Assign Lead (Digital)</span></a>
                                </li>
                            @endif



                            <li>
                                <a href="{{route('local.sales')}}"><i class="fa fa-money"></i>
                                <span class="hide-menu"> Sales</span></a>
                            </li>


                            <li>
                                <a href="{{route('local.report')}}"><i class="fa fa-flag-checkered"></i><span
                                            class="hide-menu"> Report Digital</span></a>
                            </li>
                        @endif


                        @if($userType =='ADMIN' )
                            <li>
                                <a href="{{route('local.report')}}"><i class="fa fa-flag-checkered"></i><span
                                            class="hide-menu"> Report Digital</span></a>
                            </li>

                    </ul>
                </li>

                @endif


                <li class="nav-devider"></li>

                <li role="separator" class="divider"></li>
                <li><a href="{{route('accountSetting')}}">
					<i class="ti-settings"></i>My Profile</a></li>

				<li><a href="{{ route('logout') }}"
				   onclick="event.preventDefault();
					document.getElementById('logout-form').submit();" class="link" data-toggle="tooltip" title="Logout">
					<i class="mdi mdi-power"></i>Log Out</a></li>

            </ul>
        </nav>
        <!-- End Sidebar navigation -->
    </div>
    <!-- End Sidebar scroll-->
    <!-- Bottom points-->
    <!--<div class="sidebar-footer">

        <a href="{{ route('logout') }}"
           onclick="event.preventDefault();
            document.getElementById('logout-form').submit();" class="link" data-toggle="tooltip" title="Logout">

            <i class="mdi mdi-power"></i></a>-->

    </div>
    <!-- End Bottom points-->
</aside>
