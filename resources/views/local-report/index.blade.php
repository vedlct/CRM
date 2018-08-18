@extends('main')
@section('content')
<br>
<div class="card">

    <div class="card-body">

        <div id="exTab2">
            <ul class="nav nav-tabs">

                <li class="nav-item">
                    <a  class="nav-link" href="" id="firstClick" data-toggle="tab" onclick="localrevenue()">Revenue</a>
                </li>

                <li class="nav-item">
                    <a href="#result" class="nav-link" data-toggle="tab" onclick="employeeReport()">Employee</a>
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


    {{--<script src="{{url('js/select2.min.js')}}"></script>--}}
    <script src="{{url('assets/plugins/datatables/jquery.dataTables.min.js')}}"></script>
    <script src="{{url('cdn.datatables.net/buttons/1.2.2/js/dataTables.buttons.min.js')}}"></script>
    <script src="{{url('cdn.datatables.net/buttons/1.2.2/js/buttons.flash.min.js')}}"></script>
    <script src="{{url('cdn.datatables.net/buttons/1.2.2/js/buttons.html5.min.js')}}"></script>


    <script>
        $('#firstClick').click();
        
        function localrevenue() {
            $.ajax({
                type: 'POST',
                url: "{!! route('local.revenueClient') !!}",
                cache: false,
                data: {_token: "{{csrf_token()}}"},
                success: function (data) {
//                    console.log(data);
                    $("#result").html(data);

                }
            });


        }

        function employeeReport() {
            $.ajax({
                type: 'POST',
                url: "{!! route('local.employeeReport') !!}",
                cache: false,
                data: {_token: "{{csrf_token()}}"},
                success: function (data) {
//                    console.log(data);
                    $("#result").html(data);

                }
            });

        }
        
        
    </script>

@endsection
