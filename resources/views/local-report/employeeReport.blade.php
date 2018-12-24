<!-- The Modal -->
<div class="modal fade" id="empModal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Employee Payment History</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <!-- Modal body -->
            <div class="modal-body" id="empModalBody">




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
    <th>Jan</th>
    <th>Feb</th>
    <th>Mar</th>
    <th>Apr</th>
    <th>May</th>
    <th>Jun</th>
    <th>Jul</th>
    <th>Aug</th>
    <th>Sep</th>
    <th>Oct</th>
    <th>Nov</th>
    <th>Dec</th>
    <th>Total</th>

    </thead>
    <tbody>

    @foreach($users as $user)
        @php($grandTotal=0)
        <tr>
            <td>{{$user->firstName}}</td>
            <td>
                @foreach($bills as $bill)
                    @if($bill->userId == $user->id && $bill->month==1)
                        <a href="#" data-user="{{$bill->userId }}" data-month="{{$bill->month }}" onclick="getReportLog(this)">{{$bill->total}}</a>
                        @php($grandTotal+=$bill->total)
                    @endif
                @endforeach
            </td>
            <td>
                @foreach($bills as $bill)
                    @if($bill->userId == $user->id && $bill->month==2)
                        <a href="#" data-user="{{$bill->userId }}" data-month="{{$bill->month }}" onclick="getReportLog(this)">{{$bill->total}}</a>
                        @php($grandTotal+=$bill->total)
                    @endif
                @endforeach
            </td>
            <td>
                @foreach($bills as $bill)
                    @if($bill->userId == $user->id && $bill->month==3)
                        <a href="#" data-user="{{$bill->userId }}" data-month="{{$bill->month }}" onclick="getReportLog(this)">{{$bill->total}}</a>
                        @php($grandTotal+=$bill->total)
                    @endif
                @endforeach
            </td>
            <td>
                @foreach($bills as $bill)
                    @if($bill->userId == $user->id && $bill->month==4)
                        <a href="#" data-user="{{$bill->userId }}" data-month="{{$bill->month }}" onclick="getReportLog(this)">{{$bill->total}}</a>
                        @php($grandTotal+=$bill->total)
                    @endif
                @endforeach
            </td>
            <td>
                @foreach($bills as $bill)
                    @if($bill->userId == $user->id && $bill->month==5)
                        <a href="#" data-user="{{$bill->userId }}" data-month="{{$bill->month }}" onclick="getReportLog(this)">{{$bill->total}}</a>
                        @php($grandTotal+=$bill->total)
                    @endif
                @endforeach
            </td>
            <td>
                @foreach($bills as $bill)
                    @if($bill->userId == $user->id && $bill->month==6)
                        <a href="#" data-user="{{$bill->userId }}" data-month="{{$bill->month }}" onclick="getReportLog(this)">{{$bill->total}}</a>
                        @php($grandTotal+=$bill->total)
                    @endif
                @endforeach
            </td>
            <td>
                @foreach($bills as $bill)
                    @if($bill->userId == $user->id && $bill->month==7)
                        <a href="#" data-user="{{$bill->userId }}" data-month="{{$bill->month }}" onclick="getReportLog(this)">{{$bill->total}}</a>
                        @php($grandTotal+=$bill->total)
                    @endif
                @endforeach
            </td>
            <td>
                @foreach($bills as $bill)
                    @if($bill->userId == $user->id && $bill->month==8)
                        <a href="#" data-user="{{$bill->userId }}" data-month="{{$bill->month }}" onclick="getReportLog(this)">{{$bill->total}}</a>
                        @php($grandTotal+=$bill->total)
                    @endif
                @endforeach
            </td>
            <td>
                @foreach($bills as $bill)
                    @if($bill->userId == $user->id && $bill->month==9)
                        <a href="#" data-user="{{$bill->userId }}" data-month="{{$bill->month }}" onclick="getReportLog(this)">{{$bill->total}}</a>
                        @php($grandTotal+=$bill->total)
                    @endif
                @endforeach
            </td>
            <td>
                @foreach($bills as $bill)
                    @if($bill->userId == $user->id && $bill->month==10)
                        <a href="#" data-user="{{$bill->userId }}" data-month="{{$bill->month }}" onclick="getReportLog(this)">{{$bill->total}}</a>
                        @php($grandTotal+=$bill->total)
                    @endif
                @endforeach
            </td>
            <td>
                @foreach($bills as $bill)
                    @if($bill->userId == $user->id && $bill->month==11)
                        <a href="#" data-user="{{$bill->userId }}" data-month="{{$bill->month }}" onclick="getReportLog(this)">{{$bill->total}}</a>

                        @php($grandTotal+=$bill->total)
                    @endif
                @endforeach
            </td>
            <td>
                @foreach($bills as $bill)
                    @if($bill->userId == $user->id && $bill->month==12)
                        <a href="#" data-user="{{$bill->userId }}" data-month="{{$bill->month }}" onclick="getReportLog(this)">{{$bill->total}}</a>

                        @php($grandTotal+=$bill->total)
                    @endif
                @endforeach
            </td>

            <td>
                {{$grandTotal}}
            </td>


        </tr>
    @endforeach
    </tbody>
</table>


<script>

    function getReportLog(x) {

        var userId=$(x).data('user');
        var month=$(x).data('month');


        $.ajax({
            type: 'POST',
            url: "{!! route('local.getUserRevenueLog') !!}",
            cache: false,
            data: {_token: "{{csrf_token()}}",userId:userId,month:month},
            success: function (data) {
//                console.log(data);
                $("#empModalBody").html(data);
                $('#empModal').modal();

            }
        });

    }
</script>