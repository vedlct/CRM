@extends('main')

@section('header')

    <link rel="stylesheet" href="https://jqueryvalidation.org/files/demo/site-demos.css">

@endsection

@section('content')


    <div class="card" style="max-width: 40%; padding: 10px; float: right;">
        User Details
    </div>




    <div class="card" style="max-width: 40%; padding: 10px;">

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

    <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
    <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/additional-methods.min.js"></script>
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

