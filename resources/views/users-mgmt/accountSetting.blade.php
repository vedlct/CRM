@extends('main')

@section('header')

    <link rel="stylesheet" href="https://jqueryvalidation.org/files/demo/site-demos.css">

@endsection

@section('content')

    <div class="card" style="padding-left: 10%;padding-right: 10%;padding-top: 2%;padding-bottom: 2%;">

        <h2 align="center"><b>Account Settings</b></h2><hr>


        <form action="{{route('changePass')}}" method="post" style="width: 40%;" id="myform">
            {{@csrf_field()}}
            <div class="form-group">
                <label for="pwd">Current Password:</label>
                <input type="password" class="form-control" id="pwd" name="currentPassword">
            </div>

            <div class="form-group">
                <label for="pwd">New Password:</label>
                <input type="password" class="form-control" id="password" name="password">
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

