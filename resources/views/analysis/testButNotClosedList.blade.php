@extends('main')



@section('content')


    <div class="card" style="padding:10px;">
        <div class="card-body">
        <h2 align="center"><b>Received Test But Not Closed List</b></h2>
        <p class="card-subtitle" align="center">We received the tests from these companies but we were unable to close them.</p>

            <div class="table-responsive m-t-40">
                <table id="myTable" class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th width="5%">Id</th>
                        <th width="10%">Company Name</th>
                        <th width="5%">Category</th>
                        <th width="10%">website</th>
                        <th width="5%">Country</th>
                        <th width="8%">Contact Number</th>
                        <th width="5%">Status</th>
                        <th width="8%">Test Date</th>
                        <th width="20%">Latest Comment</th>
                        <th width="8%">Marketer</th>
                        <th width="8%">Action</th>

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
                    url: "{!! route('getTestButNotClosedList') !!}",
                    type: "POST",
                    data: {
                        _token: "{{ csrf_token() }}"
                    }
                },
                columns: [
                    { data: 'leadId', name: 'leadId' },
                    { data: 'companyName', name: 'companyName' },
                    { data: 'category.categoryName', name: 'category.categoryName' },
                    { data: 'website', name: 'website' },
                    { data: 'country.countryName', name: 'country.countryName' },
                    { data: 'contactNumber', name: 'contactNumber' },
                    { data: 'status.statusName', name: 'status.statusName' },
                    { data: 'wp_created_at', name: 'wp_created_at' },
                    { data: 'last_comment', name: 'last_comment' },
                    { data: 'firstName', name: 'firstName' },
                    { data: 'action', name: 'action', orderable: false, searchable: false }
                ]
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