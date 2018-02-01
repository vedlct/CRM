@extends('main')

@section('content')
    <div class="card" style="padding:2% 10%">
		<div class="panel-heading">Add new user</div>
		<div class="panel-body">
			<form class="form-horizontal" role="form" method="POST" action="{{ route('user-management.store') }}" enctype="multipart/form-data">
				{{ csrf_field() }}
			
            <div class="row">

            <div class="form-group col-md-6">

				<div class="form-group row{{ $errors->has('userId') ? ' has-error' : '' }}">
					<label for="userId" class="col-md-3 control-label">User ID</label>

					<div class="col-md-9">
						<input id="userName" type="text" class="form-control" name="userId" value="{{ old('userId') }}" required autofocus>

						@if ($errors->has('userId'))
							<span class="help-block">
								<strong>{{ $errors->first('userId') }}</strong>
							</span>
						@endif
					</div>
				</div>

				<div class="form-group row{{ $errors->has('typeId') ? ' has-error' : '' }}">
					<label for="typeId" class="col-md-3 control-label">User Type</label>
					<div class="col-md-9">

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
				</div>

            </div>


            <div class="form-group col-md-6">
				<div class="form-group row{{ $errors->has('rfId') ? ' has-error' : '' }}">
					<label for="rfId" class="col-md-3 control-label">RF ID</label>

					<div class="col-md-9">
						<input id="rfId" type="text" class="form-control" name="rfId" value="{{ old('rfId') }}">

						@if ($errors->has('rfId'))
							<span class="help-block">
								<strong>{{ $errors->first('rfId') }}</strong>
							</span>
						@endif
					</div>
				</div>

            </div>


            <div class="form-group col-md-6">
				<div class="form-group row{{ $errors->has('userEmail') ? ' has-error' : '' }}">
					<label for="email" class="col-md-3 control-label">E-Mail Address</label>

					<div class="col-md-9">
						<input id="email" type="email" class="form-control" name="userEmail" value="{{ old('userEmail') }}" required>

						@if ($errors->has('userEmail'))
							<span class="help-block">
								<strong>{{ $errors->first('userEmail') }}</strong>
							</span>
						@endif
					</div>
				</div>
            </div>


            <div class="form-group col-md-6">
				<div class="form-group row{{ $errors->has('firstName') ? ' has-error' : '' }}">
					<label for="firstName" class="col-md-3 control-label">First Name</label>

					<div class="col-md-9">
						<input id="firstName" type="text" class="form-control" name="firstName" value="{{ old('firstName') }}" required>

						@if ($errors->has('firstName'))
							<span class="help-block">
								<strong>{{ $errors->first('firstName') }}</strong>
							</span>
						@endif
					</div>
				</div>
            </div>


            <div class="form-group col-md-6">
				<div class="form-group row{{ $errors->has('lastName') ? ' has-error' : '' }}">
					<label for="lastName" class="col-md-3 control-label">Last Name</label>

					<div class="col-md-9">
						<input id="lastName" type="text" class="form-control" name="lastName" value="{{ old('lastName') }}" required>

						@if ($errors->has('lastName'))
							<span class="help-block">
								<strong>{{ $errors->first('lastName') }}</strong>
							</span>
						@endif
					</div>
				</div>
            </div>


            <div class="form-group col-md-6">
			
				<div class="form-group row{{ $errors->has('phoneNumber') ? ' has-error' : '' }}">
					<label for="phoneNumber" class="col-md-3 control-label">Phone Number</label>

					<div class="col-md-9">
						<input id="phoneNumber" type="text" class="form-control" name="phoneNumber" value="{{ old('phoneNumber') }}">

						@if ($errors->has('phoneNumber'))
							<span class="help-block">
								<strong>{{ $errors->first('phoneNumber') }}</strong>
							</span>
						@endif
					</div>
				</div>
            </div>


            <div class="form-group col-md-6">

				<div class="form-group row{{ $errors->has('picture') ? ' has-error' : '' }}">
					<label for="avatar" class="col-md-3 control-label">Picture</label>

					<div class="col-md-9">
						<input id="picture" type="file" class="form-control" name="picture" value="{{ old('picture') }}">

						@if ($errors->has('picture'))
							<span class="help-block">
								<strong>{{ $errors->first('picture') }}</strong>
							</span>
						@endif
					</div>
				</div>
            </div>


            <div class="form-group col-md-6">

				<div class="form-group row{{ $errors->has('dob') ? ' has-error' : '' }}">
					<label for="dob" class="col-md-3 control-label">Date of Birth</label>

					<div class="col-md-9">
						<input id="dob" type="text" class="form-control" name="dob" value="{{ old('dob') }}">

						@if ($errors->has('dob'))
							<span class="help-block">
								<strong>{{ $errors->first('dob') }}</strong>
							</span>
						@endif
					</div>
				</div>	
            </div>


            <div class="form-group col-md-6">

				<div class="form-group row{{ $errors->has('gender	') ? ' has-error' : '' }}">
					<label for="gender	" class="col-md-3 control-label">Gender</label>

					<div class="col-md-9">
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
				</div>	
            </div>


            <div class="form-group col-md-6">
				
				<div class="form-group row">
					<label class="col-md-3 form-control-label">Status</label>
					<div class="col-md-9">

						<select name="active" class="form-control form-control-warning">

							<option value="1">Active</option>
							<option value="0">Inactive</option>
						</select>
					</div>
				</div>
            </div>


            <div class="form-group col-md-6">
				
				<div class="form-group row{{ $errors->has('password') ? ' has-error' : '' }}">
					<label for="password" class="col-md-3 control-label">Password</label>

					<div class="col-md-9">
						<input id="password" type="password" class="form-control" name="password" required>

						@if ($errors->has('password'))
							<span class="help-block">
								<strong>{{ $errors->first('password') }}</strong>
							</span>
						@endif
					</div>
				</div>

				<div class="form-group row">
					<label for="password-confirm" class="col-md-3 control-label">Confirm Password</label>

					<div class="col-md-9">
						<input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
					</div>
				</div>
            </div>


            <div class="form-group col-md-6">

				<div class="form-group row">
					<div class="col-md-9 col-md-offset-4">
						<button type="submit" class="btn btn-primary">
							Create
						</button>
					</div>
				</div>
            </div>
            </div>

			</form>
		</div>
    </div>
@endsection


@section('foot-js')

    <script>

        $( function() {
            $( "#dob" ).datepicker();
        } );
    </script>
@endsection
