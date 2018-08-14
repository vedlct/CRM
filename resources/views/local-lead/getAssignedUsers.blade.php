<table class="table table-bordered table-striped">
    <thead>
        <th>User</th>
        <th>Assign By</th>
        <th>date</th>
    </thead>
    <tbody>
        @foreach($users as $user)
            <tr>
                <td>{{$user->user}}</td>
                <td>{{$user->assignBy}}</td>
                <td>{{$user->date}}</td>
            </tr>
        @endforeach
    </tbody>
</table>