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
            <table class="table table-striped table-bordered" id="revenueTable"></table>
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
{{--    <meta name="csrf-token" content="{{ csrf_token() }}" />--}}

    <script>
        $(document).ready(function() {
            $('.select2').select2()

            $('#revenueTable').DataTable({
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
                columns: [
                    {title: 'Lead Id', data: 'leadId', name: 'leadId', className: "text-center", orderable: true, searchable: true},
                    {title: 'Website', data: 'website', name: 'website', className: "text-center", orderable: true, searchable: false},
                    {title: 'Phone Number', data: 'contactNumber', name: 'contactNumber', className: "text-center", orderable: true, searchable: true},
                    {title: 'Closing Date', data: 'closing_date', name: 'closing_date', className: "text-center", orderable: true, searchable: true},
                    {title: 'Marketer', data: 'marketerName', name: 'marketerName', className: "text-center", orderable: true, searchable: true},
                    {title: 'Action', className: "text-center", data: function (data) {
                            return '<a title="Entry" class="btn btn-success btn-sm" data-panel-id="' + 1 + '" onclick="entryRevenue(this)"><i class="fa fa-edit"></i></a>'
                            + ' <a title="View" class="btn btn-blue btn-sm" data-panel-id="' + 1 + '" onclick="viewRevenue(this)"><i class="fa fa-eye"></i></a>'
                        }, orderable: false, searchable: false
                    }
                ]
            });
        });

        function filterRevenue() {
            $('#revenueTable').DataTable().ajax.reload()
        }
    </script>
@endsection
