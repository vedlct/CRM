@extends('main')



@section('content')

@php($userType = Session::get('userType'))


    <div class="card" style="padding:10px;">
        <div class="card-body">
                <h2 align="center"><b>All Employees</b></h2>

            <div class="table-responsive m-t-40">
                <table id="myTable" class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th >Emp Id</th>
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
                        <th >Action</th>

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
                    url: "{!! route('getAllEmployees') !!}",
                    type: "POST",
                    data: {
                        _token: "{{ csrf_token() }}"
                    }
                },
                columns: [
                    { data: 'employeeId', name: 'employeeId' },
                    { data: 'name', name: 'name' },
                    { data: 'designationName', name: 'designationName' },
                    { data: 'email', name: 'email' },
                    { data: 'number', name: 'number' },
                    { data: 'countryName', name: 'countryName' },
                    { data: 'linkedin', name: 'linkedin' },
                    { 
                        data: 'jobstatus',name: 'jobstatus', render: function(data, type, full, meta) {
                            return data == 1 ? 'Active' : 'Left Job';
                        }
                    },
                    { 
                        data: 'iskdm', name: 'iskdm', render: function(data, type, full, meta) {
                            return data == 1 ? 'Yes' : 'No';
                        }
                    },
                    { data: 'companyName', name: 'companyName' },
                    { data: 'website', name: 'website' },
                    { data: 'action', name: 'action', orderable: false, searchable: false }
                ]
            });

        });


        $(document).on('click', '.remove-employee-btn', function() {
                var employeeId = $(this).data('employee-id');
                var confirmation = confirm('Are you sure you want to remove this employee?');

                if (confirmation) {
                    $.ajax({
                        url: "{{ route('removeEmployees', ['employeeId' => ':employeeId']) }}".replace(':employeeId', employeeId),
                        type: "POST", // Change this to POST
                        data: {
                            _method: 'DELETE', // Still include this data for Laravel to recognize DELETE method
                            _token: $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(response) {
                            console.log(response);
                            // Reload the page or update the table data
                            location.reload();
                        },
                        error: function(xhr, status, error) {
                            console.error(xhr.responseText);
                            // Handle the error, show a message, etc.
                        }
                    });
                }
        });


		$(document).on('click', '.lead-view-btn', function(e) {
            e.preventDefault();

            var leadId = $(this).data('lead-id');
            var newWindowUrl = '{{ url('/account') }}/' + leadId;

            window.open(newWindowUrl, '_blank');
        });



    </script>


@endsection