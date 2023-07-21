@extends('main')



@section('content')


    <div class="card" style="padding:10px;">
        <div class="card-body">
        <h2  align="center"><b>My Activity</b></h2>
        <h5 class="card-subtitle" align="center">Only showing last 500 activities</h5>


        <button id="filterButton" class="btn btn-primary">Today's Research</button>


            <div class="table-responsive m-t-40">
                <table id="myTable" class="table table-bordered table-striped">
                    <thead>
                    <tr>
                    <th width="10%">Activity Id</th>
                        <th width="10%">Marketer</th>
                        <th width="10%">Lead ID</th>
                        <th width="15%">Company Name</th>
                        <th width="10%">Lead Status</th>
                        <th width="30%">Activities</th>
                        <th width="15%">Date</th>

                    </tr>
                    </thead>
                    <tbody>

                    @foreach($myActivity as $activity)
                        <tr>
                            <td width="10%">{{$activity->activityId}}</td>
                            <td width="10%">{{$activity->firstName}} {{$activity->lastName}}</td>
                            <td width="10%">{{$activity->leadId}}</td>
                            <td width="15%">{{$activity->companyName}}</td>
                            <td width="10%">{{$activity->statusName}}</td>
                            <td width="30%">{{$activity->activity}}</td>
                            <td width="15%">{{$activity->created_at}}</td>
                            
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
                dom: 'lifrtip',
                "processing": true,
                stateSave: true,
                "order": [[1, "desc"]]

            });

            $('#filterButton').on('click', function() {
                // Get today's date in YYYY-MM-DD format
                var today = new Date().toISOString().split('T')[0];

                // Clear existing search
                $('#myTable').DataTable().search('').draw();

                // Apply new search with 'updated' string and today's date
                $('#myTable').DataTable().search('updated ' + today).draw();
            });
        });    

    </script>


@endsection