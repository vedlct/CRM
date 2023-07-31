@extends('main')



@section('content')

@php($userType = Session::get('userType'))

    <div class="card" style="padding:30px;">
        <div class="card-body">
        <h2 align="center"><b>Leads with Keywords in Comments</b></h2>
        <p class="card-subtitle" align="center">On your left search box, you can write keywords (separated by comma) and get the results in a table. <br> On the right search box, you can write the keywords and download the list as an excel file.</p>
        <div class="card-body" >
            <div class="col-md-5" style="float:left;">
                <form method="POST" action="{{ route('analysisComments') }}">
                {{ csrf_field() }}
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" name="searchTerm" placeholder="Enter search terms using comma">
                        <div class="input-group-append">
                            <button class="btn btn-primary" type="submit">Search and Show in Table</button><br>
                        </div>
                    </div>
                </form>
                </div>

                @if($userType=='SUPERVISOR' || $userType=='ADMIN')
                <div class="col-md-5" style="float:right;">
                <form method="POST" action="{{ route('exportAnalysisComments') }}">
                {{ csrf_field() }}
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" name="searchTerm" placeholder="Enter search terms using comma">
                        <div class="input-group-append">
                            <button class="btn btn-primary" type="submit">Export Query in an Excel</button><br>
                        </div>
                    </div>
                </form>
                </div>
                @else
                <div class="col-md-5" style="float:right;">
                <p style="color:grey; font-style: italic;">Export is available for Admin and Supervisor only</p>
                </div>
                @endif
        </div>

        <div class="card" style="padding-top:50px;">
        </div>


    @if (!empty($searchTerm))

            <div class="table-responsive m-t-40">
                <div>You have searched for: {{$searchTerm}} </div><br><br>

                <table id="myTable" class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <!-- <th width="5%"><input type="checkbox" id="select-all"></th> -->
                        <th width="5%">Id</th>
                        <th width="10%">Company Name</th>
                        <th width="8%">Category</th>
                        <th width="15%">website</th>
                        <th width="8%">Status</th>
                        <th width="8%">Country</th>
                        <th width="8%">User</th>
                        <th width="7%">Comments</th>
                        <th width="7%">Action</th>

                    </tr>
                    </thead>
                    
                    <tbody>

                    @foreach($analysis as $analyze)
                        <tr>
                            <td >{{$analyze->leadId}}</td>
                            <td >{{$analyze->companyName}}</td>
                            <td >{{$analyze->category->categoryName}}</td>
                            <td >{{$analyze->website}}</td>
                            <td >{{$analyze->statusName}}</td>
                            <td >{{$analyze->country->countryName}}</td>
                            <td >{{$analyze->userId}}</td>
                            <td >{{$analyze->comments}}</td>
                            <td >
                                <a href="." class="btn btn btn-primary btn-sm lead-view-btn"
                                    data-lead-id="{{$analyze->leadId}}"
                                ><i class="fa fa-eye"></i></a>'
                            </td>
                        </tr>

                    @endforeach

                    </tbody>
                </table>
            </div>
    </div>
    </div>


    @endif


@endsection

@section('foot-js')

    <script src="{{url('assets/plugins/datatables/jquery.dataTables.min.js')}}"></script>

    <script src="{{url('cdn.datatables.net/buttons/1.2.2/js/dataTables.buttons.min.js')}}"></script>
    <script src="{{url('cdn.datatables.net/buttons/1.2.2/js/buttons.flash.min.js')}}"></script>


    <script src="{{url('cdn.datatables.net/buttons/1.2.2/js/buttons.html5.min.js')}}"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}" />



    <script>


        // Capture selected row IDs on form submit
        $('#exportForm').submit(function() {
            var selectedRows = [];
            $('table tbody :checkbox:checked').each(function() {
                selectedRows.push($(this).closest('tr').data('id'));
            });
            $('#selectedRows').val(selectedRows.join(','));
        });



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