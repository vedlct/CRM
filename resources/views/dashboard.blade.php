@extends('main')



@section('content')


    {{--<div id="chart-div"></div>--}}

    {{--<?//= $lava->render('PieChart', 'IMDB', 'chart-div') ?>--}}

<br><br>
    <div class="row" >

    <div class="col-lg-3 col-md-6">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Call</h4>
                <div class="text-right">
                    <h2 class="font-light m-b-0"> {{$calledThisWeek}}</h2>
                    <span class="text-muted">Already Called This Week</span>
                </div>
                <span class="text-success">90%</span>
                <div class="progress">
                    <div class="progress-bar bg-success" role="progressbar" style="width: 100%; height: 6px;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
            </div>
        </div>
    </div>


    <div class="col-lg-3 col-md-6">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Lead Mined</h4>
                <div class="text-right">
                    <h2 class="font-light m-b-0"><i class="ti-arrow-up text-info"></i>{{$leadMined}}</h2>
                    <span class="text-muted">Lead Mined This Week</span>
                </div>
                <span class="text-info">30%</span>
                <div class="progress">
                    <div class="progress-bar bg-info" role="progressbar" style="width: 30%; height: 6px;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
            </div>
        </div>
    </div>




        <div class="col-lg-3 col-md-6">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Follow Up</h4>
                    <div class="text-right">
                        <h2 class="font-light m-b-0">{{$totalFollowUpCalled}} | {{$totalFollowUp}}</h2>
                        <span class="text-muted">Total Followup This Week</span>
                    </div>
                    <?php $followupPercent = round($totalFollowUpCalled*$totalFollowUp/100) ?>
                    <span class="text-purple">{{$followupPercent}}%</span>
                    <div class="progress">
                        <div class="progress-bar bg-purple" role="progressbar" style="width: <?php echo $followupPercent ?>%; height: 6px;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Total Called Last Day</h4>
                    <div class="text-right">
                        <h2 class="font-light m-b-0">{{$lastDayCalled}}</h2>
                        <span class="text-muted">Yesterday Call</span>
                    </div>

                </div>
            </div>
        </div>

    </div>

    {{--Graph--}}

    <div class="row">

        <div class="col-md-2">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">Members</h4>
            @foreach($teamMembers as $member)
                <button id="{{$member->id}}" onclick="showGraph(this.id)"> {{$member->firstName}}</button><br><br>

                @endforeach


        </div>
    </div></div>


        <div class="col-md-10">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Graph</h4>

                    <div id="chart_div"></div>



                </div>
            </div></div>






    </div>




@endsection


@section('foot-js')
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script>


        function showGraph(id){
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');


            $.ajax({
                type:'POST',
                url:'{{route('getUserGraph')}}',
                data:{_token: CSRF_TOKEN,'id':id},
                cache: false,
                success:function(data)
                {
                   console.log(data);
                  // alert(data.name);
                   test(data.name);
                }
            });


        }


        function test(x) {
            alert(x)
        }

        google.charts.load('current', {packages: ['corechart', 'bar']});
        google.charts.setOnLoadCallback(drawBasic);

        function drawBasic() {

            var data = new google.visualization.DataTable();
            data.addColumn('timeofday', 'Time of Day');
            data.addColumn('number', 'Motivation Level');

            data.addRows([
                [{v: [8, 0, 0], f: '8 am'}, 1],
                [{v: [9, 0, 0], f: '9 am'}, 2],
                [{v: [10, 0, 0], f:'10 am'}, 3],
                [{v: [11, 0, 0], f: '11 am'}, 4],
                [{v: [12, 0, 0], f: '12 pm'}, 5],
                [{v: [13, 0, 0], f: '1 pm'}, 6],
                [{v: [14, 0, 0], f: '2 pm'}, 7],
                [{v: [15, 0, 0], f: '3 pm'}, 8],
                [{v: [16, 0, 0], f: '4 pm'}, 9],
                [{v: [17, 0, 0], f: '5 pm'}, 10],
            ]);

            var options = {
                title: 'Motivation Level Throughout the Day',
                hAxis: {
                    title: 'Time of Day',
                    format: 'h:mm a',
                    viewWindow: {
                        min: [7, 30, 0],
                        max: [17, 30, 0]
                    }
                },
                vAxis: {
                    title: 'Rating (scale of 1-10)'
                }
            };

            var chart = new google.visualization.ColumnChart(
                document.getElementById('chart_div'));

            chart.draw(data, options);
        }


    </script>





    @endsection