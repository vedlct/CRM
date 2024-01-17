@extends('main')

@section('content')
    <br>
    <div class="card">
        <div class="card-body">
            <h1 class="text-center">Revenue</h1>
            <div class="row mt-5">
                <div class="col-md-3 form-group">
                    <label for="marketer">Marketer</label>
                    <select id="marketer" name="marketer" class="form-control select2">
                        <option value="">Select Marketer</option>
                        @foreach( $marketers as $marketer )
                            <option value="{{ $marketer->id }}">{{ @$marketer->firstName .' '. @$marketer->lastName }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3 form-group">
                    <label for="dateFrom">Date From</label>
                    <input type="date" class="form-control" id="dateFrom" name="dateFrom">
                </div>
                <div class="col-md-3 form-group">
                    <label for="dateTo">Date From</label>
                    <input type="date" class="form-control" id="dateTo" name="dateTo">
                </div>
                <div class="col-md-3 form-group align-self-end">
                    <button class="btn btn-success" onclick="filterRevenue()">Submit</button>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-md-10">
                    <table class="table table-striped table-bordered" id="revenueTable"></table>
                </div>
                <div class="col-md-2">
                    <div class="card bg-info">
                        <div class="card-body">
                            <h4>Revenue Summary</h4>
{{--                            <h5>Date Range: <span id="dateRange"></span></h5>--}}
                            <h5>Total Clients: <span id="totalClient"></span></h5>
                            <h5>Revenue (USD): <span id="totalRevenue"></span></h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal" id="addRevenueModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Add Revenue</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="addRevenueForm">
                    {{ csrf_field() }}
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <input type="hidden" name="new_fileId" id="new_fileId" value="0">
                                    <label for="fileCount">File Count</label>
                                    <input type="text" name="fileCount" id="fileCount" maxlength="10" placeholder="0">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="rate">Rate in USD</label>
                                    <input type="text" name="rate" id="rate" maxlength="10" placeholder="0">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-center">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal" id="viewRevenueModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">View Revenue</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <h4>File Count : <span id="viewFileCount">0</span></h4>
                    <h4>Rate in USD : <span id="viewRate">0.00</span></h4>
                    <h4>Revenue : <span id="viewRevenue">0.00</span></h4>
                </div>
                <div class="modal-footer justify-content-center">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('foot-js')
    <script src="{{url('assets/plugins/datatables/jquery.dataTables.min.js')}}"></script>
    <script src="{{url('cdn.datatables.net/buttons/1.2.2/js/dataTables.buttons.min.js')}}"></script>
    <script src="{{url('cdn.datatables.net/buttons/1.2.2/js/buttons.flash.min.js')}}"></script>
    <script src="{{url('cdn.datatables.net/buttons/1.2.2/js/buttons.html5.min.js')}}"></script>

    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <style>
        .select2-container .select2-selection--single {
            height: 39px;
        }
        .select2-container--default .select2-selection--single .select2-selection__rendered {
            line-height: 38px;
        }
        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 37px;
        }

        .btn-blue {
            background: deepskyblue;
            border: 1px solid deepskyblue;
        }
    </style>

    <script>
        let table;
        $(document).ready(function() {
            $('.select2').select2()

            table = $('#revenueTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    "url": "{{ route('revenueList') }}",
                    "type": "POST",
                    data: function (d) {
                        d._token = "{{ csrf_token() }}";
                        d.marketer = $('#marketer').val();
                        d.dateFrom = $('#dateFrom').val();
                        d.dateTo = $('#dateTo').val();
                    },
                },
                fnDrawCallback: function(data) {
                    $('#totalClient').text(data.json.totalClients)
                    $('#totalRevenue').text(parseFloat(data.json.totalRevenue).toFixed(2));

                    // if (json.input.dateFrom !== null || json.input.dateTo !== null) {
                    //     $('#dateRange').text(json.input.dateFrom ?? '' + ' - ' + json.input.dateTo ?? '')
                    // }
                },
                columns: [
                    {title: 'Lead Id', data: 'leadId', name: 'leadId', className: "text-center", orderable: true, searchable: true},
                    {title: 'Website', data: 'website', name: 'website', className: "text-center", orderable: true, searchable: true},
                    {title: 'File Count', data: 'fileCount', name: 'fileCount', className: "text-center", orderable: true, searchable: true},
                    {title: 'Phone Number', data: 'contactNumber', name: 'contactNumber', className: "text-center", orderable: true, searchable: true},
                    {title: 'Closing Date', data: 'created_at', name: 'created_at', className: "text-center", orderable: true, searchable: true},
                    {title: 'Marketer', data: 'marketerName', name: 'marketerName', className: "text-center", orderable: true, searchable: true},
                    {title: 'Action', className: "text-center", data: function (data) {
                            return '<button type="button" title="Entry" class="btn btn-success btn-sm" data-toggle="modal" data-target="#addRevenueModal" data-panel-id="' + data.new_fileId + '" onclick="addRevenue(this)"><i class="fa fa-edit"></i></button>'
                            + ' <button type="button" title="View" class="btn btn-blue btn-sm" data-toggle="modal" data-target="#viewRevenueModal" data-panel-id="' + data.new_fileId + '" onclick="viewRevenue(this)"><i class="fa fa-eye"></i></button>'
                        }, orderable: false, searchable: false
                    }
                ],
            });
        });

        function filterRevenue() {
            table.ajax.reload()
        }

        $('#addRevenueForm').on('submit', function (e) {
            e.preventDefault()
            let formData = new FormData($('#addRevenueForm')[0])

            $.ajax({
                type: 'POST',
                url: "{{ route('addRevenue') }}",
                cache: false,
                processData: false,
                contentType: false,
                data: formData,
                success: function (response) {
                    if (response.status === 200) {
                        $('#addRevenueForm').trigger('reset')
                        $('#addRevenueModal').modal('toggle');
                        filterRevenue()
                    }
                },
            });
        })

        $('#addRevenueForm').on('reset', function () {
            $('#new_fileId').val("0")
        });

        function addRevenue(x) {
            let newFileId = $(x).data('panel-id')
            $('#new_fileId').val(newFileId)

            $.ajax({
                type: 'GET',
                url: "{{ route('getRevenue') }}",
                data: {
                    "new_fileId" : newFileId
                },
                success: function (response) {
                    if (response.status === 200) {
                        $('#fileCount').val(response.newFile.fileCount ?? '0')
                        $('#rate').val(response.newFile.rate ?? '0.00')
                    }
                },
            });
        }

        function viewRevenue(x) {
            $('#viewFileCount').text("0")
            $('#viewRate').text("0.00")
            $('#viewRevenue').text("0.00")

            let newFileId = $(x).data('panel-id')

            $.ajax({
                type: 'GET',
                url: "{{ route('getRevenue') }}",
                data: {
                    "new_fileId" : newFileId
                },
                success: function (response) {
                    if (response.status === 200) {
                        $('#viewFileCount').text(response.newFile.fileCount ?? '0')
                        $('#viewRate').text(response.newFile.rate ? parseFloat(response.newFile.rate).toFixed(2) : '0.00')
                        if (response.newFile.fileCount !== null && response.newFile.rate !== null) {
                            let fileCount = parseInt(response.newFile.fileCount)
                            let rate = parseFloat(response.newFile.rate)
                            $('#viewRevenue').text( (fileCount * rate).toFixed(2) )
                        }
                    }
                },
            });
        }
    </script>
@endsection
