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
    <div class="seven-columns-row" >

        <?php $count=0; $total=0; $lastCallPercent=0; $lastLeadMinedPercent=0; ?>

    <div class="svn-col">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title"><a href="{{route('called')}}">Total Call</a></h4>
                <div class="text-right">
                    <h2 class="font-light m-b-0"> {{$lastDayCalled}} | {{$target->targetCall}}</h2>
                    <span class="text-muted">Current Month</span>
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
            <div class="svn-col">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title"><a href="{{route('conversation')}}"> Conversation</a></h4>
                        <div class="text-right">
                            <h2 class="font-light m-b-0"> {{$conversation}} | {{$target->conversation}}</h2>
                            <span class="text-muted">Current Month</span>
                        </div>
                        @if($target->conversation>0)
                            <?php
                            $lastContactPercent= round(($conversation/$target->conversation)*100);
                            if($lastContactPercent > 100){
                                $lastContactPercent=100;
                            }
                            $count++;
                            $total+=$conversation;
                            ?>

                            <span class="text-success">{{round($lastContactPercent)}}%</span>
                        @endif
                        <div class="progress">
                            @if($target->conversation>0)
                                <div class="progress-bar bg-success" role="progressbar" style="width: {{$lastContactPercent}}%; height: 6px;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>



    <div class="svn-col">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title"><a href="{{route('mine')}}">Lead Mined</a></h4>
                <div class="text-right">
                    <h2 class="font-light m-b-0">{{$lastDayLeadMined}} | {{$target->targetLeadmine}}</h2>
                    <span class="text-muted">Current Month</span>
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

            <div class="svn-col">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title"><a href="{{route('testLead')}}">Test Lead</a></h4>
                        <div class="text-right">
                            <h2 class="font-light m-b-0">{{$testLeadCount}} | {{$target->targetTest}}</h2>
                            <span class="text-muted">Current Month</span>
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

            <div class="svn-col">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title"><a href="{{route('highPossibility')}}">High Possibilities</a></h4>
                    <div class="text-right">
                        <h2 class="font-light m-b-0">{{$highPosibilities}} | {{$target->targetHighPossibility}}</h2>
                        <span class="text-muted">Current Month</span>
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




            <div class="svn-col">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title"><a href="{{route('files')}}">New File</a></h4>
                        <div class="text-right">
                            <h2 class="font-light m-b-0">{{$fileCount}} | {{$target->targetFile }}</h2>
                            <span class="text-muted">Current Month</span>
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
            <div class="svn-col">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title"><a href="{{route('closeLead')}}">Closed Leads</a></h4>
                        <div class="text-right">
                            <h2 class="font-light m-b-0">{{$closelead}} | {{$target->closelead }}</h2>
                            <span class="text-muted">Current Month</span>
                        </div>

                        @if($target->closelead>0)
                            <span class="text-purple">{{round($targetCloselead)}}%</span>
                        @endif
                        <div class="progress">
                            @if($target->closelead>0)
                                <div class="progress-bar bg-purple" role="progressbar" style="width:{{$targetCloselead}}%; height: 6px;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <div class="svn-col">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title"><a href="{{route('followup')}}">Follow up</a></h4>
                        <div class="text-right">
                            <h2 class="font-light m-b-0">{{$followup}} | {{$target->followup }}</h2>
                            <span class="text-muted">Current Month</span>
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
            {{--@if($newCallTargetAchievedLastDay <=80)--}}
                {{--$('#myModal').modal();--}}

            {{--@endif--}}


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
                                @if(Auth::user()->typeId==5)
                                    { y: {{ $lastContactPercent}},  label: "Conversation (25%)",indexLabel: "{{$lastContactPercent}}%" },
                                @endif
                                    { y: {{ $calledThisWeek}},  label: "Total Call (5%)",indexLabel: "{{$calledThisWeek}}%" },
                                    { y: {{ $targetNewFile}},  label: "Followup (5%)",indexLabel: "{{$targetNewFile}}%" },
                                    { y: {{ $testLead}},  label: "Tests (45%)",indexLabel: "{{$testLead}}%" },
                                    { y: {{ $targetCloselead}},  label: "Clients (15%)",indexLabel: "{{$targetCloselead}}%" },
                        {{--    @if(Auth::user()->typeId==4)--}}
                                    { y: {{ $leadMinedThisWeek}},  label: "Lead Mined (5%)",indexLabel: "{{$leadMinedThisWeek}}%" },
                        {{--    @endif --}}

                            @if($userType=="RA")
                                { y: {{(($highPosibilitiesThisWeek*50/100)+($leadMinedThisWeek*50/100))}},  label: "Total Progress",indexLabel: "{{round(($highPosibilitiesThisWeek*50/100)+($leadMinedThisWeek*50/100))}}%" },
                            @elseif($userType=="USER")
                                
                                { y:{{(($lastContactPercent*25/100)+($calledThisWeek*5/100)+($targetNewFile*5/100)+($testLead*45/100)+($targetCloselead*15/100)+($leadMinedThisWeek*5/100))}},label: "Total",indexLabel: "{{round(($lastContactPercent*25/100)+($calledThisWeek*5/100)+($targetNewFile*5/100)+($testLead*45/100)+($targetCloselead*15/100)+($leadMinedThisWeek*5/100))}}%" },

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
