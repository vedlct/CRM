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
                                <p class="">Status: @if ($user->active == 1) <span style="color: green;">Active</span> @else <span style="color: red;">Active</span>Inactive @endif</p>
                                <p class="mb-1">Username: {{$user->userId}}</p>
                                <p class="mb-1">First Name: {{$user->firstName}}</p>
                                <p class="mb-1">Last Name: {{$user->lastName}}</p>
                                <p class="mb-1">Designation: @if ($user->designation) {{$user->designation->designationName}} @endif</p>
                                <p class="mb-1">Phone: {{$user->phoneNumber}}</p>
                                <p class="mb-1">Gender: @if ($user->gender == "M") Male @else Female @endif</p>
                                <p class="mb-1">DOB: {{ Carbon\Carbon::parse($user->dob)->format('F d, Y') }}</p>
                                <p class="mb-1">Email: {{$user->userEmail}}</p>

                                <a href="#edit_user_modal" data-toggle="modal" class="btn btn-info btn-sm"
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
                                       data-whitelist="{{$user->whitelist}}">
                                    <i class="fa fa-pencil-square-o" aria-hidden="true"></i>Edit Profile</a>


                                <a href="#change_password" data-toggle="modal" class="btn btn-warning"
                                        data-id="{{$user->id}}"
                                        data-user-id="{{$user->userId}}"
                                        data-password="{{$user->password}}">Password</a>     
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






        

            <!-- Edit Modal -->
            <div class="modal fade" id="edit_user_modal" >
                <div class="modal-dialog" style="max-width: 60%;">
                    <div class="modal-content">

                        <!-- Modal Header -->
                        <div class="modal-header">
                            <h4 class="modal-title">Update User's Info</h4>
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>

                        <!-- Modal body -->
                        <div class="modal-body">

                            <form class="form-horizontal" role="form" method="POST" action="{{ route('user-management.update', ['id' => 1]) }}" enctype="multipart/form-data">
                                <input type="hidden" name="_method" value="PUT">
                                {{ csrf_field() }}
                                <input id="id" type="hidden" class="form-control" name="id"  required>

                                <div class="row">

                                <div class="form-group col-md-4">
                                        <label for="typeId">User Type:</label>
                                        <select id="typeId"  name="typeId" class="form-control form-control-warning" required>

                                            @foreach ($userTypes as $userType)
                                                <option value="{{$userType->typeId}}">{{$userType->typeName}}</option>
                                            @endforeach
                                        </select>

                                        @if ($errors->has('typeId'))
                                            <span class="help-block">
				                				<strong>{{ $errors->first('typeId') }}</strong>
                							</span>
                                        @endif
                                    </div>


                                    <div class="form-group col-md-4">
                                        <label for="userId">User Id:</label>
                                        <input id="userId" type="text" class="form-control" name="userId" required>
                                        @if ($errors->has('userId'))
                                            <span class="help-block">
											<strong>{{ $errors->first('userId') }}</strong>
										</span>
                                        @endif
                                    </div>


                                    <div class="form-group col-md-4">
                                        <label for="rfID">RF Id:</label>
                                        <input id="rfID" type="number" class="form-control" name="rfID">

                                        @if ($errors->has('rfID'))
                                            <span class="help-block">
											<strong>{{ $errors->first('rfID') }}</strong>
										</span>
                                        @endif
                                    </div>


                                    <div class="form-group col-md-4">
                                        <label for="firstName">First Name:</label>

                                        <input id="firstName" type="text" class="form-control" name="firstName" required>

                                        @if ($errors->has('firstName'))
                                            <span class="help-block">
												<strong>{{ $errors->first('firstName') }}</strong>
											</span>
                                        @endif
                                    </div>


                                    <div class="form-group col-md-4">
                                        <label for="lastName">Last Name:</label>
                                        <input id="lastName" type="text" class="form-control" name="lastName" required>

                                        @if ($errors->has('lastName'))
                                            <span class="help-block">
											<strong>{{ $errors->first('lastName') }}</strong>
										</span>
                                        @endif
                                    </div>


                                    <div class="form-group col-md-4">
                                        <label for="userEmail">Email:</label>
                                        <input id="userEmail" type="email" class="form-control" name="userEmail" required>

                                        @if ($errors->has('userEmail'))
                                            <span class="help-block">
											<strong>{{ $errors->first('userEmail') }}</strong>
										</span>
                                        @endif
                                    </div>


                                    <div class="form-group col-md-4">
                                        <label for="phoneNumber">Phone Number:</label>
                                        <input id="phoneNumber" type="text" class="form-control" name="phoneNumber">
                                        @if ($errors->has('phoneNumber'))
                                            <span class="help-block">
											<strong>{{ $errors->first('phoneNumber') }}</strong>
										</span>
                                        @endif
                                    </div>


                                    <div class="form-group col-md-4">
                                        <label for="dob">Date Of Birth:</label>
                                        <input id="dob" type="text" class="form-control" name="dob">
                                        @if ($errors->has('dob'))
                                            <span class="help-block">
											<strong>{{ $errors->first('dob') }}</strong>
										</span>
                                        @endif
                                    </div>


                                    <div class="form-group col-md-4">
                                        <label for="picture">Picture:</label>
                                        <input id="picture" type="file" class="form-control" name="picture">
                                        @if ($errors->has('picture'))
                                            <span class="help-block">
											<strong>{{ $errors->first('picture') }}</strong>
										</span>
                                        @endif

                                    </div>

                                    <div class="form-group col-md-4">
                                        <label for="gender">Gender:</label>
                                        <select id="gender" name="gender" class="form-control form-control-warning">

                                            <option value="M">Male</option>
                                            <option value="F">Female</option>

                                        </select>
                                        @if ($errors->has('gender'))
                                            <span class="help-block">
											<strong>{{ $errors->first('gender') }}</strong>
										</span>
                                        @endif

                                    </div>

                                    <div class="form-group col-md-4">
                                        <label for="active">Status:</label>

                                        <select id="active" name="active" class="form-control form-control-warning">

                                            <option value="1">Active</option>
                                            <option value="0">Inactive</option>
                                        </select>

                                    </div>

                                    <div class="form-group col-md-4">
                                        <label for="active">Whitelist:</label>

                                        <select id="whitelist" name="whitelist" class="form-control form-control-warning">

                                            <option value="0">Black</option>
                                            <option value="1">white</option>
                                        </select>

                                    </div>

                                    <div class="form-group col-md-4">
                                        <label for="password">Password:</label>
                                        <input id="password" type="password" class="form-control" name="password">
                                        @if ($errors->has('password'))
                                            <span class="help-block">
											<strong>{{ $errors->first('password') }}</strong>
										</span>
                                        @endif
                                    </div>

                                    <div class="form-group col-md-4">
                                        <label for="password-confirm">Confirm Password:</label>
                                        <input id="password-confirm" type="password" class="form-control" name="password_confirmation">
                                    </div>



                                    <div class="form-group col-md-4">
                                        <button type="submit" class="btn btn-lg btn-success">
                                            Update
                                        </button>
                                    </div>
                                </div>

                            </form>

                        </div>

                        <!-- Modal footer -->
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                        </div>

                    </div>
                </div>
            </div>




            <!-- Change Password Modal -->
            <div class="modal fade" id="change_password" >
                <div class="modal-dialog" style="max-width: 40%;">
                    <div class="modal-content">

                        <div class="modal-header">
                            <h4 class="modal-title">Change Password</h4>
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>

                        <div class="modal-body">
                            <form class="form-horizontal" role="form" method="POST" action="{{ route('changePasswordUserEnd') }}" enctype="multipart/form-data">
                                <input type="hidden" name="_method" value="PUT">
                                {{ csrf_field() }}
                                <input id="user_id" type="text" class="form-control" name="id">

                                <div class="row">

                                <div class="form-group col-md-4">
                                        <label for="password">Password:</label>
                                        <input id="password" type="password" class="form-control" name="password">
                                        @if ($errors->has('password'))
                                            <span class="help-block">
											<strong>{{ $errors->first('password') }}</strong>
										</span>
                                        @endif
                                    </div>

                                    <div class="form-group col-md-4">
                                        <label for="password-confirm">Confirm Password:</label>
                                        <input id="password-confirm" type="password" class="form-control" name="password_confirmation">
                                    </div>


                                    <div class="form-group col-md-4"></br>
                                        <button type="submit" class="btn btn-success">
                                            Update
                                        </button>
                                    </div>
                                </div>

                            </form>

                        </div>

                        <!-- Modal footer -->
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                        </div>

                    </div>
                </div>
            </div>




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


$(document).ready(function() {

    $('#edit_user_modal').on('show.bs.modal', function(e) {

    //get data-id attribute of the clicked element
    var id = $(e.relatedTarget).data('id');
    var userId = $(e.relatedTarget).data('user-id');
    var typeId = $(e.relatedTarget).data('type-id');
    var rfID = $(e.relatedTarget).data('rf-id');
    var userEmail = $(e.relatedTarget).data('user-email');
    //var password = $(e.relatedTarget).data('password');
    var firstName = $(e.relatedTarget).data('first-name');
    var lastName = $(e.relatedTarget).data('last-name');
    var phoneNumber = $(e.relatedTarget).data('phone-number');
    var dob = $(e.relatedTarget).data('dob');
    var gender = $(e.relatedTarget).data('gender');
    var active = $(e.relatedTarget).data('active');
    var whitelist = $(e.relatedTarget).data('whitelist');

    //alert(userId);
    //populate the textbox
    $(e.currentTarget).find('#id').val(id);
    $(e.currentTarget).find('#userId').val(userId);
    $(e.currentTarget).find('#typeId').val(typeId);
    $(e.currentTarget).find('#rfID').val(rfID);
    $(e.currentTarget).find('#userEmail').val(userEmail);
    //$(e.currentTarget).find('#password').val(password);
    $(e.currentTarget).find('#firstName').val(firstName);
    $(e.currentTarget).find('#lastName').val(lastName);
    $(e.currentTarget).find('#phoneNumber').val(phoneNumber);
    $(e.currentTarget).find('#dob').val(dob);
    $(e.currentTarget).find('#gender').val(gender);
    $(e.currentTarget).find('#active').val(active);
    $(e.currentTarget).find('#whitelist').val(whitelist);

    });



        $('#change_password').on('show.bs.modal', function(e) {
            $('#change_password').on('show.bs.modal', function(e) {
                var id = $(e.relatedTarget).data('id');
                var userId = $(e.relatedTarget).data('user-id');

                $(e.currentTarget).find('#user_id').val(id);
                $(e.currentTarget).find('#userId').val(userId);
            });
        });
    });


        


        $( function() {
            $( "#dob" ).datepicker();
        } );



    
        


</script>

@endsection