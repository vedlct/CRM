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
                <li class="treeview">
                    <a href="#"><i class="fa fa-flag-checkered" aria-hidden="true"></i> <span
                            class="hide-menu">Report</span>
                        <span class="pull-right-container">
					<i class="fa fa-angle-left pull-right"></i>
					</span>
                    </a>
                    <ul class="treeview-menu">
                        <li>
                            <a href="{{route('reportGraph')}}"><i class="fa fa-signal"></i> <span class="hide-menu">Graph</span></a>
                        </li>
                        <li>
                            <a href="{{route('reportTable')}}"><i class="fa fa-table" aria-hidden="true"></i>
                                <span class="hide-menu">Value</span></a>
                        </li>
                        @if($userType == 'MANAGER')
                            @if(Auth::user()->areaType != "usa" )
                                <li>
                                    <a href="{{route('hour.report')}}"><i class="fa fa-houzz" aria-hidden="true"></i><span class="hide-menu">Hourly</span></a>
                                </li>
                            @endif

                        @endif

                        @if($userType == 'MANAGER' || $userType == 'SUPERVISOR' || $userType == 'ADMIN')
                            @if(Auth::user()->areaType != "usa" )
                                <li>
                                    <a href="{{ route('reportcountryTable') }}"><i class="fa fa-flag" aria-hidden="true"></i><span class="hide-menu">Country</span></a>
                                </li>
                            @endif
                        @endif

                        @if($userType =='SUPERVISOR')
                            <li>
                                <a href="{{route('report.tab')}}"><i class="fa fa-houzz"></i> <span class="hide-menu">Others</span></a>
                            </li>
                            <li>
                                <a href="{{route('follow-up.report')}}"><i class="fa fa-houzz" aria-hidden="true"></i><span class="hide-menu">Follow-up</span></a>
                            </li>
                            {{--<li>
                                <a href="{{route('reportCategory')}}"><i class="fa fa-hourglass-start"
                                                                         aria-hidden="true"></i>
                                    <span class="hide-menu">Category</span></a>
                            </li>
                            <li>
                                <a href="{{route('reportStatus')}}"><i class="fa fa-hourglass-start"
                                                                       aria-hidden="true"></i>
                                    <span class="hide-menu">Status</span></a>
                            </li>
                            <li>
                                <a href="{{route('reportCountry')}}"><i class="fa fa-hourglass-start"
                                                                        aria-hidden="true"></i>
                                    <span class="hide-menu">Country</span></a>
                            </li>--}}
                        @endif
                    </ul>
                </li>


                {{--Start For Global--}}
                @if(Auth::user()->crmType !='local')
                    @if($userType =='USER' || $userType=='MANAGER' || $userType=='SUPERVISOR')

                        <li>
                            <a href="{{route('assignedLeads')}}"><i class="fa fa-list"></i><span class="hide-menu">
                            Assigned Leads</span></a>
                        </li>
                    @endif


                    @if($userType=='SUPERVISOR' || $userType=='USER' || $userType=='MANAGER')

                        <li>
                            <a href="{{route('follow-up.index')}}"><i class="fa fa-calendar-o" aria-hidden="true"></i>
                                <span class="hide-menu">Todays Follow-up</span></a>
                        </li>
                        <li>
                            <a href="{{route('contacted')}}"><i class="fa fa-user-circle-o"></i><span class="hide-menu">Mylead</span></a>
                        </li>
                        <li>
                            <a href="{{route('Mycontacted')}}"><i class="fa fa-user-circle-o"></i><span
                                        class="hide-menu">My Contacted lead</span></a>
                        </li>
                    @endif


                    @if(Auth::user()->typeId !=10)

                        <li @if(Auth::user()->areaType == "usa") style="display: none" @endif>
                            <a href="{{route('filterLeads')}}"><i class="fa fa-filter"></i><span class="hide-menu">Filtered Leads</span></a>

                        </li>
                    @endif


                    @if($userType =='RA' || $userType =='MANAGER' || $userType =='SUPERVISOR' || $userType =='ADMIN' || $userType =='USER')

                        <li @if(Auth::user()->areaType == "usa" ) style="display: none" @endif>
                            <a href="{{route('tempLeads')}}"><i class="fa fa-text-width"></i><span class="hide-menu">Temp Leads</span></a>
                        </li>
                    @endif

                    @if( $userType =='MANAGER' || $userType =='SUPERVISOR' || $userType =='ADMIN' || $userType =='HR' || $userType =='RA'    )
                        <li @if(Auth::user()->areaType == "usa" ) style="display: none" @endif>
                            <a href="{{route('addLead')}}"><i class="fa fa-plus"></i><span
                                        class="hide-menu">All Lead</span></a>

                        </li>

                    @endif


                    <li >
                        <a href="{{route('verifylead')}}"><i class="fa fa-plus"></i><span
                                    class="hide-menu">Verify Lead</span></a>

                    </li>
                    @if(Auth::user()->id == 19)

                        <li>
                            <a href="{{route('showrelease')}}"><i class="fa fa-adjust"></i><span class="hide-menu">Release Lead</span></a>

                        </li>
                    @endif

                    @if(Auth::user()->areaType == "usa")

                        <li>
                            <a href="{{route('addNightShift')}}"><i class="fa fa-adjust"></i><span class="hide-menu">Add Lead</span></a>

                        </li>
                    @endif


                @endif  {{--End For Global--}}

                @if($userType =='ADMIN' )        {{--Start Local--}}

                <li class="treeview">
                    <a href="#"><i class="fa fa-map" aria-hidden="true"></i> <span
                                class="hide-menu">Digital Marketing</span>
                        <span class="pull-right-container">
					  <i class="fa fa-angle-left pull-right"></i>
					</span>
                    </a>
                    <ul class="treeview-menu">
                        @endif

                        @if( Auth::user()->crmType =='local' )

                            <li>
                                <a href="{{route('local.allLead')}}"><i class="fa fa-plus"></i><span class="hide-menu">All Lead (Digital)</span></a>
                            </li>
                            <li>
                                <a href="{{route('local.company')}}"><i class="fa fa-plus"></i><span class="hide-menu">All Company (Digital)</span></a>
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
                                <a href="{{route('local.sales')}}"><i class="fa fa-money"></i><span class="hide-menu"> Sales</span></a>
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

                @endif       {{--End Local--}}
                {{--                @if(Auth::user()->typeId==1 || Auth::user()->typeId==2)--}}
                {{--                    --}}
                {{--                @endif--}}

                @if(Auth::user()->crmType !='local'){{--Start Global--}}

                @if($userType =='USER' || $userType =='MANAGER' || $userType =='SUPERVISOR')
                    <li class="treeview">
                        <a href="#"><i class="fa fa-link"></i> <span class="hide-menu">My List</span><span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i>
					</span>
                        </a>
                        <ul class="treeview-menu">
                            <li>
                                <a href="{{route('starLeads')}}"><i class="fa fa-star"></i><span class="hide-menu">Star Leads</span></a>
                            </li>
                            <li>
                                <a href="{{route('clientLeads')}}"><i class="fa fa-star"></i><span class="hide-menu">Client Leads</span></a>
                            </li>
                            <li><a href="{{route('testlist')}}"><i class="fa fa-list-alt"></i><span class="hide-menu">Test List</span></a>
                            </li>
                            <li><a href="{{route('closelist')}}"><i class="fa fa-list-alt"></i><span class="hide-menu">Close List</span></a>
                            </li>
                            <li><a href="{{route('rejectlist')}}"><i class="fa fa-list-alt"></i><span class="hide-menu">Reject List</span></a>
                            </li>

                        </ul>
                    </li>
                @endif


                @if($userType =='RA' || $userType =='MANAGER' || $userType =='SUPERVISOR' )
                    @if(Auth::user()->areaType != "usa" )
                    <li>
                        <a href="{{route('assignShow')}}"><i class="fa fa-share"></i><span class="hide-menu">Assign Lead</span></a>
                    </li>
                    @endif
                @endif
                @if( $userType =='MANAGER' || $userType =='SUPERVISOR' || $userType =='ADMIN' )
                <li>
                    <a href="{{route('assignAllShow')}}"><i class="fa fa-share"></i><span class="hide-menu">Assign Random Lead</span></a>
                </li>
                 @endif

                @if($userType =='USER' || $userType =='MANAGER')
                    <li @if(Auth::user()->areaType == "usa" ) style="display: none" @endif>
                        <a href="{{route('myTeam')}}"><i class="fa fa-users"></i>
                            <span class="hide-menu">My Team</span></a>
                    </li>

                @endif


                @if($userType =='SUPERVISOR')
                    @if(Auth::user()->areaType != "usa" )
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
                @endif

                {{--@if($userType =='RA' )--}}

                {{--@endif--}}

{{--                @if($userType=='MANAGER')--}}
{{--                    @if(Auth::user()->areaType != "usa" )--}}
{{--                    <li>--}}
{{--                        <a href="{{route('detached')}}"><i class="fa fa-eject" aria-hidden="true"></i><span class="hide-menu">Detach Lead</span></a>--}}

{{--                    </li>--}}
{{--                    @endif--}}
{{--                @endif--}}

                @if($userType=='ADMIN' || $userType=='SUPERVISOR' || $userType=='MANAGER' || $userType=='HR')
                    @if(Auth::user()->areaType != "usa" )
                    <li>
                        <a href="{{route('user-management.index')}}"><i class="fa fa-users" aria-hidden="true"></i><span class="hide-menu">User Management</span></a>
                    </li>
                    <li>
                        <a href="{{route('user-management.target')}}"><i class="fa fa-bullseye"></i><span class="hide-menu">Monthly Target Log</span></a>
                    </li>
                @endif
                @endif

                @if(Auth::user()->typeId !=10)

                    <li @if(Auth::user()->areaType == "usa" ) style="display: none" @endif>
                        <a href="{{ route('notice.index') }}"><i class="fa fa-plus-square"></i><span class="hide-menu">Notice</span></a>
                    </li>

                @endif

                @if($userType =='ADMIN' )
                    <li><a href="{{route('system')}}"> <i class="fa fa-wrench" aria-hidden="true"></i><span class="hide-menu">System</span></a></li>
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
