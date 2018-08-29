<!-- The Modal -->
<div class="modal fade" id="userReportModal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title" id="userReportModalHead"></h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <!-- Modal body -->
            <div class="modal-body" id="userReportModalBody">

            </div>

            <!-- Modal footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>

        </div>
    </div>
</div>




<table class="table table-bordered table-striped">
    <thead>
        <th>User</th>
        <th>Sales</th>
        <th>Meeting</th>
        <th>Followup</th>

    </thead>
    <tbody>
    @foreach($users as $user)
        <tr>
            <td>{{$user->firstName}}</td>
            <td>
                @foreach($sales as $sale)
                    @if($sale->userId == $user->id)
                        <a href="#" data-panel-id="{{$user->id}}" onclick="getUserSales(this)">{{$sale->total}}</a>
                        @break
                    @endif
                @endforeach
            </td>

            <td>
                @foreach($meeting as $meet)
                    @if($meet->userId == $user->id)
                        <a href="#"  data-panel-id="{{$user->id}}" onclick="getUserMeeting(this)">{{$meet->total}}</a>
                        @break
                    @endif
                @endforeach
            </td>

            <td>
                @foreach($followup as $follow)
                    @if($follow->userId == $user->id)
                        <a href="#" data-panel-id="{{$user->id}}" onclick="getUserFollowup(this)">{{$follow->total}}</a>
                        @break
                    @endif
                @endforeach
            </td>


        </tr>
    @endforeach
    </tbody>

</table>


<script>
    function getUserSales(x) {
        var userId=$(x).data('panel-id');
//        alert(userId);
        $.ajax({
            type: 'POST',
            url: "{!! route('local.getUserSales') !!}",
            cache: false,
            @if(isset($startDate) && isset($endDate))
            data: {_token: "{{csrf_token()}}",startDate:"{{$startDate}}",endDate:"{{$endDate}}",userId:userId},
            @else
            data: {_token: "{{csrf_token()}}",userId:userId},
            @endif
            success: function (data) {
//                console.log(data);
                $('#userReportModalBody').html(data);
                $('#userReportModalHead').html('Sales');
                $('#userReportModal').modal();

            }
        });
    }

    function getUserMeeting(x) {
        var userId=$(x).data('panel-id');
//        alert(userId);
        $.ajax({
            type: 'POST',
            url: "{!! route('local.getUserMeeting') !!}",
            cache: false,
            @if(isset($startDate) && isset($endDate))
            data: {_token: "{{csrf_token()}}",startDate:"{{$startDate}}",endDate:"{{$endDate}}",userId:userId},
            @else
            data: {_token: "{{csrf_token()}}",userId:userId},
            @endif
            success: function (data) {
                $('#userReportModalBody').html(data);
                $('#userReportModalHead').html('Meeting');
                $('#userReportModal').modal();

            }
        });

    }

    function getUserFollowup(x) {
        var userId=$(x).data('panel-id');

        $.ajax({
            type: 'POST',
            url: "{!! route('local.getUserFollowup') !!}",
            cache: false,
            @if(isset($startDate) && isset($endDate))
            data: {_token: "{{csrf_token()}}",startDate:"{{$startDate}}",endDate:"{{$endDate}}",userId:userId},
            @else
            data: {_token: "{{csrf_token()}}",userId:userId},
            @endif
            success: function (data) {
                $('#userReportModalBody').html(data);
                $('#userReportModalHead').html('Followup');
                $('#userReportModal').modal();


            }
        });

    }



</script>