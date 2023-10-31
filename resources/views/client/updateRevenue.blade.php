@extends('main')


@section('content')

    <div class="card" style="padding:10px;">
        <div class="card-body">
            <h2  align="center"><b>Update Revenue</b></h2>

            <div class="table-responsive m-t-40">
                <table id="myTable" class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th>Lead Id</th>
                        <th>website</th>
                        <th>Number</th>
                        <th>Country</th>
                        <th>Status</th>
                        <th>Marketer</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($leads as $lead)
                        <tr>
                            <td >{{$lead->leadId}}</td>
                            <td >{{$lead->website}}</td>
                            <td >{{$lead->contactNumber}}</td>
                            <td >{{$lead->countryName}}</td>                    
                            <td >{{$lead->statusName}}</td>                    
                            <td >{{$lead->contactedUserId}}</td>                    
                            <td>
                                <a href="." class="btn btn btn-primary btn-sm lead-view-btn"
                                    data-lead-id="{{$lead->leadId}}"
                                ><i class="fa fa-eye"></i></a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>









@endsection

@section('foot-js')
    <script src="{{url('js/select2.min.js')}}"></script>
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

        $(document).on('click', '.lead-view-btn', function(e) {
                e.preventDefault();

                var leadId = $(this).data('lead-id');
                var newWindowUrl = '{{ url('/account') }}/' + leadId;

                window.open(newWindowUrl, '_blank');
            });




    </script>
@endsection
