@extends('main')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Update user</div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="POST" action="{{ route('user-management.update', ['id' => $user->id]) }}" enctype="multipart/form-data">
                        <input type="hidden" name="_method" value="PATCH">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <div class="form-group{{ $errors->has('userId') ? ' has-error' : '' }}">
                            <label for="userId" class="col-md-4 control-label">User Name</label>
							

                        <div class="form-group row{{ $errors->has('userId') ? ' has-error' : '' }}">
                            <label for="userId" class="col-sm-3 control-label">User Name</label>

                            <div class="col-sm-9">
                                <input id="userName" type="text" class="form-control" name="userId" value="{{ $user->userId }}" required autofocus>

                                @if ($errors->has('userId'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('userId') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row{{ $errors->has('typeId') ? ' has-error' : '' }}">
                            <label for="typeId" class="col-sm-3 control-label">User Type</label>
							<div class="col-sm-9">

								<select name="typeId" class="form-control form-control-warning">
                                    @foreach ($userTypes as $userType)
                                       <option {{$user->typeId == $userType->typeId ? 'selected' : ''}} value="{{$userType->typeId}}">{{$userType->typeName}}</option>

                                    @endforeach
								</select>

                                @if ($errors->has('typeId'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('typeId') }}</strong>
                                    </span>
                                @endif
							</div>
						</div>

                        <div class="form-group row{{ $errors->has('rfID') ? ' has-error' : '' }}">
                            <label for="rfID" class="col-sm-3 control-label">RF ID</label>

                            <div class="col-sm-9">
                                <input id="rfID" type="number" class="form-control" name="rfID" value="{{ $user->rfID }}" required autofocus>

                                @if ($errors->has('rfID'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('rfID') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row{{ $errors->has('userEmail') ? ' has-error' : '' }}">
                            <label for="email" class="col-sm-3 control-label">E-Mail Address</label>

                            <div class="col-sm-9">
                                <input id="email" type="email" class="form-control" name="userEmail" value="{{ $user->userEmail }}" required>

                                @if ($errors->has('userEmail'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('userEmail') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group row{{ $errors->has('firstName') ? ' has-error' : '' }}">
                            <label for="firstName" class="col-sm-3 control-label">First Name</label>

                            <div class="col-sm-9">
                                <input id="firstName" type="text" class="form-control" name="firstName" value="{{ $user->firstName }}" required>

                                @if ($errors->has('firstName'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('firstName') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group row{{ $errors->has('lastName') ? ' has-error' : '' }}">
                            <label for="lastName" class="col-sm-3 control-label">Last Name</label>

                            <div class="col-sm-9">
                                <input id="lastName" type="text" class="form-control" name="lastName" value="{{ $user->lastName }}" required>

                                @if ($errors->has('lastName'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('lastName') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
					
                        <div class="form-group row{{ $errors->has('phoneNumber') ? ' has-error' : '' }}">
                            <label for="phoneNumber" class="col-sm-3 control-label">Phone Number</label>

                            <div class="col-sm-9">
                                <input id="phoneNumber" type="text" class="form-control" name="phoneNumber" value="{{ $user->phoneNumber }}" required autofocus>

                                @if ($errors->has('phoneNumber'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('phoneNumber') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row{{ $errors->has('picture') ? ' has-error' : '' }}">
                            <label for="picture" class="col-sm-3 control-label">Picture</label>

                            <div class="col-sm-9">
                                <a href="{{ asset('img/'.$user->picture) }}" target="_blank"><img src="{{asset('img/'.$user->picture)}}" width="50px" height="50px"/></a>
								<input id="picture" type="file" class="form-control" name="picture" value="{{ $user->picture }}" autofocus>

                                @if ($errors->has('picture'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('picture') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row{{ $errors->has('dob') ? ' has-error' : '' }}">
                            <label for="dob" class="col-sm-3 control-label">Date of Birth</label>

                            <div class="col-sm-9">
                                <input id="dob" type="date" class="form-control" name="dob" value="{{ $user->dob }}" required autofocus>

                                @if ($errors->has('dob'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('dob') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>	

                        <div class="form-group row{{ $errors->has('gender	') ? ' has-error' : '' }}">
                            <label for="gender	" class="col-sm-3 control-label">Gender</label>

                            <div class="col-sm-9">
								<select id="gender" name="gender" class="form-control form-control-warning" value="{{ $user->gender }}"  required autofocus>
									@if(($user->gender)=='M')
										<option value="M">Male</option>
									@elseif(($user->gender)=='F')
										<option value="F">Female</option>
									@endif
									<option value="M">Male</option>
									<option value="F">Female</option>
								</select>
                                @if ($errors->has('gender'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('gender') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>	
						
						<div class="form-group row">
							<label class="col-sm-3 form-control-label">Status</label>
							<div class="col-sm-9">

								<select name="active" class="form-control form-control-warning">
									@if(($user->active)=='0')
										<option value="0">Inactive</option>
									@elseif(($user->active)=='1')
										<option value="1">Active</option>
									@endif
									<option value="1">Active</option>
									<option value="0">Inactive</option>
								</select>
							</div>
						</div>
						
                        <div class="form-group row{{ $errors->has('password') ? ' has-error' : '' }}">
                            <label for="password" class="col-sm-3 control-label">Password</label>

                            <div class="col-sm-9">
                                <input id="password" type="password" class="form-control" name="password" required>

                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password-confirm" class="col-sm-3 control-label">Confirm Password</label>

                            <div class="col-sm-9">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    Update
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
