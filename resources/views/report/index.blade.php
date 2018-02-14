
@extends('main')
@section('header')
    <style>
        .canvasjs-chart-credit
        {
            display: none;
        }

    </style>

@endsection

@section('content')
    <div align="center" style="padding-top:50px;" >
        <div id="chartContainer" style="height: 600px; width:100%;"></div>


    </div>

@endsection

@section('foot-js')

    <meta name="csrf-token" content="{{ csrf_token() }}" />
    {{--<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>--}}
    <script src="{{url('js/chart.js')}}"></script>



    <script>
        window.onload = function () {
            function compareDataPointYAscend(dataPoint1, dataPoint2) {
                return dataPoint1.y - dataPoint2.y;
            }

            function compareDataPointYDescend(dataPoint1, dataPoint2) {
                return dataPoint2.y - dataPoint1.y;
            }

            var chart = new CanvasJS.Chart("chartContainer", {
                animationEnabled: true,

                title:{
                    text:"Weekly Report Of Employee"
                },
                axisX:{
                    interval: 1,

                },

                axisY2:{
                    title: "C-call ,M-lead mined ,P- high possibility",
                    maximum: 100,
                },
                data: [{
                    type: "bar",
                    name: "companies",
                    axisYType: "secondary",

                    dataPoints: [
                            @foreach($report as $r)
                        { label: "{{$r->userName}}",y:{{($r->called+$r->leadMined+$r->highPosibilities)/$r->t}},indexLabel:"C:{{$r->called}}%, M:{{$r->leadMined}}%,P:{{$r->highPosibilities}}%"},


                            @endforeach
//                        { y: 3, label: "Sweden" },
//                        { y: 7, label: "Taiwan" },
//                        { y: 5, label: "Russia" },
//                        { y: 9, label: "Spain" },
//                        { y: 7, label: "Brazil" },
//                        { y: 7, label: "India" },
//                        { y: 9, label: "Italy" },
//                        { y: 8, label: "Australia" },
//                        { y: 134, label: "US",indexLabel:"Lead 40% , Call 50% , Possibility 100%" }
                    ]
                }]
            });
            chart.options.data[0].dataPoints.sort(compareDataPointYAscend);
            chart.render();

        }
    </script>



    @endsection









