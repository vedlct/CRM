@extends('main')

@section('content')
    <div class="card">
        <div class="card-body">
            <h2 class="card-title"><b>All Test Lead</b></h2>
            <div class="table-responsive m-t-40">
                <table id="myTable" class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th>Company Name</th>
                        <th>Category</th>
                        <th>Possibility</th>
                        <th>Country</th>
                        <th>Contact Person</th>
                        <th>Contact Number</th>
                        <th>Test Price</th>
                        <th>Test Price Date</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($leads as $lead)
                        <tr>
                            <td>{{ $lead->companyName }}</td>
                            <td>{{ $lead->category->categoryName }}</td>
                            <td>{{ $lead->possibility->possibilityName }}</td>
                            <td>{{ $lead->country->countryName }}</td>
                            <td>{{$lead->personName}}</td>
                            <td>{{ $lead->contactNumber }}</td>
                            <td>{{ $lead->test_price ? number_format($lead->test_price, 2, '.', '') : '' }}</td>
                            <td>{{ $lead->test_price_date ? date('Y-m-d', strtotime($lead->test_price_date)) : '' }}</td>
                            <td>
                                <a href="#edit_test_price_modal" data-toggle="modal" class="btn btn-info btn-sm" data-lead-id="{{ $lead->leadId }}" data-test-price="{{ number_format($lead->test_price, 2, '.', '') }}">
                                    <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
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
        $(document).ready(function() {
            $('#myTable').DataTable({
                "processing": true
            });
        });

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
                        window.location.reload()
                    }
                },
            });
        })
    </script>
@endsection