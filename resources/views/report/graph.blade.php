@extends('main')
@section('header')
    <style>
        .canvasjs-chart-credit {
            display: none;
        }
    </style>
@endsection
@section('content')
    <div class="card">
        <div class="card-body">
            <label><b>Search</b></label>
            <form method="post" action="{{route('searchGraphByDate')}}">
                {{csrf_field()}}
                <div class="row">
                    <div class="col-auto mb-2">
                        <input type="text" placeholder=" From" id="fromdate" name="fromDate" style="border-radius: 50px;"
                        required>
                    </div>
                    <div class="col-auto mb-2">
                        <input type="text" placeholder=" To" id="todate" name="toDate" style="border-radius: 50px;" required>
                    </div>
                    <div class="col-md-5 mb-2">
                        <button type="submit" class="btn btn-success">Search</button>
                    </div>
                </div>
            </form>

            <div id="chartContainer" style="height: 600px; width:100%;"></div>
        </div>
    </div>

@endsection

@section('foot-js')
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script src="{{url('js/chart.js')}}"></script>


<script>
    $(function () {
        $("#fromdate").datepicker();
        $("#todate").datepicker();
    });
    window.onload = function () {
        function compareDataPointYAscend(dataPoint1, dataPoint2) {
            return dataPoint1.y - dataPoint2.y;
        }

        function compareDataPointYDescend(dataPoint1, dataPoint2) {
            return dataPoint2.y - dataPoint1.y;
        }

        var chart = new CanvasJS.Chart("chartContainer", {
            animationEnabled: true,

            title: {
                @if(isset($fromDate) && isset($toDate))
                text: "Report Of Employee From {{$fromDate}} To {{$toDate}}",

                @else
                text: "Monthly Report Of Employee"
                @endif
            },

            axisY2: {
                title: "M-lead mined ,P- high possibility,Con- Contact",
                maximum: 100,

            },
            axisX: {
                interval: 1,

            },
            data: [{
                type: "bar",
                name: "companies",
                axisYType: "secondary",

                dataPoints: [
                        @foreach($report as $r)
                        @if($r->typeId==4)
                    {
                        label: "{{$r->userName}}",
                        y:{{($r->leadMined*50/100)+($r->highPosibilities*50/100)}},
                        indexLabel: "M:{{$r->leadMined}}%,P:{{$r->highPosibilities}}%"
                    },
                        @elseif($r->typeId==5)
                    {
                        label: "{{$r->userName}}",
                        y:{{(($r->testLead*20/100)+($r->leadMined*10/100)+($r->contacted*30/100)+($r->targetFile*30/100)+($r->called*10/100))}},
                        indexLabel: "T:{{$r->testLead}}%,F:{{$r->targetFile}}%,Con: {{$r->contacted}}%,Call: {{$r->called}}%"
                    },

                        @elseif($r->typeId==3 || $r->typeId==2)

                    {
                        label: "{{$r->userName}}",
                        y:{{(($r->testLead*20/100)+($r->contacted*40/100)+($r->targetFile*30/100)+($r->called*10/100))}},
                        indexLabel: "T:{{$r->testLead}}%,F:{{$r->targetFile}}%,Con: {{$r->contacted}},Call: {{$r->called}}% "
                    },

                    @endif

                    @endforeach

                ]
            }]
        });
        chart.options.data[0].dataPoints.sort(compareDataPointYAscend);
        chart.render();
    }
</script>

@endsection










