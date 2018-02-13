
@extends('main')


@section('content')
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

    {{--<script type="text/javascript" src={{url('js/googlechart.js')}}></script>--}}
    <script type="text/javascript">
        google.charts.load('current', {'packages':['bar']});
        google.charts.setOnLoadCallback(drawChart);


        function drawChart() {
            var data = google.visualization.arrayToDataTable([
                ['Name', 'Call', 'Lead mine', 'High Possibility'],



                    @foreach($report as $r)
                ['{{$r->userName}}',{{$r->called}}, {{$r->leadMined}}, {{$r->highPosibilities}}],

                @endforeach
                //                ['2014', 100, 40, 20],
                //                ['2015', 17, 46, 25],
                //                ['2016', 66, 90, 30],
                //                ['2017', 100, 50, 30]
            ]);

            var options = {
                chart: {
                    title: 'Employees Performence',
                    subtitle: 'This week',
                },

                vAxis: {
                    viewWindowMode:'explicit',
                    viewWindow: {
                        max:100,
                        min:0

                    },

                }
            };

            var chart = new google.charts.Bar(document.getElementById('columnchart_material'));

            chart.draw(data, google.charts.Bar.convertOptions(options));
        }
    </script>
    <div class="box-body">
        <div class="card" style="padding: 0px;">
            <div class="card-body">
              <div id="columnchart_material" style="width: 100%; height: 600px;  "></div>
            </div>
        </div>
    </div>

@endsection






