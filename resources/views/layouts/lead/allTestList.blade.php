@extends('main')

@section('content')
    <div class="card">
        <div class="card-body">
            <h2 class="card-title"><b>All Test Lead</b></h2>
            <div class="form-inline justify-content-center">
                <div class="form-group">
                    <label for="filterDate">Filter by Lead Test Date </label>
                    <input class="form-control ml-3" type="date" id="filterDate" name="filterDate" onchange="filterDate()">
                </div>
            </div>
            <div class="table-responsive m-t-40">
                <table id="myTable" class="table table-bordered table-striped"></table>
            </div>
        </div>
    </div>

    <!-- Test Price Update Modal -->
    <div class="modal" id="edit_test_price_modal">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Edit Test Price</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="testPriceUpdateForm" action="{{ route('testPriceUpdate') }}" method="POST">
                    {{ csrf_field() }}
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-12">
                                <input type="hidden" id="leadId" name="leadId" value="">
                                <div class="form-group">
                                    <label>Test Price</label>
                                    <input type="number" step="0.01" min="0" class="form-control" id="test_price" name="test_price" value="" required>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('foot-js')
    <script src="{{url('assets/plugins/datatables/jquery.dataTables.min.js')}}"></script>

    <script>
        let table
        $(document).ready(function() {
             table = $('#myTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    "url": "{{ route('allTestLeadList') }}",
                    "type": "GET",
                    data: function (d) {
                        d.filterDate = $('#filterDate').val()
                    },
                },
                columns: [
                    {title: 'Company Name', data: 'companyName', name: 'companyName', className: "text-center", orderable: false, searchable: true},
                    {title: 'Category', data: 'category.categoryName', name: 'category.categoryName', className: "text-center", orderable: true, searchable: true},
                    // {title: 'Possibility', data: 'possibility.possibilityName', name: 'possibility.possibilityName', className: "text-center", orderable: true, searchable: true},
                    {title: 'Country', data: 'country.countryName', name: 'country.countryName', className: "text-center", orderable: true, searchable: true},
                    {title: 'Website', data: 'website', name: 'website', className: "text-center", orderable: true, searchable: true},
                    {title: 'Email', data: 'email', name: 'email', className: "text-center", orderable: true, searchable: true},
                    {title: 'Contact Number', data: 'contactNumber', name: 'contactNumber', className: "text-center", orderable: true, searchable: true},
                    {title: 'Test By', data: 'testBy', name: 'testBy', className: "text-center", orderable: true, searchable: true},
                    {title: 'Test Price', data: 'test_price', name: 'test_price', className: "text-center", orderable: true, searchable: true},
                    {title: 'Test Price Date', data: 'test_price_date', name: 'test_price_date', className: "text-center", orderable: true, searchable: true},
                    {title: 'Created At', data: 'work_created_at', name: 'work_created_at', className: "text-center", orderable: true, searchable: true},
                    {title: 'Action', className: "text-center", data: function (data) {
                            // return '<a title="edit" class="btn btn-warning btn-sm" data-panel-id="' + data.leadId + '" onclick="editLead(this)"><i class="fa fa-edit"></i></a>';
                            return '<a href="#edit_test_price_modal" data-toggle="modal" class="btn btn-info btn-sm" data-lead-id="' + data.leadId + '" data-test-price="' + data.test_price + '"><i class="fa fa-pencil-square-o"></i></a>';
                        }, orderable: false, searchable: false
                    }
                ]
            });
        });

        function filterDate() {
            table.ajax.reload()
        }

        $('#edit_test_price_modal').on('show.bs.modal', function(e) {
            let leadId = $(e.relatedTarget).data('lead-id');
            $(e.currentTarget).find('input[name="leadId"]').val(leadId);

            let testPrice = $(e.relatedTarget).data('test-price');
            $(e.currentTarget).find('input[name="test_price"]').val(testPrice);
        });

        $('#testPriceUpdateForm').on('submit', function (e) {
            e.preventDefault()
            let formData = new FormData($('#testPriceUpdateForm')[0])

            $.ajax({
                type: 'POST',
                url: "{!! route('testPriceUpdate') !!}",
                cache: false,
                processData: false,
                contentType: false,
                data: formData,
                success: function (response, textStatus, jqXHR) {
                    if (jqXHR.status === 200) {
                        $('#edit_test_price_modal').modal('toggle')
                        $('#myTable').DataTable().clear().draw();
                    }
                },
            });
        })
    </script>
@endsection