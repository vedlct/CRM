@extends('main')

@section('content')


    <div class="card" style="margin: 50px;">

        <h3 style="text-align: center; margin: 20px;">Test List</h3>

        <table class="table table-hover" style="background-color:white; ">
            <thead>
            <tr>
                <th>SL</th>
                <th>Name</th>
                <th>Designation</th>
                <th>Leave Start Date</th>
                <th>Leave End Date</th>
                <th>Leave Count</th>
                <th>Cause</th>
                <th>Details</th>
                <th>Status</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td>John</td>
                <td>Doe</td>
                <td>Agency</td>
                <td>1/1/2018</td>
                <td>5/1/2018</td>
                <td>5</td>
                <td>fever</td>
                <td></td>
                <td>Valid</td>

            </tr>


            </tbody>
        </table>




    </div>



@endsection