@extends('main')



@section('content')


    <div class="card" style="padding:10px;">
        <div class="card-body">
        <h2  align="center"><b>All Activities</b></h2>

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
                processing: true,
                serverSide: true,
                stateSave: true,
                ajax: {
                    url: "{!! route('getAllActivities') !!}",
                    type: "POST",
                    data: {
                        _token: "{{ csrf_token() }}"
                    }
                },
                columns: [
                    { data: 'activityId', name: 'activityId' },
                    { data: 'firstName', name: 'firstName' },
                    { data: 'leadId', name: 'leadId' },
                    { data: 'companyName', name: 'companyName' },
                    { data: 'statusName', name: 'statusName' },
                    { data: 'activity', name: 'activity' },
                    { data: 'created_at', name: 'created_at' },
                ]
            });
        });


    </script>


@endsection