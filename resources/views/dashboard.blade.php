@extends('main')



@section('content')


    {{--<div id="chart-div"></div>--}}

    {{--<?//= $lava->render('PieChart', 'IMDB', 'chart-div') ?>--}}

<br><br>
    <div class="row" >

        <?php $count=0; $total=0;?>

    <div class="col-lg-3 col-md-6">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Call</h4>
                <div class="text-right">
                    <h2 class="font-light m-b-0"> {{$lastDayCalled}} | {{$target->targetCall}}</h2>
                    <span class="text-muted">Called Last Day</span>
                </div>
                @if($target->targetCall>0)
                    <?php $count++; $total+=($lastDayCalled/$target->targetCall)*100; ?>
                <span class="text-success">{{($lastDayCalled/$target->targetCall)*100}}%</span>
                @endif
                <div class="progress">
                    @if($target->targetCall>0)
                    <div class="progress-bar bg-success" role="progressbar" style="width: {{($lastDayCalled/$target->targetCall)*100}}%; height: 6px;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                    @endif
                </div>
            </div>
        </div>
    </div>


    <div class="col-lg-3 col-md-6">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Lead Mined</h4>
                <div class="text-right">
                    <h2 class="font-light m-b-0">{{$lastDayLeadMined}} | {{$target->targetLeadmine}}</h2>
                    <span class="text-muted">Lead Mined Last Day</span>
                </div>
                @if($target->targetLeadmine>0)
                    <?php $count++; $total+=($lastDayLeadMined/$target->targetLeadmine)*100; ?>
                <span class="text-info">{{($lastDayLeadMined/$target->targetLeadmine)*100}}%</span>
                @endif
                <div class="progress">
                    @if($target->targetLeadmine>0)
                    <div class="progress-bar bg-info" role="progressbar" style="width: {{($lastDayLeadMined/$target->targetLeadmine)*100}}%; height: 6px;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                        @endif
                </div>
            </div>
        </div>
    </div>



            <div class="col-lg-3 col-md-6">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">High Possibilities</h4>
                    <div class="text-right">
                        <h2 class="font-light m-b-0">{{$highPosibilities}} | {{$target->targetHighPossibility}}</h2>
                        <span class="text-muted">Total Followup Last Day</span>
                    </div>
                    @if($target->targetHighPossibility>0)
                        <?php $count++; $total+=($highPosibilities/$target->targetHighPossibility)*100; ?>
                    <span class="text-purple">{{($highPosibilities/$target->targetHighPossibility)*100}}%</span>
                    @endif
                    <div class="progress">
                        @if($target->targetHighPossibility>0)
                        <div class="progress-bar bg-purple" role="progressbar" style="width:{{($highPosibilities/$target->targetHighPossibility)*100}}%; height: 6px;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Total Progress Last Day</h4>
                    <div class="text-right">
                        <h2 class="font-light m-b-0"></h2>
                        @if($count !=0)
                        <span class="text-muted">{{$total/$count}}%</span>
                        <div class="progress">
                        <div class="progress-bar bg-purple" role="progressbar" style="width:{{$total/$count}}%; height: 6px;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                            @endif
                    </div>

                </div>
            </div>
        </div>

    </div>

    {{--Graph--}}
    {{--@php($userType = Session::get('userType'))--}}

    {{--@if($userType=='ADMIN' || $userType=='MANAGER' || $userType=='SUPERVISOR')--}}

        {{--<div class="row">--}}

        {{--<div class="col-md-2">--}}
    {{--<div class="card">--}}
        {{--<div class="card-body">--}}
            {{--<h4 class="card-title">Members</h4>--}}
            {{--@foreach($teamMembers as $member)--}}
                {{--<button id="{{$member->id}}" onclick="showGraph(this.id)"> {{$member->firstName}}</button><br><br>--}}

                {{--@endforeach--}}


        {{--</div>--}}
    {{--</div></div>--}}


        {{--<div class="col-md-10">--}}
            {{--<div class="card">--}}
                {{--<div class="card-body">--}}
                    {{--<h4 class="card-title">Weekly Graph</h4>--}}

                    {{--<div id="chartContainer" style="height: 370px; width: 100%;"></div>--}}



                {{--</div>--}}
            {{--</div></div>--}}






    {{--</div>--}}
    {{--@endif--}}

<div class="row">
    <div class="col-md-10">
    <div class="card">
    <div class="card-body">
    <h4 class="card-title">Weekly Graph</h4>

    <div id="chartContainer" style="height: 370px; width: 100%;"></div>



    </div>
    </div></div></div>

@endsection


@section('foot-js')
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    {{--<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>--}}
    <script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
    <script>




        window.onload = function () {


                var chart = new CanvasJS.Chart("chartContainer", {
                    animationEnabled: true,
                    theme: "light2", // "light1", "light2", "dark1", "dark2"
                    title:{
                        text: "This Week Report"
                    },
                    axisY: {
                        title: "Limit",
                        maximum: 80,
                    },
                    data: [{
                        type: "column",
                        showInLegend: true,
                        legendMarkerColor: "grey",
                        legendText: "{{Auth::user()->firstName}}",
                        dataPoints: [
                            { y: {{$highPosibilitiesThisWeek}}, label: "High Possibility This Week" },
                            { y: {{ $calledThisWeek}},  label: "Called This Week" },
                            { y: {{$leadMinedThisWeek}},  label: "Lead Mined" }

                        ]
                    }]
                });
            chart.render();


        }




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

                    graph(data);
                }
            });


        }



        function graph(data) {

            var chart = new CanvasJS.Chart("chartContainer", {
                animationEnabled: true,
                theme: "light2", // "light1", "light2", "dark1", "dark2"
                title:{
                    text: "This Week Report"
                },
                axisY: {
                    title: "Limit",
                    maximum: 80,
                },
                data: [{
                    type: "column",
                    showInLegend: true,
                    legendMarkerColor: "grey",
                    legendText: "Name = "+data.name,
                    dataPoints: [
                        { y: data.totalFollowUp, label: "Total Follow Up" },
                        { y: data.totalFollowUpCalled, label: "Follow Up Called" },
                        { y: data.calledThisWeek,  label: "Called This Week" },
                        { y: data.leadMined,  label: "Lead Mined" }

                    ]
                }]
            });
            chart.render();

        }
    </script>





    @endsection