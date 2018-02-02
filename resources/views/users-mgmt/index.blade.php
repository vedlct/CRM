@extends('main')

@section('content')
  <div class="box-body">
    <div class="card" style="padding: 2px;">
        <div class="card-body">
			<h2 style="display: inline-block; margin: 0px 200px;">List of users</h2>
			{{--<a class="btn btn-primary" href="{{ route('user-management.create') }}">Add new user</a>--}}
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal">
                Add new user
            </button>


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
                    {{--<form method="POST" action="{{ route('user-management.destroy', ['id' => $user->id]) }}" onsubmit = "return confirm('Are you sure?')">--}}
                        {{--<input type="hidden" name="_method" value="DELETE">--}}
                        {{--<input type="hidden" name="_token" value="{{ csrf_token() }}">--}}
                        <a href="{{ route('user-management.edit', ['id' => $user->id]) }}" class="btn btn-info btn-sm">
							<i class="fa fa-pencil-square-o"></i>
                        </a>
						{{--@if ($user->userId != Auth::user()->userId)--}}
                        {{--<button type="submit" class="btn btn-danger btn-sm">--}}
							{{--<i class="fa fa-trash"></i>--}}
                        {{--</button>--}}
						{{--@endif--}}
                    {{--</form>--}}
                  </td>
              </tr>
            @endforeach
            </tbody>
          </table>
        </div>
      </div>


        <!-- The Modal -->
        <div class="modal fade" id="myModal" >
            <div class="modal-dialog" style="max-width: 50%;">
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

                                <div class="form-group col-md-5">
                                    <label for="userId">User Id:</label>
                                    @if ($errors->has('userId'))
                                        <span class="help-block">
								<strong>{{ $errors->first('userId') }}</strong>
							</span>
                                    @endif
                                    <input id="userName" type="text" class="form-control" name="userId" value="{{ old('userId') }}" required>
                                </div>

                                <div class="form-group col-md-5">
                                    <label for="userId">RF Id:</label>
                                    <input id="rfId" type="text" class="form-control" name="rfID" value="{{ old('rfId') }}" required >

                                    @if ($errors->has('rfId'))
                                        <span class="help-block">
								<strong>{{ $errors->first('rfId') }}</strong>
							</span>
                                    @endif
                                </div>


                                <div class="form-group col-md-5">
                                    <label for="userId">First Name:</label>

                                        <input id="firstName" type="text" class="form-control" name="firstName" value="{{ old('firstName') }}" required>

                                        @if ($errors->has('firstName'))
                                            <span class="help-block">
								<strong>{{ $errors->first('firstName') }}</strong>
							</span>
                                        @endif
                                </div>


                                <div class="form-group col-md-5">
                                    <label for="userId">Last Name:</label>
                                    <input id="lastName" type="text" class="form-control" name="lastName" value="{{ old('lastName') }}" required>

                                    @if ($errors->has('lastName'))
                                        <span class="help-block">
								<strong>{{ $errors->first('lastName') }}</strong>
							</span>
                                    @endif
                                </div>


                                <div class="form-group col-md-5">
                                    <label for="userId">Email:</label>
                                    <input id="email" type="email" class="form-control" name="userEmail" value="{{ old('userEmail') }}" required>

                                    @if ($errors->has('userEmail'))
                                        <span class="help-block">
								<strong>{{ $errors->first('userEmail') }}</strong>
							</span>
                                    @endif
                                </div>


                                <div class="form-group col-md-5">
                                    <label for="userId">Phone Number:</label>
                                    <input id="phoneNumber" type="text" class="form-control" name="phoneNumber" value="{{ old('phoneNumber') }}" required>

                                    @if ($errors->has('phoneNumber'))
                                        <span class="help-block">
								<strong>{{ $errors->first('phoneNumber') }}</strong>
							</span>
                                    @endif
                                </div>


                                <div class="form-group col-md-5">
                                    <label>Date Of Birth:</label>
                                    {{--<input id="dob"  class="form-control" name="dob" placeholder="pick Date" rows="3" required >--}}
                                    <input class="form-control" id="datepicker" rows="3" name="dob" placeholder="pick Date" required>
                                    @if ($errors->has('dob'))
                                        <span class="help-block">
								<strong>{{ $errors->first('dob') }}</strong>
							</span>
                                    @endif
                                </div>


                                <div class="form-group col-md-5">
                                    <label for="userId">Picture:</label>
                                    <input id="picture" type="file" class="form-control" name="picture" value="{{ old('picture') }}" >
                                    @if ($errors->has('picture'))
                                        <span class="help-block">
								<strong>{{ $errors->first('picture') }}</strong>
							</span>
                                    @endif

                                </div>


                                <div class="form-group col-md-5">
                                    <label for="userId">Gender:</label>
                                    <select id="gender" name="gender" class="form-control form-control-warning" required>

                                        <option value="M">Male</option>
                                        <option value="F">Female</option>

                                    </select>
                                    @if ($errors->has('gender'))
                                        <span class="help-block">
								<strong>{{ $errors->first('gender') }}</strong>
							</span>
                                    @endif

                                </div>



                                <div class="form-group col-md-5">
                                    <label for="userId">Status:</label>

                                    <select name="active" class="form-control form-control-warning">

                                        <option value="1">Active</option>
                                        <option value="0">Inactive</option>
                                    </select>

                                </div>


                                <div class="form-group col-md-5">
                                    <label for="userId">Password:</label>
                                    <input id="password" type="password" class="form-control" name="password" required>
                                    @if ($errors->has('password'))
                                        <span class="help-block">
								<strong>{{ $errors->first('password') }}</strong>
							</span>
                                    @endif
                                </div>


                                <div class="form-group col-md-5">
                                    <label for="userId">Confirm Password:</label>
                                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                                </div>




                                <div class="form-group col-md-10">
                                    <label for="userId">User Type:</label>
                                    <select name="typeId" class="form-control form-control-warning">

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

                                <div class="form-group col-md-5">
                                <button type="submit" class="btn btn-primary">
                                    Create
                                </button>
                                </div>







                            </div></form>







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
			<script src="{{asset('assets/plugins/datatables/jquery.dataTables.min.js')}}"></script>
			<script src="{{asset('cdn.datatables.net/buttons/1.2.2/js/dataTables.buttons.min.js')}}"></script>
			<script src="{{asset('cdn.datatables.net/buttons/1.2.2/js/buttons.flash.min.js')}}"></script>
			<script src="{{asset('cdn.datatables.net/buttons/1.2.2/js/buttons.html5.min.js')}}"></script>

			<script>
				$(document).ready(function() {
					$('#myTable').DataTable();
                });

                $( function() {
                    $( "#datepicker" ).datepicker();
                } );



			</script>


		@endsection
