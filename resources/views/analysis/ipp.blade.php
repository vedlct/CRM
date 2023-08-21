@extends('main')



@section('content')

@php($userType = Session::get('userType'))

    <div class="card" style="padding:10px;">
        <div class="card-body">
        <h2  align="center"><b>IPP List</b></h2>

        <div class="col-md-5" style="float:left;">
                @if ( $userType =='SUPERVISOR' || $userType =='ADMIN')
                    <form method="POST" action="{{ route('exportIppList') }}">
                        {{ csrf_field() }}
                        <button class="btn btn-primary" type="submit">Export The List</button>
                    </form>
                @endif    
                <br><br>
            </div>



            <div class="table-responsive m-t-40">
                <table id="myTable" class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th width="5%">Id</th>
                        <th width="10%">Company Name</th>
                        <th width="8%">Category</th>
                        <th width="10%">website</th>
                        <th width="5%">Country</th>
                        <!-- <th width="10%">Contact Person</th> -->
                        <th width="8%">Contact Number</th>
                        <th width="5%">Process</th>
                        <th width="5%">Volume</th>
                        <th width="5%">Frequency</th>
                        <th width="8%">Last Update</th>
                        <th width="8%">Marketer</th>
                        <th width="8%">Action</th>

                    </tr>
                    </thead>
                    <tbody>

                    @foreach($leads as $lead)
                        <tr>
                            <td width="5%">{{$lead->leadId}}</td>
                            <td width="10%">{{$lead->companyName}}</td>
                            <td width="8%">{{$lead->category->categoryName}}</td>
                            <td width="10%"><a href="{{$lead->website}}" target="_blank">{{$lead->website}}</a></td>
                            <td width="5%">{{$lead->country->countryName}}</td>
                            <!-- <td width="10%">{{$lead->personName}}</td> -->
                            <td width="8%">{{$lead->contactNumber}}</td>
                            <td width="5%">{{$lead->process}}</td>
                            <td width="5%">{{$lead->volume}}</td>
                            <td width="5%">{{$lead->frequency}}</td>
                            <td width="8%">{{ Carbon\Carbon::parse($lead->created_at)->format('d M Y, H:i') }}</td>
                            <td width="8%">{{$lead->firstName}} {{$lead->lastName}}
                            </td>
                            <td width="8%">
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