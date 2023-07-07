@extends('main')



@section('content')


    <div class="card" style="padding:10px;">
        <div class="card-body">
                <h2 class="card-title" align="center"><b>All Employees</b></h2>

            <div class="table-responsive m-t-40">
                <table id="myTable" class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th >Id</th>
                        <th >Full Name</th>
                        <th >Designation</th>
                        <th >Email Address</th>
                        <th >Phone Number</th>
                        <th >Country</th>
                        <th >LinkedIn</th>
                        <th >Job Status</th>
                        <th >KDM?</th>
                        <th >Company</th>
                        <th >Website</th>
                        <!-- <th >Created</th> -->

                    </tr>
                    </thead>
                    <tbody>

                    @foreach($employees as $employee)
                        <tr>
                            <td width="15%">{{$employee->employeeId}}</td>
                            <td width="15%">{{$employee->name}}</td>
                            <td width="8%">{{$employee->designation->designationName}}</td>
                            <td width="10%">{{$employee->email}}</a></td>
                            <td width="8%">{{$employee->number}}</td>
                            <td width="5%">{{$employee->country->countryName}}</td>
                            <td width="8%">{{$employee->linkedin}}</td>
                            <td width="8%">@if ($employee->jobstatus == 1) Active @else Left Job @endif</td>
                            <td width="8%">@if ($employee->iskdm == 1) KDM @else No @endif</td>
                            <td width="8%">{{$employee->companyName}}</td>
                            <td width="8%">{{$employee->website}}</td>
                            <!-- <td width="8%">{{$employee->created_at}}</td> -->

                        </tr>

                    @endforeach

                    </tbody>
                </table>
            </div>
        </div>
    </div>
















@endsection

@section('foot-js')

    <script src="{{url('assets/plugins/datatables/jquery.dataTables.min.js')}}"></script>

    <script src="{{url('cdn.datatables.net/buttons/1.2.2/js/dataTables.buttons.min.js')}}"></script>
    <script src="{{url('cdn.datatables.net/buttons/1.2.2/js/buttons.flash.min.js')}}"></script>


    <script src="{{url('cdn.datatables.net/buttons/1.2.2/js/buttons.html5.min.js')}}"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}" />



    <script>


        $(document).ready(function() {
            $('#myTable').DataTable({
                "processing": true,
                stateSave: true,
            });

        });





    </script>


@endsection