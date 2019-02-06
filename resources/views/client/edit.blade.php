<table class="table table-striped">
    <thead>
        <th>Company Name</th>
        <th>File</th>
        <th>Created_at</th>
    </thead>
    <tbody>
    @foreach($newFiles as $lead)
        <tr>
            <td>{{$lead->companyName}}</td>
            <td>{{$lead->fileCount}}</td>
            <td>{{$lead->created_at}}</td>
        </tr>


    @endforeach

    </tbody>
    <tfoot>
        <tr>
            <td><b>Total</b></td>
            <td><b>{{$newFiles->sum('fileCount')}}</b></td>
        </tr>
    </tfoot>

</table>
