<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>CRM Login</title>
    <link rel="icon" type="image/png" sizes="16x16" href="{{ url('assets/images/favicon.png') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: url('https://techcloudltd.com/wp-content/uploads/2023/09/Employee-of-Tech-Cloud-Ltd-celebrating-success.webp') no-repeat center center;
            background-size: cover;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .login-container {
            background: rgba(255, 255, 255, 1);
            padding: 2rem;
            border-radius: 10px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.2);
            width: 100%;
            max-width: 400px;
        }
        .login-container img {
            width: 100px;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="login-container text-center">
        <img src="https://basis.org.bd/public/images/logo/528ec54fe9d64492e69c4ec8feaf8055.jpg" alt="CRM Logo">
        <h3 class="mb-4">Sign In</h3>
        
        @if(Session::has('message'))
            <p class="alert {{ Session::get('alert-class', 'alert-success') }}">{{ Session::get('message') }}</p>
        @endif
        
        <form method="POST" action="{{ route('login') }}">
            {!! csrf_field() !!}
            <div class="mb-3">
                <input type="text" name="userId" class="form-control" placeholder="Username" required>
            </div>
            <div class="mb-3">
                <input type="password" name="password" class="form-control" placeholder="Password" required>
            </div>
            <div class="mb-3 form-check">
                <input type="checkbox" class="form-check-input" name="remember" {{ old('remember') ? 'checked' : '' }}>
                <label class="form-check-label">Remember Me Today</label>
            </div>
            <button type="submit" class="btn btn-primary w-100">Log In</button>
        </form>
    </div>
</body>
</html>