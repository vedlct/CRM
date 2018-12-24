<table class="table table-bordered table-striped">
    <thead>
    <th>Lead Name</th>
    <th>Company Name</th>
    <th>Date</th>
    </thead>
    <tbody>
    @foreach($meeting as $meet)
        <tr>
            <td>{{$meet->leadName}}</td>
            <td>{{$meet->companyName}}</td>
            <td>{{$meet->meetingDate}}</td>
        </tr>
    @endforeach
    </tbody>
</table>