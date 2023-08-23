@extends('main')



@section('content')


    <div class="card" style="padding:10px;">
        <div class="card-body">
        <h2  align="center"><b>All Conversations</b></h2>
        <p  align="center">No Client or Duplicate lead should be here</p>

            <div class="table-responsive m-t-40">
                <table id="myTable" class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th width="5%">Id</th>
                        <th width="10%">Company Name</th>
                        <th width="8%">Category</th>
                        <th width="15%">website</th>
                        <th width="8%">Country</th>
                        <!-- <th width="8%">Contact Person</th> -->
                        <th width="8%">Contact Number</th>
                        <th width="7%">Process</th>
                        <th width="7%">Volume</th>
                        <th width="7%">Frequency</th>
                        <th width="7%">Status</th>
                        <th width="7%">IPP</th>
                        <th width="10%">Convo Date</th>
                        <th width="7%">Marketer</th>
                        <th width="10%">Action</th>

                    </tr>
                    </thead>
                    <tbody>

                    @foreach($leads as $lead)
                        <tr>
                            <td >{{$lead->leadId}}</td>
                            <td >{{$lead->companyName}}</td>
                            <td >{{$lead->category->categoryName}}</td>
                            <td ><a href="{{$lead->website}}" target="_blank">{{$lead->website}}</a></td>
                            <td >{{$lead->country->countryName}}</td>
                            <!-- <td >{{$lead->personName}}</td> -->
                            <td >{{$lead->contactNumber}}</td>
                            <td >{{$lead->process}}</td>
                            <td >{{$lead->volume}}</td>
                            <td >{{$lead->frequency}}</td>
                            <td >{{$lead->status->statusName}}</td>
                                @if($lead->ippStatus == '0') 
                                    <td>No</td>
                                @else 
                                    <td>Yes</td>
                                @endif                                 
                            <td >{{ $lead->workprogress_created_at }}</td>
                            <td >{{$lead->firstName}} {{$lead->lastName}}
                            </td>
                            <td>
                                <a href="." class="btn btn btn-primary btn-sm lead-view-btn"
                                    data-lead-id="{{$lead->leadId}}"
                                ><i class="fa fa-eye"></i></a>'
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