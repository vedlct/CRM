<table class="table table-bordered table-striped">
    <thead>
        <th>Lead Name</th>
        <th>Company Name</th>
        <th>Sales</th>
        <th>Date</th>
    </thead>
    <tbody>
        @foreach($sales as $sale)
            <tr>
                <td>{{$sale->leadName}}</td>
                <td>{{$sale->companyName}}</td>
                <td>{{$sale->total}}</td>
                <td>{{$sale->created_at}}</td>
            </tr>
        @endforeach
    </tbody>
</table>