@extends('main')



@section('content')


    <div class="card" style="padding:10px;">
        <div class="card-body">
        <h2 class="card-title" align="center"><b>My Activity</b></h2>
        <h2 class="card-subtitle" align="center"><b>Only showing last 200 activities</b></h2>

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
                            <td width="15%">{{ Carbon\Carbon::parse($activity->created_at)->format('d M Y, H:i') }}</td>
                            
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