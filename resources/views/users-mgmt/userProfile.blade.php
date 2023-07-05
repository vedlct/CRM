@extends('main')


@section('content')
    <!-- ============================================================== -->
    <!-- Start Page Content here -->
    <!-- ============================================================== -->
    
    @php($user_Type = Session::get('userType'))


    <div class="content-page">
        <div class="content">
            <!-- Start Content-->
            <div class="container-fluid">
                <!-- start page title -->
                <div class="row">
                    <div class="col-12">
                        <div class="page-title-box">
                            <!-- <h4 class="page-title">User details</h4> -->
                        </div>
                    </div>
                </div>
                <!-- end page title -->

                <!-- table start -->
                <div class="row">
                    <!-- user details -->
                    <div class="col-sm-4 col-xl-2">
                        <div class="card">
                            <div class="card-body">


                                <p class="text-center">
                                    <img src="{{ url('public/img/users/default.jpg') }}" alt="" class="img-fluid">
                                </p>
                                <p class="mb-1">Username: {{$user->userId}}</p>
                                <p class="mb-1">First Name: {{$user->firstName}}</p>
                                <p class="mb-1">Last Name: {{$user->lastName}}</p>
                                <p class="mb-1">Designation: @if ($user->designation) {{$user->designation->designationName}} @endif</p>
                                <p class="mb-1">Email: {{$user->userEmail}}</p>
                                <p class="mb-1">Phone: {{$user->phoneNumber}}</p>
                                <p class="mb-1">Gender: @if ($user->gender == "M") Male @else Female @endif</p>
                                <p class="">Status: @if ($user->active == 1) Active @else Inactive @endif</p>

                                <a href="#edit_user_modal" data-toggle="modal" class="btn btn-primary"
                                       data-id="{{$user->id}}"
                                       data-user-id="{{$user->userId}}"
                                       data-type-id="{{$user->typeId}}"
                                       data-rf-id="{{$user->rfID}}"
                                       data-user-email="{{$user->userEmail}}"
                                       data-password="{{$user->password}}"
                                       data-first-name="{{$user->firstName}}"
                                       data-last-name="{{$user->lastName}}"
                                       data-phone-number="{{$user->phoneNumber}}"
                                       data-dob="{{$user->dob}}"
                                       data-gender="{{$user->gender}}"
                                       data-active="{{$user->active}}"
                                       data-whitelist="{{$user->whitelist}}"
                                        >Edit Profile</a>
                               

                                @if($user_Type == 'ADMIN' || 'SUPERVISOR')
                                <a href="#target_user_modal" data-toggle="modal" class="btn btn-info"
                                       data-id="{{$user->id}}"
                                       data-first-name="{{$user->userId}}"
                                       data-target-call="{{$user->target['targetCall']}}"
                                       data-target-high="{{$user->target['targetHighPossibility']}}"
                                       data-target-lead="{{$user->target['targetLeadmine']}}"
                                       data-target-contact="{{$user->target['targetContact']}}"
                                       data-target-contactusa="{{$user->target['targetUsa']}}"
                                       data-target-test="{{$user->target['targetTest']}}"
                                       data-target-file="{{$user->target['targetFile']}}"
                                       data-target-conversation="{{$user->target['conversation']}}"
                                       data-target-closelead="{{$user->target['closelead']}}"
                                       data-target-followup="{{$user->target['followup']}}"                                
                                        >Set Target</a>
                                @endif        
                            </div>
                        </div>
                    </div>

                    <!-- user report and others -->
                    <div class="col-sm-8 col-xl-10">
                        <div class="card">
                            <div class="card-body">
                                <ul class="nav nav-tabs border-tab mb-0" id="top-tab" role="tablist">
                                    <li class="nav-item"><a class="nav-link active" data-bs-toggle="tab" href="#report" id="report-tab" role="tab" aria-selected="false">Reports</a>
                                        <div class="material-border"></div>
                                    </li>
                                    <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#comment" id="comment-tab"  role="tab" aria-selected="false">Comments</a>
                                        <div class="material-border"></div>
                                    </li>
                                    <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#ippList" id="ippList-tab" role="tab" aria-selected="true">IPP List</a>
                                        <div class="material-border"></div>
                                    </li>
                                </ul>
                                <div class="tab-content" id="top-tabContent">
                                    <div class="tab-pane fade active show" id="report" role="tabpanel">
                                        <div class="row">
                                            <div class="col-sm-6 col-lg-3">
                                                <div class="card bg-light">
                                                    <div class="card-body">
                                                        <div class="row">
                                                            <div class="col-6">
                                                                <div class="avatar-md bg-success rounded">
                                                                    <i class="fe-phone avatar-title font-22 text-white"></i>
                                                                </div>
                                                            </div>

                                                            <div class="col-6">
                                                                <div class="text-end">
                                                                    <h3 class="text-dark my-1">
                                                                        <span data-plugin="counterup">1</span>
                                                                    </h3>
                                                                    <p class="text-muted mb-0 text-truncate">
                                                                        Total Call
                                                                    </p>
                                                                </div>
                                                            </div>
                                                            
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- end card-->
                                            </div>
                                            <div class="col-sm-6 col-lg-3">
                                                <div class="card bg-light">
                                                    <div class="card-body">
                                                        <div class="row">
                                                            <div class="col-6">
                                                                <div class="avatar-md bg-blue rounded">
                                                                    <i class="fe-users avatar-title font-22 text-white"></i>
                                                                </div>
                                                            </div>
                                                            <div class="col-6">
                                                                <div class="text-end">
                                                                    <h3 class="text-dark my-1">
                                                                        <span data-plugin="counterup">2/4</span>
                                                                    </h3>
                                                                    <p class="text-muted mb-0 text-truncate">Contact</p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- end card-->
                                            </div>
                                            <div class="col-sm-6 col-lg-3">
                                                <div class="card bg-light">
                                                    <div class="card-body">
                                                        <div class="row">
                                                            <div class="col-6">
                                                                <div class="avatar-md bg-danger rounded">
                                                                    <i class="fe-phone avatar-title font-22 text-white"></i>
                                                                </div>
                                                            </div>
                                                            <div class="col-6">
                                                                <div class="text-end">
                                                                    <h3 class="text-dark my-1">
                                                                        <span data-plugin="counterup">6</span>
                                                                    </h3>
                                                                    <p class="text-muted mb-0 text-truncate">
                                                                        Lead Mined
                                                                    </p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- end card-->
                                            </div>
                                            <div class="col-sm-6 col-lg-3">
                                                <div class="card bg-light">
                                                    <div class="card-body">
                                                        <div class="row">
                                                            <div class="col-6">
                                                                <div class="avatar-md bg-warning rounded">
                                                                    <i class="fe-delete avatar-title font-22 text-white"></i>
                                                                </div>
                                                            </div>
                                                            <div class="col-6">
                                                                <div class="text-end">
                                                                    <h3 class="text-dark my-1">
                                                                        <span data-plugin="counterup">3</span>
                                                                    </h3>
                                                                    <p class="text-muted mb-0 text-truncate">
                                                                        Test
                                                                    </p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- end card-->
                                            </div>
                                            <div class="col-sm-6 col-lg-3">
                                                <div class="card bg-light">
                                                    <div class="card-body">
                                                        <div class="row">
                                                            <div class="col-6">
                                                                <div class="avatar-md bg-primary rounded">
                                                                    <i class="fe-delete avatar-title font-22 text-white"></i>
                                                                </div>
                                                            </div>
                                                            <div class="col-6">
                                                                <div class="text-end">
                                                                    <h3 class="text-dark my-1">
                                                                        <span data-plugin="counterup">3</span>
                                                                    </h3>
                                                                    <p class="text-muted mb-0 text-truncate">
                                                                        Followup
                                                                    </p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- end card-->
                                            </div>
                                            <div class="col-sm-6 col-lg-3">
                                                <div class="card bg-light">
                                                    <div class="card-body">
                                                        <div class="row">
                                                            <div class="col-6">
                                                                <div class="avatar-md bg-danger rounded">
                                                                    <i class="fe-delete avatar-title font-22 text-white"></i>
                                                                </div>
                                                            </div>
                                                            <div class="col-6">
                                                                <div class="text-end">
                                                                    <h3 class="text-dark my-1">
                                                                        <span data-plugin="counterup">3</span>
                                                                    </h3>
                                                                    <p class="text-muted mb-0 text-truncate">
                                                                        Test
                                                                    </p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- end card-->
                                            </div>
                                            <div class="col-sm-6 col-lg-3">
                                                <div class="card bg-light">
                                                    <div class="card-body">
                                                        <div class="row">
                                                            <div class="col-6">
                                                                <div class="avatar-md bg-primary rounded">
                                                                    <i class="fe-user avatar-title font-22 text-white"></i>
                                                                </div>
                                                            </div>
                                                            <div class="col-6">
                                                                <div class="text-end">
                                                                    <h3 class="text-dark my-1">
                                                                        <span data-plugin="counterup">3</span>
                                                                    </h3>
                                                                    <p class="text-muted mb-0 text-truncate">
                                                                        Client
                                                                    </p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- end card-->
                                            </div>
                                            <div class="col-12">
                                                <h4 class="header-title mb-3">December, 2022</h4>
                                                <div class="table-responsive">
                                                    <table class="table table-bordered">
                                                        <thead class="table-primary">
                                                        <tr>
                                                            <th></th>
                                                            <th>Total call</th>
                                                            <th>Contact</th>
                                                            <th>Lead</th>
                                                            <th>Followup</th>
                                                            <th>Test</th>
                                                        </tr>
                                                        </thead>

                                                        <tbody>
                                                        <tr>
                                                            <th>Target</th>
                                                            <td>434</td>
                                                            <td>77</td>
                                                            <td>566</td>
                                                            <td>34</td>
                                                            <td>43</td>
                                                        </tr>
                                                        <tr>
                                                            <th>Achievement</th>
                                                            <td>434</td>
                                                            <td>77</td>
                                                            <td>566</td>
                                                            <td>34</td>
                                                            <td>43</td>
                                                        </tr>
                                                        <tr>
                                                            <th>%</th>
                                                            <td>56%</td>
                                                            <td>33%</td>
                                                            <td>86%</td>
                                                            <td>42%</td>
                                                            <td>89%</td>
                                                        </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <h4 class="header-title mb-3">January, 2022</h4>
                                                <div class="table-responsive">
                                                    <table class="table table-bordered">
                                                        <thead class="table-primary">
                                                        <tr>
                                                            <th></th>
                                                            <th>Total call</th>
                                                            <th>Contact</th>
                                                            <th>Lead</th>
                                                            <th>Followup</th>
                                                            <th>Test</th>
                                                        </tr>
                                                        </thead>

                                                        <tbody>
                                                        <tr>
                                                            <th>Target</th>
                                                            <td>434</td>
                                                            <td>77</td>
                                                            <td>566</td>
                                                            <td>34</td>
                                                            <td>43</td>
                                                        </tr>
                                                        <tr>
                                                            <th>Achievement</th>
                                                            <td>434</td>
                                                            <td>77</td>
                                                            <td>566</td>
                                                            <td>34</td>
                                                            <td>43</td>
                                                        </tr>
                                                        <tr>
                                                            <th>%</th>
                                                            <td>56%</td>
                                                            <td>33%</td>
                                                            <td>86%</td>
                                                            <td>42%</td>
                                                            <td>89%</td>
                                                        </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- notes tab -->
                                    <div class="tab-pane fade" id="comment" role="tabpanel">
                                        <div class="alert alert-primary p-2">
                                            <h4>By Riz</h4>
                                            <p class="text-dark mb-2">Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
                                            <div class="media mb-0">
                                                <div class="media-body">
                                                    <p class="mb-1">6 July 2022 3:50 PM | Tech cloud ltd. | Calling report</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="alert alert-primary p-2">
                                            <h4>By Riz</h4>
                                            <p class="text-dark mb-2">Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
                                            <div class="media mb-0">
                                                <div class="media-body">
                                                    <p class="mb-1">6 July 2022 3:50 PM | Tech cloud ltd. | Calling report</p>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                    <!-- contacts tab -->
                                    <div class="tab-pane fade" id="ippList" role="tabpanel">
                                        <div class="table-responsive">
                                            <table class="table table-bordered">
                                                <thead class="table-primary">
                                                <tr>
                                                    <th>Company</th>
                                                    <th>Category</th>
                                                    <th>Country</th>
                                                    <th>Last update</th>
                                                    <th>Action</th>
                                                </tr>
                                                </thead>

                                                <tbody>
                                                <tr>
                                                    <td>Foodpeon</td>
                                                    <td>Food delivery</td>
                                                    <td>BD</td>
                                                    <td>1 Dec 2022</td>
                                                    <td><a href="#"><i class="fa fa-eye"></i></a></td>
                                                </tr>

                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                    <!-- end col -->
                </div>
                <!-- end table -->
            </div>
            <!-- container -->
        </div>
        <!-- content -->
@endsection

@section('footer.js')

<script src="{{url('assets/plugins/datatables/jquery.dataTables.min.js')}}"></script>

<script src="{{url('cdn.datatables.net/buttons/1.2.2/js/dataTables.buttons.min.js')}}"></script>
<script src="{{url('cdn.datatables.net/buttons/1.2.2/js/buttons.flash.min.js')}}"></script>


<script src="{{url('cdn.datatables.net/buttons/1.2.2/js/buttons.html5.min.js')}}"></script>

<script src="{{url('js/jconfirm.js')}}"></script>

<meta name="csrf-token" content="{{ csrf_token() }}" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js" integrity="sha512-AA1Bzp5Q0K1KanKKmvN/4d3IRKVlv9PYgwFPvm32nPO6QS8yH1HO7LbgB1pgiOxPtfeg5zEn2ba64MUcqJx6CA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
    //CHANGE THE TABS 

    var reportTabLink = document.getElementById('report-tab');
    var tab = new bootstrap.Tab(reportTabLink);
    tab.show();



</script>

@endsection