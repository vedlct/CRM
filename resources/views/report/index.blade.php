
@extends('main')


@section('content')

    <div class="card" style="padding: 30px;">
        <div class="card-body">
    <button type="button" class="btn btn-info" data-toggle="collapse" data-target="#demo">Todays Call List</button>
    <div id="demo" class="collapse">
        <table class="table table-hover" style="max-width: 1000px;">
            <thead>
            <tr>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Email</th>
                <th>User Type</th>
                <th>Called</th>

            </tr>
            </thead>
            <tbody>

            @foreach($users as $user)
                <tr>
                <td>{{$user->firstName}}</td>
                <td>{{$user->lastName}}</td>
                <td>{{$user->userEmail}}</td>
                    <td>{{$user->userType->typeName}}</td>
                <td>{{$user->total}}</td>

            </tr>
            @endforeach
            </tbody>
        </table>


    </div>
        </div></div>




@endsection