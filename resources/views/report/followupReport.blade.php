@extends('main')
@section('content')

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
                <table class="table table-striped table-bordered valueReport">
                    <thead>
                    <tr>
                        <th>User Name</th>
                        <th>Total Follow-Up</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($users as $user)
                        @php
                        $total = 0;
                        @endphp

                        @foreach( $followups->where('userId', $user->id) as $followup)
                            <tr>
                                <td>{{ $user->userId }}</td>
                                <td>{{ $followup->total }}</td>
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
            $(".valueReport").DataTable();
        });
    </script>

@endsection