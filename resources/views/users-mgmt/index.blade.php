@extends('main')

@section('content')
    <div class="box-body">
        <div class="card" style="padding: 2px;">
            <div class="card-body">
                <h2 style="display: inline-block; margin: 0px 200px;">List of users</h2>
                {{--<a class="btn btn-primary" href="{{ route('user-management.create') }}">Add new user</a>--}}
                @php($userType = Session::get('userType'))

                @if($userType=='ADMIN')

                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal">
                    Add new user
                </button>
                @endif


                <div class="table-responsive m-t-40" >
                    <table id="myTable" class="table table-striped table-condensed" style="font-size:14px;">
                        <thead>
                        <tr>
                            <th>User Name</th>
                            <th>Email</th>
                            <th>First Name</th>
                            <th>Last Name</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($users as $user)
                            <tr>
                                <td>{{ $user->userId }}</td>
                                <td>{{ $user->userEmail }}</td>
                                <td>{{ $user->firstName }}</td>
                                <td>{{ $user->lastName }}</td>
                                <td >
                                    @if ($user->active == 1)Active
                                    @elseif ($user->active == 0)Inactive
                                    @endif
                                </td>
                                <td>
                                    <!-- Trigger the Edit modal with a button -->
                                    @if($userType=='ADMIN')
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
                                       data-active="{{$user->active}}">
                                    <i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                                    @endif


                                    @if($user->crmType =='local')

                                    @else

                                    <a href="#target_user_modal" data-toggle="modal" class="btn btn-success btn-sm"
                                       data-id="{{$user->id}}"
                                       data-first-name="{{$user->userId}}"
                                       data-target-call="{{$user->target['targetCall']}}"
                                       data-target-high="{{$user->target['targetHighPossibility']}}"
                                       data-target-lead="{{$user->target['targetLeadmine']}}"
                                       data-target-contact="{{$user->target['targetContact']}}"
                                       data-target-contactusa="{{$user->target['targetUsa']}}"
                                       {{--data-target-type="{{$user->crmType}}"--}}
                                    ><i class="fa fa-angle-double-up"></i></a>

                                    @endif

                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>





    {{--Set Target Modal--}}
            <div class="modal fade" id="target_user_modal" >
                <div class="modal-dialog" style="max-width: 60%;">
                    <div class="modal-content">
            <form method="post" action="{{route('setTarget')}}">
                {{csrf_field()}}
                    <input type="hidden" name="userId">
                        <!-- Modal Header -->
                        <div class="modal-header">
                            <h4 class="modal-title">Set User Target Per Month</h4>
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>
                    <input type="text" name="name" class="col-md-12" style="text-align: center;" readonly>

                        <!-- Modal body -->
                        <div class="modal-body">
                        <div class="row">
                            <div class="form-group col-md-2">
                                <label for="firstName">Calling:</label>
                                <input id="call" type="number" class="form-control" name="call" >
                            </div>

                            <div class="form-group col-md-2">
                                <label for="firstName">High Possibility:</label>
                                <input id="followup" type="number" class="form-control" name="highPossibility" >
                            </div>

                            <div class="form-group col-md-2">
                                <label for="firstName">Lead Mine:</label>
                                <input id="lead" type="number" class="form-control" name="lead" >
                            </div>

                            <div class="form-group col-md-2">
                                <label for="firstName">Contacted(o):</label>
                                <input id="contact" type="number" class="form-control" name="contact" >
                            </div>

                            <div class="form-group col-md-2">
                                <label for="firstName">Contacted(usa):</label>
                                <input id="contactUsa" type="number" class="form-control" name="contactUsa" >
                            </div>

                            <div class="form-group col-md-2">
                               <button class="btn btn-success" type="submit">set</button>
                            </div>


                            </div></div> </form>

                    </div></div></div>







            <!-- Create User Modal -->
            <div class="modal fade" id="myModal" >
                <div class="modal-dialog" style="max-width: 60%;">
                    <div class="modal-content">

                        <!-- Modal Header -->
                        <div class="modal-header">
                            <h4 class="modal-title">Create New User</h4>
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                     </div>

                        <!-- Modal body -->
                        <div class="modal-body">

                            <form class="form-horizontal" role="form" method="POST" action="{{ route('user-management.store') }}" enctype="multipart/form-data">
                                {{ csrf_field() }}

                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <label for="userId">User Id:</label>
                                        @if ($errors->has('userId'))
                                            <span class="help-block">
											<strong>{{ $errors->first('userId') }}</strong>
										</span>
                                        @endif
                                        <input type="text" class="form-control" name="userId" value="{{ old('userId') }}" required>
                                    </div>

                                    <div class="form-group col-md-6">
                                        <label for="rfID">RF Id:</label>
                                        <input type="text" class="form-control" name="rfID" value="{{ old('rfID') }}">

                                        @if ($errors->has('rfID'))
                                            <span class="help-block">
											<strong>{{ $errors->first('rfID') }}</strong>
										</span>
                                        @endif
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="firstName">First Name:</label>

                                        <input type="text" class="form-control" name="firstName" value="{{ old('firstName') }}" required>

                                        @if ($errors->has('firstName'))
                                            <span class="help-block">
												<strong>{{ $errors->first('firstName') }}</strong>
											</span>
                                        @endif
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="lastName">Last Name:</label>
                                        <input type="text" class="form-control" name="lastName" value="{{ old('lastName') }}" required>

                                        @if ($errors->has('lastName'))
                                            <span class="help-block">
											<strong>{{ $errors->first('lastName') }}</strong>
										</span>
                                        @endif
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="userEmail">Email:</label>
                                        <input type="email" class="form-control" name="userEmail" value="{{ old('userEmail') }}" required>

                                        @if ($errors->has('userEmail'))
                                            <span class="help-block">
											<strong>{{ $errors->first('userEmail') }}</strong>
										</span>
                                        @endif
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="phoneNumber">Phone Number:</label>
                                        <input type="text" class="form-control" name="phoneNumber" value="{{ old('phoneNumber') }}">

                                        @if ($errors->has('phoneNumber'))
                                            <span class="help-block">
											<strong>{{ $errors->first('phoneNumber') }}</strong>
										</span>
                                        @endif
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label>Date Of Birth:</label>
                                        {{--<input id="dob"  class="form-control" name="dob" placeholder="pick Date" rows="3" required >--}}
                                        <input class="form-control" id="datepicker" rows="3" name="dob" placeholder="pick Date" required>

                                        @if ($errors->has('dob'))
                                            <span class="help-block">
											<strong>{{ $errors->first('dob') }}</strong>
										</span>
                                        @endif
                                    </div>


                                    <div class="form-group col-md-6">
                                        <label for="picture">Picture:</label>
                                        <input type="file" class="form-control" name="picture" value="{{ old('picture') }}">
                                        @if ($errors->has('picture'))
                                            <span class="help-block">
											<strong>{{ $errors->first('picture') }}</strong>
										</span>
                                        @endif

                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="gender">Gender:</label>
                                        <select name="gender" class="form-control form-control-warning">

                                            <option value="M">Male</option>
                                            <option value="F">Female</option>

                                        </select>
                                        @if ($errors->has('gender'))
                                            <span class="help-block">
											<strong>{{ $errors->first('gender') }}</strong>
										</span>
                                        @endif

                                    </div>

                                    <div class="form-group col-md-6">
                                        <label for="active">Status:</label>

                                        <select name="active" class="form-control form-control-warning">

                                            <option value="1">Active</option>
                                            <option value="0">Inactive</option>
                                        </select>

                                    </div>

                                    <div class="form-group col-md-6">
                                        <label for="Password">Password:</label>
                                        <input type="password" class="form-control" name="password">
                                        @if ($errors->has('password'))
                                            <span class="help-block">
											<strong>{{ $errors->first('password') }}</strong>
										</span>
                                        @endif
                                    </div>

                                    <div class="form-group col-md-6">
                                        <label for="password-confirm">Confirm Password:</label>
                                        <input type="password" class="form-control" name="password_confirmation">
                                    </div>

                                    <div class="form-group col-md-10">
                                        <label for="typeId">User Type:</label>
                                        <select name="typeId" class="form-control form-control-warning" required>

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

                                    <div class="form-group col-md-6">
                                        <button type="submit" class="btn btn-primary">
                                            Create
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

                                    <div class="form-group col-md-6">
                                        <label for="userId">User Id:</label>
                                        <input id="userId" type="text" class="form-control" name="userId" required>
                                        @if ($errors->has('userId'))
                                            <span class="help-block">
											<strong>{{ $errors->first('userId') }}</strong>
										</span>
                                        @endif
                                    </div>

                                    <div class="form-group col-md-6">
                                        <label for="rfID">RF Id:</label>
                                        <input id="rfID" type="number" class="form-control" name="rfID">

                                        @if ($errors->has('rfID'))
                                            <span class="help-block">
											<strong>{{ $errors->first('rfID') }}</strong>
										</span>
                                        @endif
                                    </div>


                                    <div class="form-group col-md-6">
                                        <label for="firstName">First Name:</label>

                                        <input id="firstName" type="text" class="form-control" name="firstName" required>

                                        @if ($errors->has('firstName'))
                                            <span class="help-block">
												<strong>{{ $errors->first('firstName') }}</strong>
											</span>
                                        @endif
                                    </div>


                                    <div class="form-group col-md-6">
                                        <label for="lastName">Last Name:</label>
                                        <input id="lastName" type="text" class="form-control" name="lastName" required>

                                        @if ($errors->has('lastName'))
                                            <span class="help-block">
											<strong>{{ $errors->first('lastName') }}</strong>
										</span>
                                        @endif
                                    </div>


                                    <div class="form-group col-md-6">
                                        <label for="userEmail">Email:</label>
                                        <input id="userEmail" type="email" class="form-control" name="userEmail" required>

                                        @if ($errors->has('userEmail'))
                                            <span class="help-block">
											<strong>{{ $errors->first('userEmail') }}</strong>
										</span>
                                        @endif
                                    </div>


                                    <div class="form-group col-md-6">
                                        <label for="phoneNumber">Phone Number:</label>
                                        <input id="phoneNumber" type="text" class="form-control" name="phoneNumber">
                                        @if ($errors->has('phoneNumber'))
                                            <span class="help-block">
											<strong>{{ $errors->first('phoneNumber') }}</strong>
										</span>
                                        @endif
                                    </div>


                                    <div class="form-group col-md-6">
                                        <label for="dob">Date Of Birth:</label>
                                        <input id="dob" type="text" class="form-control" name="dob">
                                        @if ($errors->has('dob'))
                                            <span class="help-block">
											<strong>{{ $errors->first('dob') }}</strong>
										</span>
                                        @endif
                                    </div>


                                    <div class="form-group col-md-6">
                                        <label for="picture">Picture:</label>
                                        <input id="picture" type="file" class="form-control" name="picture">
                                        @if ($errors->has('picture'))
                                            <span class="help-block">
											<strong>{{ $errors->first('picture') }}</strong>
										</span>
                                        @endif

                                    </div>

                                    <div class="form-group col-md-6">
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

                                    <div class="form-group col-md-6">
                                        <label for="active">Status:</label>

                                        <select id="active" name="active" class="form-control form-control-warning">

                                            <option value="1">Active</option>
                                            <option value="0">Inactive</option>
                                        </select>

                                    </div>

                                    <div class="form-group col-md-6">
                                        <label for="password">Password:</label>
                                        <input id="password" type="password" class="form-control" name="password">
                                        @if ($errors->has('password'))
                                            <span class="help-block">
											<strong>{{ $errors->first('password') }}</strong>
										</span>
                                        @endif
                                    </div>

                                    <div class="form-group col-md-6">
                                        <label for="password-confirm">Confirm Password:</label>
                                        <input id="password-confirm" type="password" class="form-control" name="password_confirmation">
                                    </div>

                                    <div class="form-group col-md-10">
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

                                    <div class="form-group col-md-6">
                                        <button type="submit" class="btn btn-primary">
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

        </div>
    </div>
    <!-- /.box-body -->
    </div>
@endsection





@section('foot-js')
    <script src="{{url('assets/plugins/datatables/jquery.dataTables.min.js')}}"></script>
    <script src="{{url('cdn.datatables.net/buttons/1.2.2/js/dataTables.buttons.min.js')}}"></script>
    <script src="{{url('cdn.datatables.net/buttons/1.2.2/js/buttons.flash.min.js')}}"></script>
    <script src="{{url('cdn.datatables.net/buttons/1.2.2/js/buttons.html5.min.js')}}"></script>

    <script>
        $(document).ready(function() {
            $('#myTable').DataTable();
        });

        $( function() {
            $( "#datepicker" ).datepicker();
        } );

        //Set  target_user_modal

        $('#target_user_modal').on('show.bs.modal', function(e){
            var id = $(e.relatedTarget).data('id');
            var name = $(e.relatedTarget).data('first-name');
            var call = $(e.relatedTarget).data('target-call');
            var high = $(e.relatedTarget).data('target-high');
            var lead = $(e.relatedTarget).data('target-lead');
            var contact = $(e.relatedTarget).data('target-contact');
            var contactUsa = $(e.relatedTarget).data('target-contactusa');
            var type = $(e.relatedTarget).data('target-type');




                $(e.currentTarget).find('input[name="userId"]').val(id);
                $(e.currentTarget).find('input[name="name"]').val(name);
                $(e.currentTarget).find('input[name="call"]').val(call);
                $(e.currentTarget).find('input[name="highPossibility"]').val(high);
                $(e.currentTarget).find('input[name="lead"]').val(lead);
                $(e.currentTarget).find('input[name="contact"]').val(contact);
                $(e.currentTarget).find('input[name="contactUsa"]').val(contactUsa);






        });


        //for Edit modal

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

        });


    </script>


@endsection
