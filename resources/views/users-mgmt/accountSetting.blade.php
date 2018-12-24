@extends('main')

@section('header')


    <style>
        #field { margin-left: .5em; float: left; }
        #field, label { float: left; font-family: Arial, Helvetica, sans-serif; font-size: small; }
        br { clear: both; }
        input { border: 1px solid black; margin-bottom: .5em;  }
        input.error { border: 1px solid red; }
        label.error {
            background: url('images/unchecked.gif') no-repeat;
            padding-left: 16px;
            margin-left: .3em;
        }
        label.valid {
            background: url('images/checked.gif') no-repeat;
            display: block;
            width: 16px;
            height: 16px;
        }

    </style>

@endsection

@section('content')


    <div class="card" style="width: 40%; padding: 10px; float: left;">
        <div class="row">
            <div class="col-md-3">
                <b>Name :</b>
            </div>

            <div class="col-md-9">
                {{$user->firstName}} {{$user->lastName}}
            </div>


            <div class="col-md-3">
                <b>Email :</b>
            </div>


            <div class="col-md-9">
                {{$user->userEmail}}
            </div>


            <div class="col-md-3">
                <b>Gender :</b>
            </div>


            <div class="col-md-9">
                {{$user->gender}}
            </div>
            <div class="col-md-3">
                <b>Date of Birth :</b>
            </div>
            <div class="col-md-9">
                {{$user->dob}}
            </div>


        </div>


    </div>




    <div class="card" style="max-width: 40%; padding: 10px; float: right; margin-right: 20%;">

        <h2 align="center"><b>Account Settings</b></h2><hr>

        <form action="{{route('changePass')}}" method="post" id="myform">
            {{@csrf_field()}}

            <div class="form-group">
                <label for="pwd">Current Password:</label>
                <input type="password" class="form-control" id="pwd" name="currentPassword">
                <div class="form-group{{ $errors->has('currentPassword') ? ' has-error' : '' }} " >
                    @if ($errors->has('currentPassword'))
                        <span class="help-block">
                                        <strong>{{ $errors->first('currentPassword') }}</strong>
                                    </span>
                    @endif
                </div>
            </div>

            <div class="form-group">
                <label for="pwd">New Password:</label>
                <input type="password" class="form-control" id="password" name="password">
                <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }} " >
                    @if ($errors->has('password'))
                        <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                    @endif
                </div>

            </div>

            <div class="form-group">
                <label for="pwd">Confirm New Password:</label>
                <input type="password" class="form-control" id="password_again" name="password_again">
            </div>

            <button type="submit" class="btn btn-primary" >Submit</button>
        </form>





    </div>




@endsection

@section('bottom')

    <script src="{{url('js/jqueryvalidate.js')}}"></script>
    <script src="{{url('js/additional-method.js')}}"></script>
<script>



//    jQuery.validator.setDefaults({
//        debug: true,
//        success: "valid"
//    });
    var validator = $( "#myform" ).validate({
        rules: {
            password: "required",
            password_again: {
                equalTo: "#password"
            }

        }

    });




</script>

@endsection

