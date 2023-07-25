@extends('main')
@section('content')
    <div class="modal" id="highPossibility" role="dialog">
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
        <label><b>Search</b></label>
        <form method="post" action="{{route('searchFollowupByDate')}}">
            {{csrf_field()}}
            <input type="text" placeholder=" From" id="fromdate" name="fromDate" style="border-radius: 50px;">
            <input type="text" placeholder=" To" id="todate" name="toDate" style="border-radius: 50px;">
            <button type="submit" class="btn btn-success">Search</button>
        </form>

        <div class="card-body">
            <h2>Report</h2>
            @if(isset($fromDate) && isset($toDate))
                <p>Report From {{$fromDate}} to {{$toDate}}</p>
            @else
                <p>Follow-Up report</p>
            @endif

            @if(Auth::user()->typeId == 2 || Auth::user()->typeId ==3)
                <table id="followReport" class="table table-striped table-bordered valueReport">
                    <thead>
                    <tr>
                        <th>User Name</th>
                        <th>Not Done Follow-Up</th>
                        <th>All Follow-Up</th>
                    </tr>
                    </thead>
                    <tbody>
{{--                    {{ dd($followups) }}--}}

                    @foreach($users as $user)
                        @foreach( $followups->where('userId', $user->id) as $notDoneFollowup)
                            <tr>
                                <td>{{ $user->userId }}</td>
                                <td><a href="#" onclick="getNotDoneFollowup(this)" data-userid="{{$notDoneFollowup->userId}}"
                                       @if(isset($fromDate) && isset($toDate))
                                       data-date-from="{{$fromDate}}"
                                       data-date-to="{{$toDate}}"
                                            @endif>{{ $notDoneFollowup->total }}</a>
                                </td>
                                <td>
                                    @foreach( $allFollowups->where('userId', $user->id) as $followup)
                                        <a href="#" onclick="getAllFollowup(this)" data-userid="{{$followup->userId}}"
                                           @if(isset($fromDate) && isset($toDate))
                                           data-date-from="{{$fromDate}}"
                                           data-date-to="{{$toDate}}"
                                                @endif>{{ $followup->total }}</a>
                                    @endforeach
                                </td>

                            </tr>
                        @endforeach
                    @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>
@endsection
@section('foot-js')
    <meta name="csrf-token" content="{{ csrf_token() }}"/>
    <script src="{{url('assets/plugins/datatables/jquery.dataTables.min.js')}}"></script>

    <script src="https://cdn.datatables.net/buttons/1.5.6/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.flash.min.js"></script>

    <script src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.html5.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.print.min.js"></script>

    <script>
        $(function () {
            $("#fromdate").datepicker();
            $("#todate").datepicker();
            $("#followReport").DataTable();
        });

        function getNotDoneFollowup(x) {
            var userid = $(x).data('userid');
            var followDate = $(x).data('follow-date');
            @if(isset($fromDate) && isset($toDate))
            var from = $(x).data('date-from');
            var to = $(x).data('date-to');

            @endif
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            $.ajax({
                type: 'POST',
                url: '{{route('getNotDoneFollowup')}}',
                @if(isset($fromDate) && isset($toDate))
                data: {_token: CSRF_TOKEN, 'fromdate': from, 'todate': to, 'userId': userid},
                @else
                data: {_token: CSRF_TOKEN, 'userId': userid},
                @endif
                cache: false,
                success: function (data) {
                    // console.log(data);
                    $('#highPossibility').modal({show: true});
                    $('#label').html('Possibility');
                    $('#txtHint').html(data);
                    $('#myTable').DataTable();
                }
            });
        }

        function getAllFollowup(x) {
            var userid = $(x).data('userid');
            var followDate = $(x).data('follow-date');
            @if(isset($fromDate) && isset($toDate))
            var from = $(x).data('date-from');
            var to = $(x).data('date-to');

            @endif
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            $.ajax({
                type: 'POST',
                url: '{{route('getAllFollowup')}}',
                @if(isset($fromDate) && isset($toDate))
                data: {_token: CSRF_TOKEN, 'fromdate': from, 'todate': to, 'userId': userid},
                @else
                data: {_token: CSRF_TOKEN, 'userId': userid},
                @endif
                cache: false,
                success: function (data) {
                    // console.log(data);
                    $('#highPossibility').modal({show: true});
                    $('#label').html('Possibility');
                    $('#txtHint').html(data);
                    $('#myTable').DataTable();
                }
            });
        }

    </script>

@endsection