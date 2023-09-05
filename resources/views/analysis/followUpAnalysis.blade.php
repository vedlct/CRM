@extends('main')

@section('content')
    <div class="card">
        <div class="card-body">
            <h2 align="center"><b>Follow Ups - Not Worked Yet</b></h2>
            <p align="center">You will find all follow ups that are not touched yet.</p>

            <div class="table-responsive m-t-40">
                <table id="followUpTable" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Lead Id</th>
                            <th>Company Name</th>
                            <th>Website</th>
                            <th>Contact Number</th>
                            <th>Follow Up Date</th>
                            <th>Time</th>
                            <th>Work Status</th>
                            <th>Followup Created</th>
                            <th>Marketer</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@section('foot-js')
    <script src="{{ asset('assets/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('cdn.datatables.net/buttons/1.2.2/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('cdn.datatables.net/buttons/1.2.2/js/buttons.flash.min.js') }}"></script>
    <script src="{{ asset('cdn.datatables.net/buttons/1.2.2/js/buttons.html5.min.js') }}"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <script>
        $(document).ready(function () {
            $('#followUpTable').DataTable({
                processing: true,
                serverSide: true,
                stateSave: true,
                ajax: {
                    url: "{{ route('getFollowUpAnalysis') }}",
                    type: "POST",
                    data: {
                        _token: "{{ csrf_token() }}"
                    }
                },
                columns: [
                    { data: 'leadId', name: 'leadId' },
                    { data: 'companyName', name: 'companyName' },
                    { data: 'website', name: 'website' },
                    { data: 'contactNumber', name: 'contactNumber' },
                    { data: 'followUpDate', name: 'followUpDate' },
                    { data: 'time', name: 'time' },
                    {
                        data: 'workStatus',
                        name: 'workStatus',
                        render: function (data, type, full, meta) {
                            return data === 0 ? 'Not Worked' : 'Followed Already';
                        }
                    },
                    { data: 'created_at', name: 'created_at' },
                    { data: 'userId', name: 'userId' },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false,
                        render: function (data, type, full, meta) {
                            return '<a href="#" class="btn btn-info btn-sm lead-view-btn" data-lead-id="' + full.leadId + '">View Lead</a>' +
                                ' <button class="btn btn-danger btn-sm make-work-status-done" data-follow-id="' + full.followId + '">Remove Followup</button>';
                        }
                    }
                ]
            });
        });

        $(document).on('click', '.lead-view-btn', function (e) {
            e.preventDefault();

            var leadId = $(this).data('lead-id');
            var newWindowUrl = '{{ url('/account') }}/' + leadId;

            window.open(newWindowUrl, '_blank');
        });


        $(document).on('click', '.make-work-status-done', function (e) {
            e.preventDefault();

            var followId = $(this).data('follow-id');

            // Send an AJAX request to update the workStatus to 1 for the specific followId
            $.ajax({
                type: 'POST',
                url: '{{ route('updateFollwoUpWorkStatus') }}',
                data: {
                    _token: '{{ csrf_token() }}',
                    followId: followId
                },
                success: function (data) {
                    if (data.success) {
                        // Update the DataTable to reflect the changes
                        $('#followUpTable').DataTable().ajax.reload();
                    }
                }
            });
        });



    </script>



@endsection
