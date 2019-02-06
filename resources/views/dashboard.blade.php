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

    <div class="col-lg-2 col-md-6">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title"><a href="{{route('called')}}">New Call</a></h4>
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




            <div class="col-lg-2 col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title"><a href="{{route('contact')}}">Contact</a></h4>
                        <div class="text-right">
                            <h2 class="font-light m-b-0"> {{$contactCall}} | {{$target->targetContact}}</h2>
                            <span class="text-muted">This Month</span>
                        </div>
                        @if($target->targetContact>0)
                            <?php
                            $lastContactPercent= round(($contactCall/$target->targetContact)*100);
                            if($lastContactPercent > 100){
                                $lastContactPercent=100;
                            }
                            $count++; $total+=$contactThisWeek;
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

            {{--<div class="col-lg-2 col-md-6">--}}
                {{--<div class="card">--}}
                    {{--<div class="card-body">--}}
                        {{--<h4 class="card-title"><a href="{{route('contactUsa')}}">USA</a></h4>--}}
                        {{--<div class="text-right">--}}
                            {{--<h2 class="font-light m-b-0"> {{$contactedUsaCount}} | {{$target->targetUsa}}</h2>--}}
                            {{--<span class="text-muted">This Month</span>--}}
                        {{--</div>--}}
                        {{--@if($target->targetUsa>0)--}}

                            {{--<span class="text-success">{{round($contactedUsa)}}%</span>--}}
                        {{--@endif--}}
                        {{--<div class="progress">--}}
                            {{--@if($target->targetContact>0)--}}
                                {{--<div class="progress-bar bg-success" role="progressbar" style="width: {{$contactedUsa}}%; height: 6px;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>--}}
                            {{--@endif--}}
                        {{--</div>--}}
                    {{--</div>--}}
                {{--</div>--}}
            {{--</div>--}}


    <div class="col-lg-2 col-md-6">
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

            <div class="col-lg-2 col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title"><a href="{{route('testLead')}}">Test Lead</a></h4>
                        <div class="text-right">
                            <h2 class="font-light m-b-0">{{$testLeadCount}} | {{$target->targetTest}}</h2>
                            <span class="text-muted">This Month</span>
                        </div>

                        @if($target->targetTest>0)
                            <span class="text-purple">{{round($testLead)}}%</span>
                        @endif
                        <div class="progress">
                            @if($target->targetTest>0)
                                <div class="progress-bar bg-purple" role="progressbar" style="width:{{$testLead}}%; height: 6px;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            @if(Auth::user()->typeId==4)

            <div class="col-lg-2 col-md-6">
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

            @endif




            <div class="col-lg-2 col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title"><a href="{{route('files')}}">New File</a></h4>
                        <div class="text-right">
                            <h2 class="font-light m-b-0">{{$fileCount}} | {{$target->targetFile }}</h2>
                            <span class="text-muted">This Month</span>
                        </div>

                        @if($target->targetFile>0)
                            <span class="text-purple">{{round($targetNewFile)}}%</span>
                        @endif
                        <div class="progress">
                            @if($target->targetFile>0)
                                <div class="progress-bar bg-purple" role="progressbar" style="width:{{$targetNewFile}}%; height: 6px;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>



    </div>

{{--Total Progress--}}





<div class="row">
    <div class="col-md-12">
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
                                @if(Auth::user()->typeId==4)
                            { y: {{$highPosibilitiesThisWeek}}, label: "High Possibility This Week" ,indexLabel: "{{$highPosibilitiesThisWeek}}%"},
                                @endif
                              { y: {{ $calledThisWeek}},  label: "New Call",indexLabel: "{{$calledThisWeek}}%" },
                              { y: {{ $targetNewFile}},  label: "New File",indexLabel: "{{$targetNewFile}}%" },
                            { y: {{$contactThisWeek}},  label: "Contact",indexLabel: "{{$contactThisWeek}}%" },
                            {{--{ y: {{$contactedUsa}},  label: "USA",indexLabel: "{{$contactedUsa}}%" },--}}
                                @if(Auth::user()->typeId==4)
                            { y: {{$leadMinedThisWeek}},  label: "Lead Mined",indexLabel: "{{$leadMinedThisWeek}}%" },
                                @endif
                            { y: {{$testLead}},  label: "Test Lead",indexLabel: "{{$testLead}}%" },

                            @if($userType=="RA")
                            { y: {{(($highPosibilitiesThisWeek*50/100)+($leadMinedThisWeek*50/100))}},  label: "Total Progress",indexLabel: "{{round(($highPosibilitiesThisWeek*50/100)+($leadMinedThisWeek*50/100))}}%" },
                                @elseif($userType=="USER")
                            { y:{{(($targetNewFile*30/100)+($testLead*30/100)+($calledThisWeek*30/100)+($contactThisWeek*20/100))}},label: "Total Progress",indexLabel: "{{round(($targetNewFile*30/100)+($calledThisWeek*30/100)+($testLead*30/100)+($contactThisWeek*10/100))}}%" },
                            @elseif($userType=="MANAGER" ||$userType=="SUPERVISOR")
                            { y:{{(($targetNewFile*30/100)+($testLead*30/100)+($calledThisWeek*30/100)+($contactThisWeek*25/100))}},label: "Total Progress",indexLabel: "{{round(($targetNewFile*30/100)+($calledThisWeek*30/100)+($testLead*30/100)+($contactThisWeek*10/100))}}%" },
                            @endif

                        ]
                    }]
                });
            chart.render();


        }



    </script>





    @endsection