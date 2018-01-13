<div class="page-content d-flex align-items-stretch">
    <!-- Side Navbar -->
    <nav class="side-navbar">
        <!-- Sidebar Header-->
        <div class="sidebar-header d-flex align-items-center">
            <div class="avatar"><img src="img/avatar-1.jpg" alt="..." class="img-fluid rounded-circle"></div>
            <div class="title">
                <h1 class="h4">Mark Stephen</h1>
                <p>Web Designer</p>
            </div>
        </div>
        <!-- Sidebar Navidation Menus--><span class="heading">Main</span>
        <ul class="list-unstyled">
            <li   class="{{ Request::is('main') ? 'active' : '' }} "><a href="/main"><span class="fa fa-calendar-check-o" aria-hidden="true"></span>Today's Follow Up</a></li>





            <li class="{{ Request::is('mylist') ? 'active' : '' }}"> <a href="/mylist"> <span class="fa fa-list-alt" aria-hidden="true"></span>My List </a></li>
            <li class="{{ Request::is('testlist') ? 'active' : '' }}"> <a href="/testlist"> <span class="fa fa-th-list" aria-hidden="true"></span>Test List </a></li>
            <li class="{{ Request::is('clients') ? 'active' : '' }}"> <a href="/clients"><span class="fa fa-address-card" aria-hidden="true"></span>Clients </a></li>
            <li class="{{ Request::is('leads') ? 'active' : '' }}"> <a href="/leads"> <span class="fa fa-phone-square" aria-hidden="true"></span>Leads & Contacts</a></li>
            <li class="{{ Request::is('starleads') ? 'active' : '' }}"> <a href="/starleads"> <span class="fa fa-star-half-o" aria-hidden="true"></span>Star Leads </a></li>
            <li class="{{ Request::is('newinfo') ? 'active' : '' }}"> <a href="/newinfo"> <span class="fa fa-plus-circle" aria-hidden="true"></span>New Info</a></li>

            <li class="{{ Request::is('lead/add') ? 'active' : '' }}"> <a href="/lead/add"> <span class="fa fa-plus-circle" aria-hidden="true"></span>Add Lead</a></li>


            <li class="{{ Request::is('assignreport') ? 'active' : '' }}"> <a href="/assignreport"><span class="fa fa-tasks" aria-hidden="true"></span>Assign Report</a></li>
            <li class="{{ Request::is('reports') ? 'active' : '' }}"> <a href="/reports"> Report</a></li>

            <li class="{{ Request::is('notices') ? 'active' : '' }}"> <a href="notices"> <span class="fa fa-bell" aria-hidden="true"></span>Notice Board</a></li>
            <li class="{{ Request::is('leaves') ? 'active' : '' }}"> <a href="/leaves"> <i class=""></i>Leave Show</a></li>
            <li class="{{ Request::is('myteam') ? 'active' : '' }}"> <a href="/myteam"> <i class=""></i>My Team</a></li>
            <li class="{{ Request::is('profile') ? 'active' : '' }}"> <a href="/profile"> <i class=""></i>Profile</a></li>





        </ul>

    </nav>