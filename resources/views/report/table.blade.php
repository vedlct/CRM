@extends('main')



@section('content')


        <div class="card" style="padding:10px;">
            <div class="card-body">
        <h2>Report</h2>
        <p>Weekly report</p>
        <table class="table">
            <thead>
            <tr>
                <th>Name</th>
                <th>Total Call</th>
                <th>Contacted</th>
                <th>Assigned Lead</th>
                <th>High Possibility</th>
                <th>Test Lead</th>
                <th>Closing Lead</th>
                <th>Lead Mined</th>
            </tr>
            </thead>
            <tbody>
            @foreach($report as $r)
            <tr>
                <td>{{$r->userName}}</td>
                <td>{{$r->called}}</td>
                <td>{{$r->contacted}}</td>
                <td>{{$r->assignedLead}}</td>
                <td>{{$r->highPosibilities}}</td>
                <td>{{$r->test}}</td>
                <td>{{$r->closing}}</td>
                <td>{{$r->leadMined}}</td>
            </tr>
                @endforeach
            </tbody>
        </table>
            </div></div>





@endsection