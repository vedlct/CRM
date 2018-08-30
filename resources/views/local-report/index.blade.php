@extends('main')
@section('content')
<br>
<div class="card">
<div class="card-body">
    <form method="get" action="{{route('local.report')}}">
    <div class="row">
        <div class="col-md-4">
            <input placeholder="Start Date" name="startDate"  @if(isset($startDate)) value="{{$startDate}}" @endif class="form-control datepicker" >
        </div>

        <div class="col-md-4">
            <input placeholder="End Date" name="endDate" class="form-control datepicker" @if(isset($endDate)) value="{{$endDate}}" @endif >
        </div>
        <div class="col-md-4">
            <button class="btn btn-success">Search</button>
        </div>
    </div>
    </form>
</div>
    <div class="card-body">

        <div id="exTab2">
            <ul class="nav nav-tabs">



                <li class="nav-item">
                    <a href="#" class="nav-link" id="firstClick" data-toggle="tab" onclick="workReportUser()">User Report</a>
                </li>
                <li class="nav-item">
                        <a href="#" class="nav-link" data-toggle="tab" onclick="employeeReport()">Employee Revenue</a>
                </li>
                @if(Auth::user()->typeId==1 || Auth::user()->typeId==6 || Auth::user()->typeId==9)
                    <li class="nav-item">
                        <a  class="nav-link" href=""  data-toggle="tab" onclick="localrevenue()">Client Revenue</a>
                    </li>
                @endif

                <li class="nav-item">
                    <a href="#" class="nav-link" data-toggle="tab" onclick="leadAssignReport()">Lead Assign</a>
                </li>


            </ul>

            <div class="tab-content">
                <div class="tab-pane active" id="result">
                </div>

            </div>
        </div>



    </div>

</div>




@endsection

@section('bottom')

    <script src="{{url('assets/plugins/datatables/jquery.dataTables.min.js')}}"></script>
    <script src="{{url('cdn.datatables.net/buttons/1.2.2/js/dataTables.buttons.min.js')}}"></script>
    <script src="{{url('cdn.datatables.net/buttons/1.2.2/js/buttons.flash.min.js')}}"></script>
    <script src="{{url('cdn.datatables.net/buttons/1.2.2/js/buttons.html5.min.js')}}"></script>


    <script>
        $( function() {
            $( ".datepicker" ).datepicker();

        } );
        $('#firstClick').click();
        
        function localrevenue() {
            $.ajax({
                type: 'POST',
                url: "{!! route('local.revenueClient') !!}",
                cache: false,
                @if(isset($startDate) && isset($endDate))
                data: {_token: "{{csrf_token()}}",startDate:"{{$startDate}}",endDate:"{{$endDate}}"},
                @else
                data: {_token: "{{csrf_token()}}"},
                @endif
                success: function (data) {
                    $("#result").html(data);

                }
            });


        }
        
        function workReportUser() {
            $.ajax({
                type: 'POST',
                url: "{!! route('local.workReportUser') !!}",
                cache: false,
                @if(isset($startDate) && isset($endDate))
                data: {_token: "{{csrf_token()}}",startDate:"{{$startDate}}",endDate:"{{$endDate}}"},
                @else
                data: {_token: "{{csrf_token()}}"},
                @endif
                success: function (data) {
                    $("#result").html(data);
//                    console.log(data);

                }
            });

        }

        function leadAssignReport() {
            $.ajax({
                type: 'POST',
                url: "{!! route('local.leadAssignReport') !!}",
                cache: false,
                @if(isset($startDate) && isset($endDate))
                data: {_token: "{{csrf_token()}}",startDate:"{{$startDate}}",endDate:"{{$endDate}}"},
                @else
                data: {_token: "{{csrf_token()}}"},
                @endif
                success: function (data) {
                    $("#result").html(data);
//                    console.log(data);

                }
            });
        }

        function employeeReport() {
            $.ajax({
                type: 'POST',
                url: "{!! route('local.employeeReport') !!}",
                cache: false,
                @if(isset($startDate) && isset($endDate))
                data: {_token: "{{csrf_token()}}",startDate:"{{$startDate}}",endDate:"{{$endDate}}"},
                @else
                data: {_token: "{{csrf_token()}}"},
                @endif
                success: function (data) {
//                    console.log(data);
                    $("#result").html(data);

                }
            });

        }
        
        
    </script>

@endsection
