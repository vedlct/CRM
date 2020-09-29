@extends('main')

@section('content')



    <div class="card" style="padding:10px;">

        <div class="card-body">
            <h2 class="card-title" align="center"><b>Hour Report</b></h2>

            <div class="row">
                <div class="col-3">
                    <div class="form-group">
                        <input type="date" onchange="day()" id="selectedDay" class="form-control ">
                    </div>
                </div>

                <div class="table-responsive">
                    <table id="managerDaily" class="table table-bordered table-striped">
                        <thead>
                        <td>Name</td>
                        {{--                        <tr>--}}
                        {{--                            @foreach($wp as $user)--}}
                        {{--                            <th>{{ $user->userId }}</th>--}}
                        {{--                            @endforeach--}}
                        {{--                            <th>Time</th>--}}
                        {{--                        </tr>--}}
                        </thead>
                        <tbody>

                        {{-- @foreach($wp as $user)
                         <tr>
                             <td>{{ $user->userId }}</td>
                             @foreach($timeDiff as $t)
                             <td>
                                     {{ $t }}
                                 </td>
                             @endforeach
                         </tr>
                         @endforeach--}}

                        @foreach($wp as $user)
                            <tr>
                                <td>
                                    {{ $user->userId }}
                                </td>
                                @foreach($work->where('userid', $user->id) as $s)
                                <td>{{ $s->createtime }}</td>
                            @endforeach
                            </tr>
                        @endforeach

                        </tbody>
                    </table>
                    <div id="hourFilter"></div>

                </div>

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
    <meta name="csrf-token" content="{{ csrf_token() }}"/>

{{--    <script>--}}
{{--        $(document).ready(function () {--}}
{{--            $('#managerDaily').DataTable({--}}
{{--                "bSort": false--}}
{{--            });--}}

{{--        });--}}
{{--    </script>--}}
    <script>
        function day() {
            $("#managerDaily").hide();
            var selectedDay = document.getElementById("selectedDay").value;
            $.ajax({
                type: 'POST',
                url: "{!! route('hour.report-filter') !!}",
                cache: false,
                data: {_token: "{{csrf_token()}}", 'selectedDay': selectedDay},
                success: function (data) {
                    // alert(data);
                    $("#hourFilter").html(data);
                }
            });
        }
    </script>

@endsection





































