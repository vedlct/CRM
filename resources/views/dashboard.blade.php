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


<br><br>
    <div class="row" >

        <?php $count=0; $total=0; $lastCallPercent=0; $lastLeadMinedPercent=0; ?>

    <div class="col-lg-3 col-md-6">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title"><a href="{{route('called')}}">Call</a></h4>
                <div class="text-right">
                    <h2 class="font-light m-b-0"> {{$lastDayCalled}} | {{$target->targetCall}}</h2>
                    <span class="text-muted">This Month</span>
                </div>
                @if($target->targetCall>0)
                    <?php
                                  $lastCallPercent= round(($lastDayCalled/$target->targetCall)*100);
                                  if($lastCallPercent > 100){
                                      $lastCallPercent=100;
                                  }
                    $count++; $total+=$lastCallPercent;
                    ?>

                <span class="text-success">{{round($lastCallPercent)}}%</span>
                @endif
                <div class="progress">
                    @if($target->targetCall>0)
                    <div class="progress-bar bg-success" role="progressbar" style="width: {{$lastCallPercent}}%; height: 6px;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                    @endif
                </div>
            </div>
        </div>
    </div>




            <div class="col-lg-3 col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title"><a href="{{route('contact')}}">Contact</a></h4>
                        <div class="text-right">
                            <h2 class="font-light m-b-0"> {{$lastDayContact}} | {{$target->targetContact}}</h2>
                            <span class="text-muted">This Month</span>
                        </div>
                        @if($target->targetContact>0)
                            <?php
                            $lastContactPercent= round(($lastDayContact/$target->targetContact)*100);
                            if($lastContactPercent > 100){
                                $lastContactPercent=100;
                            }
                            $count++; $total+=$lastContactPercent;
                            ?>

                            <span class="text-success">{{round($lastContactPercent)}}%</span>
                        @endif
                        <div class="progress">
                            @if($target->targetContact>0)
                                <div class="progress-bar bg-success" role="progressbar" style="width: {{$lastContactPercent}}%; height: 6px;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>



    <div class="col-lg-3 col-md-6">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title"><a href="{{route('mine')}}">Lead Mined</a></h4>
                <div class="text-right">
                    <h2 class="font-light m-b-0">{{$lastDayLeadMined}} | {{$target->targetLeadmine}}</h2>
                    <span class="text-muted">This Month</span>
                </div>
                @if($target->targetLeadmine>0)
                    <?php $count++;
                    $lastLeadMinedPercent=($lastDayLeadMined/$target->targetLeadmine)*100;
                    if($lastLeadMinedPercent>100){
                        $lastLeadMinedPercent=100;
                    }
                    $total+=$lastLeadMinedPercent;


                    ?>
                <span class="text-info">{{round($lastLeadMinedPercent)}}%</span>
                @endif
                <div class="progress">
                    @if($target->targetLeadmine>0)
                    <div class="progress-bar bg-info" role="progressbar" style="width: {{$lastLeadMinedPercent}}%; height: 6px;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                        @endif
                </div>
            </div>
        </div>
    </div>


            <div class="col-lg-3 col-md-6">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title"><a href="{{route('highPossibility')}}">High Possibilities</a></h4>
                    <div class="text-right">
                        <h2 class="font-light m-b-0">{{$highPosibilities}} | {{$target->targetHighPossibility}}</h2>
                        <span class="text-muted">This Month</span>
                    </div>

                    @if($target->targetHighPossibility>0)
                        <span class="text-purple">{{round($highPosibilitiesThisWeek)}}%</span>
                    @endif
                    <div class="progress">
                        @if($target->targetHighPossibility>0)
                        <div class="progress-bar bg-purple" role="progressbar" style="width:{{$highPosibilitiesThisWeek}}%; height: 6px;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

{{--Total Progress--}}

 



<div class="row">
    <div class="col-md-10">
    <div class="card">
    <div class="card-body">
    <h4 class="card-title">Monthly Graph</h4>

    <div id="chartContainer" style="height: 370px; width: 100%;"></div>



    </div>
    </div></div></div>

@endsection
@php($userType = Session::get('userType'))

@section('foot-js')
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <script src="{{url('js/chart.js')}}"></script>
    <script>




        window.onload = function () {


                var chart = new CanvasJS.Chart("chartContainer", {
                    animationEnabled: true,
                    theme: "light2", // "light1", "light2", "dark1", "dark2"

                    axisY: {
                        maximum: 100,
                    },
                    data: [{
                        type: "column",
                        showInLegend: true,
                        legendMarkerColor: "grey",
                        legendText: "{{Auth::user()->firstName}}",
                        dataPoints: [
                            { y: {{$highPosibilitiesThisWeek}}, label: "High Possibility This Week" ,indexLabel: "{{$highPosibilitiesThisWeek}}%"},
                            { y: {{ $calledThisWeek}},  label: "Called This Week",indexLabel: "{{$calledThisWeek}}%" },
                            { y: {{$contactThisWeek}},  label: "Contact",indexLabel: "{{$contactThisWeek}}%" },
                            { y: {{$leadMinedThisWeek}},  label: "Lead Mined",indexLabel: "{{$leadMinedThisWeek}}%" },

                            @if($userType=="RA")
                            { y: {{(($highPosibilitiesThisWeek*50/100)+($leadMinedThisWeek*50/100))}},  label: "Total Progress",indexLabel: "{{round(($highPosibilitiesThisWeek*50/100)+($leadMinedThisWeek*50/100))}}%" },
                                @elseif($userType=="USER")
                            { y:{{(($highPosibilitiesThisWeek*50/100)+($calledThisWeek*20/100)+($leadMinedThisWeek*10/100)+($contactThisWeek*20/100))}},label: "Total Progress",indexLabel: "{{round(($highPosibilitiesThisWeek*50/100)+($calledThisWeek*20/100)+($leadMinedThisWeek*10/100)+($contactThisWeek*20/100))}}%" },
                            @elseif($userType=="MANAGER" ||$userType=="SUPERVISOR")
                            { y:{{(($highPosibilitiesThisWeek*50/100)+($calledThisWeek*25/100)+($contactThisWeek*25/100))}},label: "Total Progress",indexLabel: "{{round(($highPosibilitiesThisWeek*50/100)+($calledThisWeek*25/100)+($contactThisWeek*25/100))}}%" },
                            @endif

                        ]
                    }]
                });
            chart.render();


        }



    </script>





    @endsection