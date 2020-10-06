<div class="modal fade" id="highPossibility" role="dialog">
    <div class="modal-dialog" style="max-width: 80%">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title"><label id="label"></label></h4>
            </div>
            <div class="modal-body">
                <div id="name" style="text-align: center; font-weight:bold;"></div>
                <div id="txtHint">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<div class="card" style="padding:10px;">

    <div class="card-body">
        <h2>Report</h2>
        <p>Status report</p>
        <table id="statusReport" class="table table-bordered table-striped ">
            <thead>
            <tr>
                <th>Status</th>
                @foreach($possibilities as $possibility)
                    <th>{{ $possibility->possibilityName }}</th>
                @endforeach
                <th>Total</th>
            </tr>
            </thead>
            <tbody>
            @foreach( $statuses as $status)
                @php
                    $total = 0;
                @endphp
                <tr>
                    <td>{{$status->statusName}}</td>
                    @foreach($possibilities as $possibility)
                        <td><a href="#" onclick="getHighLead(this)" data-status-id="{{$status->statusId}}"
                               data-possibility-id="{{$possibility->possibilityId}}">
                                @foreach($leads->where('statusId', $status->statusId)->where('possibilityId', $possibility->possibilityId) as $lead)
                                    {{ $lead->total }}
                                    @php
                                        $total += $lead->total;
                                    @endphp
                                @endforeach
                            </a></td>
                    @endforeach
                    <td>{{ $total?$total:0 }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>

<script>
    $(function () {
        $("#fromdate").datepicker();
        $("#todate").datepicker();
        $("#statusReport").DataTable();
    });

    function getHighLead(x) {
        var catid = $(x).data('status-id');
        var posid = $(x).data('possibility-id');

        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        $.ajax({
            type: 'POST',
            url: '{{route('getStatusLead')}}',
            data: {_token: CSRF_TOKEN, 'statusid': catid, 'possibilityid': posid},
            cache: false,
            success: function (data) {
                // console.log(data);
                $('#highPossibility').modal({show: true});
                $('#label').html('High Possibility');
                $('#txtHint').html(data);
                $('#myTable').DataTable();
            }
        });
    }
</script>