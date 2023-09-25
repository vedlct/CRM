@extends('main')



@section('content')


    <div class="card" style="padding:10px;">
        <div class="card-body">
        <h2 align="center"><b>Chasing Companies</b></h2>
        <h3 class="card-subtitle" align="center">This table wil show the names of the companies that are being chased by marketers for more than 10 times</h3>

            <div class="table-responsive m-t-40">
                <table id="myTable" class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th width="5%">Lead Id</th>
                        <th width="15%">Company Name</th>
                        <th width="8%">Category</th>
                        <th width="15%">website</th>
                        <th width="8%">Country</th>
                        <th width="7%">Process</th>
                        <th width="7%">Volume</th>
                        <th width="7%">Frequency</th>
                        <th width="7%">IPP</th>
                        <th width="10%">Marketer</th>
                        <th width="5%">No of Chase</th>
                        <!-- <th width="5%">Last Contact</th> -->
                        <th width="5%">Action</th>

                    </tr>
                    </thead>
                    <tbody>

                    @foreach($leads as $lead)
                        <tr>
                            <td >{{$lead->leadId}}</td>
                            <td >{{$lead->companyName}}</td>
                            <td >{{$lead->category->categoryName}}</td>
                            <td >{{$lead->website}}</td>
                            <td >{{$lead->country->countryName}}</td>
                            <td >{{$lead->process}}</td>
                            <td >{{$lead->volume}}</td>
                            <td >{{$lead->frequency}}</td>
                                @if($lead->ippStatus == '0') 
                                    <td>No</td>
                                @else 
                                    <td>Yes</td>
                                @endif                                 
                            <td >{{$lead->firstName}} {{$lead->lastName}}
                            </td>
                            <td >{{$lead->progressCount}} </td>
                            <td >
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

            $(document).on('click', '.lead-view-btn', function(e) {
                e.preventDefault();

                var leadId = $(this).data('lead-id');
                var newWindowUrl = '{{ url('/account') }}/' + leadId;

                window.open(newWindowUrl, '_blank');
            });


        });

    </script>


@endsection