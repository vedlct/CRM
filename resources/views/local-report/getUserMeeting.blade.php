<table class="table table-bordered table-striped">
    <thead>
    <th>Lead Name</th>
    <th>Company Name</th>
    <th>Date</th>
    <th>Time</th>
    </thead>
    <tbody>
    @foreach($meeting as $meet)
        <tr>
            <td>{{$meet->leadName}}</td>
            <td>{{$meet->companyName}}</td>
            <td>{{$meet->meetingDate}}</td>
            <td>{{date("g:iA", strtotime($meet->meetingTime))}}</td>
        </tr>
    @endforeach
    </tbody>
</table>