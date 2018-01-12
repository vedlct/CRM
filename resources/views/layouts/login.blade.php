<!DOCTYPE html>
<html>

<!-- Mirrored from demo.bootstrapious.com/admin/login.html by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 10 Jan 2018 07:53:08 GMT -->
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Customer relationship management</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="all,follow">
    <!-- Bootstrap CSS-->
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <!-- Google fonts - Roboto -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,700">
    <!-- theme stylesheet-->
    <link rel="stylesheet" href="css/style.default.css" id="theme-stylesheet">
    <!-- Custom stylesheet - for your changes-->
    <link rel="stylesheet" href="css/custom.css">
    <!-- Favicon-->
    <link rel="shortcut icon" href="img/favicon.ico">
    <!-- Font Awesome CDN-->
    <!-- you can replace it by local Font Awesome-->
    <script src="../../use.fontawesome.com/99347ac47f.js"></script>
    <!-- Font Icons CSS-->
    <link rel="stylesheet" href="../../file.myfontastic.com/da58YPMQ7U5HY8Rb6UxkNf/icons.css">
    <!-- Tweaks for older IEs--><!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script><![endif]-->
</head>
<body>
<div class="page login-page">
    <div class="container d-flex align-items-center">
        <div class="form-holder has-shadow">
            <div class="row">
                <!-- Logo & Information Panel-->
                <div class="col-lg-6">
                    <div class="info d-flex align-items-center">
                        <div class="content">
                            <div class="logo">
                                <h1>Customer relationship management</h1>
                            </div>
                            <p>Tech Cloud Limited</p>
                        </div>
                    </div>
                </div>
                <!-- Form Panel    -->
                <div class="col-lg-6 bg-white">
                    <div class="form d-flex align-items-center">
                        <div class="content">
                            <form id="login-form"  method="POST" action="{{ route('login') }}">

                                    {{ csrf_field() }}

                                    <div class="form-group{{ $errors->has('userId') ? ' has-error' : '' }}">

                                        <label for="login-username" class="label-material">User Name</label>
                                    <input id="text" type="text" class="form-control" name="userId"  required autofocus>

                                        @if ($errors->has('userId'))
                                            <span class="help-block">
                                        <strong>{{ $errors->first('userId') }}</strong>
                                    </span>
                                        @endif
                                    </div>

                                <div class="form-group">
                                    <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}"></div>
                                        <label for="password" class="label-material">Password</label>
                                        <input id="password" type="password" class="form-control" name="password" required>

                                        @if ($errors->has('password'))
                                            <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                        @endif
                                </div>

                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> Remember Me
                                            </label>
                                        </div>

                                     <button type="submit" class="btn btn-primary">Login</button>
                                <!-- This should be submit button but I replaced it with <a> for demo purposes-->
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="copyrights text-center">
        <p>Design by <a href="https://bootstrapious.com/admin-templates" class="external">Bootstrapious</a></p>
        <!-- Please do not remove the backlink to us unless you support further theme's development at https://bootstrapious.com/donate. It is part of the license conditions. Thank you for understanding :)-->
    </div>
</div>
<!-- Javascript files-->

<!-- Google Analytics: change UA-XXXXX-X to be your site's ID.-->
<!---->

</body>

<!-- Mirrored from demo.bootstrapious.com/admin/login.html by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 10 Jan 2018 07:53:09 GMT -->
</html>