@extends('main')

@section('header')

@endsection


@section('content')

    <div class="card" style="padding:10px;">
        <div class="card-body">
                <h2 align="center"><b>Parent Companies </b></h2>
            <div class="row">

                <a href="#create_parent_modal" data-toggle="modal" class="btn btn-info btn-sm">
                    <i class="glyphicon glyphicon-edit"></i> Set Parent Company
                </a>
                <div class="table-responsive m-t-40">
                    <table id="parentTable" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Lead Id</th>
                                <th>Lead Name</th>
                                <th>Lead Website</th>
                                <th>Lead Contact</th>
                                <th>Parent Lead Id</th>
                                <th>Parent Company Name</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                                <!-- Table data will be populated here -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>






<!-- Modal for Creating parent company -->
<div class="modal" id="create_parent_modal">
    <div class="modal-dialog">
        <form class="modal-content" method="post" action="{{ route('parent.create') }}">
            <div class="modal-header">
                <h4 class="modal-title">Create Parent Company</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                {{ csrf_field() }}
                <div class="form-group">
                    <label for="lead_id">Lead ID:</label>
                    <input type="number" name="lead_id" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="parent_id">Parent Company ID:</label>
                    <input type="number" name="parent_id" class="form-control">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Update</button>
            </div>
        </form>
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
            // Initialize the DataTable
            var parentTable = $('#parentTable').DataTable({
                "processing": true,
                "stateSave": true,
                "serverSide": true, // Enable server-side processing
                "ajax": {
                    "url": "{!! route('parent.list') !!}",
                    "type": "POST",
                    "data": {
                        "_token": "{{ csrf_token() }}"
                    }
                },
                "columns": [
                    { data: "leadId", name: "leadId" },
                    { data: "companyName", name: "companyName" },
                    { data: "website", name: "website" },
                    { data: "contactNumber", name: "contactNumber" },
                    { data: "parent", name: "parent" }, 
                    {
                        data: "parentCompany",
                        "render": function(data, type, full, meta) {
                            return data ? data : '';
                        }
                    },
                    { data: 'action', name: 'action', orderable: false, searchable: false }

                ]
            });


            $('#parentTable tbody').on('click', 'a.remove-parent-btn', function() {
                // Handle remove parent button click
                var leadId = $(this).data('lead-id');
                // Perform the action you want here
                if (!confirm("Are you sure you want to remove the parent?")) {
                    return;
                }

                // Make an Ajax request to update the parent field
                $.ajax({
                    url: "{{ route('parent.delete', ['leadId' => '__leadId__']) }}".replace('__leadId__', leadId),
                    type: "POST",
                    data: {
                        _method: 'POST', // Use POST method
                        _token: "{{ csrf_token() }}" // Add CSRF token
                    },
                    success: function(response) {
                        console.log(response); // You can do something here, like showing a success message

                        // Reload the page
                        location.reload();
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText); // You can display an error message or handle the error as needed
                    }
                });
            });
        });



        $(document).on('click', '.lead-view-btn', function(e) {
                e.preventDefault();

                var leadId = $(this).data('lead-id');
                var newWindowUrl = '{{ url('/account') }}/' + leadId;

                window.open(newWindowUrl, '_blank');
            });




        // For updating parent company modal
        $('#create_parent_modal').on('show.bs.modal', function(e) {
            // Get data-id attribute of the clicked element
            var leadId = $(e.relatedTarget).data('lead-id');
            var parentCompanyId = $(e.relatedTarget).data('parent-company-id');

            // Populate the dropdowns with lead options and set the selected lead and parent company
            $(e.currentTarget).find('select[name="lead_id"]').val(leadId);
            $(e.currentTarget).find('select[name="parent_id"]').val(parentCompanyId);
        });


        $('#edit_parent_modal').on('show.bs.modal', function(e) {
            var leadId = $(e.relatedTarget).data('lead-id');
            $(e.currentTarget).find('input[name="leadId"]').val(leadId);
        });
        







    </script>
@endsection
