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
                <table id="managerDaily" class="table table-bordered table-responsive table-striped">
                    <thead>
                    <th>Name</th>
                    <th>Times</th>
                    </thead>
                    <tbody>
                    @foreach($wp as $user)
                        <tr>
                            <td>
                                {{ $user->userId }}
                            </td>

                            <td>
                                @foreach($work->where('userid', $user->id) as $s)
                                    @if(in_array($s->createtime, $highlightedTimes))
                                        <strong style="color: blue">{{ $s->createtime }}</strong>
                                    @elseif(in_array($s->createtime, $highlightedTimesMax))
                                        <strong style="color: red">{{ $s->createtime }}</strong>
                                    @else
                                        {{ $s->createtime }}
                                    @endif
                                    ||
                                @endforeach
                            </td>

                            <!-- <td>
                                @foreach($work->where('userid', $user->id) as $s)
                                    {{ $s->createtime." || "  }}
                                @endforeach
                            </td> -->
                        </tr>
                    @endforeach

                    </tbody>
                </table>
                </div>

                <div id="hourFilter"></div>
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





































