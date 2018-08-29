<table class="table table-bordered table-striped">
    <thead>
    <th>Lead Name</th>
    <th>Company Name</th>
    <th>Date</th>
    </thead>
    <tbody>
    @foreach($followup as $follow)
        <tr>
            <td>{{$follow->leadName}}</td>
            <td>{{$follow->companyName}}</td>
            <td>{{$follow->date}}</td>
        </tr>
    @endforeach
    </tbody>
</table>