
@extends('main')


@section('content')

    <div class="card" style="padding: 30px;">
        <div class="card-body">
    <button type="button" class="btn btn-info" data-toggle="collapse" data-target="#demo">Users</button>
    <div id="demo" class="collapse">
        <table class="table table-hover" style="max-width: 1000px;">
            <thead>
            <tr>
                <th>Firstname</th>
                <th>Lastname</th>
                <th>Email</th>
                <th>Gender</th>
                <th>User Type</th>
                
            </tr>
            </thead>
            <tbody>
            @foreach($users as $user)
                <tr>
                <td>{{$user->firstName}}</td>
                <td>{{$user->lastName}}</td>
                <td>{{$user->userEmail}}</td>
                <td>{{$user->gender}}</td>
                <td>{{$user->userType->typeName}}</td>

            </tr>
            @endforeach
            </tbody>
        </table>


    </div>
        </div></div>




@endsection