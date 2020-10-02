@extends('main')
@section('content')
    <style>
        @media only screen and (max-width: 1024px) {
            #info {
                margin-top: 10%;
            }
        }
    </style>
    <div class="card" id="info">
        <div class="card-body">

        <div id="exTab2">
            <ul class="nav nav-tabs">
              <li class="nav-item">
                <a  class="nav-link" href="" id="firstClick" data-toggle="tab" onclick="value()">Value</a>
              </li>
              <li class="nav-item">
                <a href="" class="nav-link" data-toggle="tab" onclick="graphy()">Graph</a>
              </li>
              <li class="nav-item">
                <a href="#3" class="nav-link" data-toggle="tab" onclick="fileTypeDay()">Status</a>
              </li>

                {{--<li class="nav-item">
                    <a href="#4" class="nav-link" data-toggle="tab" onclick="fileProcessHour()">File Process / Hour</a>
                </li>
                <li class="nav-item">
                    <a href="#4" class="nav-link" data-toggle="tab" onclick="fileCountMonth()">File Count / Month</a>
                </li>

                <li class="nav-item">
                    <a href="#4" class="nav-link" data-toggle="tab" id="firstClick"  onclick="employeeWorkDay()">Employee's Work / Day</a>
                </li>

                <li class="nav-item">
                    <a href="#4" class="nav-link" data-toggle="tab" onclick="employeeWorkMonth()">Employee's Work / Month</a>
                </li>
                <li class="nav-item">
                    <a href="#4" class="nav-link" data-toggle="tab" onclick="revenueMonth()">Revenue / Month</a>
                </li>

                <li class="nav-item">
                    <a href="#4" class="nav-link" data-toggle="tab" onclick="revenueClient()">Revenue / Client</a>
                </li>--}}

            </ul>


            <div class="tab-content">

                <div class="tab-pane active" id="result">
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('foot-js')



<script>
    $('#firstClick').click();
    function value() {
        $.ajax({
            type: 'POST',
            url: "{!! route('reportTable') !!}",
            cache: false,
            data: {_token:"{{csrf_token()}}"},
            success: function (data) {
                $('#result').html(data);
            }

        });

    }

    function dateval(){

        var from=$("#fromDate").on("change").val();
        var to=$("#toDate").on("change").val();
        $.ajax({
            type: 'POST',
            url: "{!! route('searchTableByDate') !!}",
            cache: false,
            // data:{_token: CSRF_TOKEN, 'fromDate':from,'toDate':to},
            data:{_token:"{{csrf_token()}}", fromDate: from, toDate: to},
            success: function (data){
                $('#result').html(data);
            }
        });
    }

    function graphy() {
        $.ajax({
            type: 'POST',
            url: "{!! route('reportGraph') !!}",
            cache: false,
            data: {_token:"{{csrf_token()}}"},
            success: function (data) {
                $('#result').html(data);
            }

        });

    }

    function dategraph(){

        var from=$("#fromDate").on("change").val();
        var to=$("#toDate").on("change").val();
        $.ajax({
            type: 'POST',
            url: "{!! route('searchGraphByDate') !!}",
            cache: false,
            // data:{_token: CSRF_TOKEN, 'fromDate':from,'toDate':to},
            data:{_token:"{{csrf_token()}}", fromDate: from, toDate: to},
            success: function (data){
                $('#result').html(data);
            }
        });
    }
</script>


@endsection
