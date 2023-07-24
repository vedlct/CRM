@extends('main')
@section('header')
<style>
    .canvasjs-chart-credit
    {
        display: none;
    }

    .card-header {
        background-color: #6D98A9  !important;
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
                            @$lastContactPercent= round(($conversation/$target->conversation)*100);
                            if(@$lastContactPercent > 100){
                                @$lastContactPercent=100;
                            }
                            $count++;
                            $total+=$conversation;
                            ?>

                            <span class="text-success">{{round(@$lastContactPercent)}}%</span>
                        @endif
                        <div class="progress">
                            @if($target->conversation>0)
                                <div class="progress-bar bg-success" role="progressbar" style="width: {{@$lastContactPercent}}%; height: 6px;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
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
                                <div class="progress-bar bg-purple" role="progressbar" style="width:{{$targetCloselead}}%; height: 6px;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">
                                </div>
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

                        @if($target->targetFollowup>0)
                            <span class="text-purple">{{round($targetFollowup)}}%</span>
                        @endif
                        <div class="progress">
                            @if($target->targetFollowup>0)
                                <div class="progress-bar bg-purple" role="progressbar" style="width:{{$targetFollowup}}%; height: 6px;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
    </div>


    <div class="row">

        <div class="col-md-8" style=" float: left;">
            <div class="card">
            <div class="card-header">
                    <h5 class="font-weight-bold text-white">Latest Communication</h5>
                    <div class="card-header-right">
                    </div>
                </div>
                <div class="card-body">
                    <h4 class="card-title" style="color: purple;">{{ $recentNotice->title }}</h4>
                    <div class="card-text">
                        <p>{!! nl2br(e($recentNotice->msg)) !!}</p>
                    </div>
                    <footer class="blockquote-footer">From {{ $recentNotice->user->firstName }} {{ $recentNotice->user->lastName }} at <cite>{{ Carbon\Carbon::parse($recentNotice->created_at)->format('d M Y') }}</cite></footer>
                </div>
                <a href="{{ route('notice.index') }}" class="btn btn-custom">All Communications</a>
            </div>
        </div>
        
        <div class="col-md-4" style="float: right;">
            <div class="card">
                <div class="card-header">
                    <h5 class="font-weight-bold text-white">Recent Top Activities</h5>
                    <div class="card-header-right">
                    </div>
                </div>
                <div class="card-body">
                @if ($topActivities->isEmpty())
                    <p>No Recent Activity</p>
                @else
                    <ul class="crm-activity">
                        @foreach ($topActivities as $activity)
                            <li class="media">
                                <span class="me-3 font-primary"><img src="{{ url('public/img/users/' . $activity->picture) }}" alt="Photo" style="max-height: 50px; border-radius: 50%; padding-right: 10px;"></span>
                                <div class="align-self-center media-body">
                                    <!-- <h6 class="mt-0">{{ $activity->userId }} just received a {{ $activity->progress }}</h6> -->
                                    @if (strpos($activity->progress, 'Test') !== false)
                                        <h6 class="mt-0">{{ $activity->userId }} has just received a Free Trial </h6>
                                    @elseif (strpos($activity->progress, 'Closing') !== false)
                                        <h6 class="mt-0">{{ $activity->userId }} has onboarded a <b>Client</b></h6>
                                    @elseif ($activity->callingReport = 11)
                                        <h6 class="mt-0">{{ $activity->userId }} had a Conversation</h6>
                                    @endif
                                    <ul class="dates">
                                        <li>{{ \Carbon\Carbon::parse($activity->created_at)->format('d F Y') }}</li>
                                    </ul>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                    @endif
                </div>
                </div>
            </div>
        </div>


    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <h3 class="card-title">Personal Monthly Graph</h3>
                    <div id="chartContainer" style="height: 400px; width: 100%;">
                    </div>
                </div>
            </div>
        </div>
    </div>



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
                                    { y: {{ @$lastContactPercent}},  label: "Conversation (25%)",indexLabel: "{{@$lastContactPercent}}%" },
                                    { y: {{ $calledThisWeek}},  label: "Total Call (5%)",indexLabel: "{{$calledThisWeek}}%" },
                                    { y: {{ $targetFollowup}},  label: "Followup (5%)",indexLabel: "{{$targetFollowup}}%" },
                                    { y: {{ $testLead}},  label: "Tests (45%)",indexLabel: "{{$testLead}}%" },
                                    { y: {{ $targetCloselead}},  label: "Clients (15%)",indexLabel: "{{$targetCloselead}}%" },
                                    { y: {{ $leadMinedThisWeek}},  label: "Lead Mined (5%)",indexLabel: "{{$leadMinedThisWeek}}%" },
 
                            @if($userType=="RA")
                                { y: {{(($highPosibilitiesThisWeek*50/100)+($leadMinedThisWeek*50/100))}},  label: "Total Progress",indexLabel: "{{round(($highPosibilitiesThisWeek*50/100)+($leadMinedThisWeek*50/100))}}%" },
                            @elseif($userType=="USER")
                                
                                { y:{{((@$lastContactPercent*25/100)+($calledThisWeek*5/100)+($targetFollowup*5/100)+($testLead*45/100)+($targetCloselead*15/100)+($leadMinedThisWeek*5/100))}},label: "Total",indexLabel: "{{round((@$lastContactPercent*25/100)+($calledThisWeek*5/100)+($targetFollowup*5/100)+($testLead*45/100)+($targetCloselead*15/100)+($leadMinedThisWeek*5/100))}}%" },

                            @elseif($userType=="MANAGER" ||$userType=="SUPERVISOR")
                                { y:{{((@$lastContactPercent*25/100)+($calledThisWeek*5/100)+($targetFollowup*5/100)+($testLead*45/100)+($targetCloselead*15/100)+($leadMinedThisWeek*5/100))}},label: "Total",indexLabel: "{{round((@$lastContactPercent*25/100)+($calledThisWeek*5/100)+($targetFollowup*5/100)+($testLead*45/100)+($targetCloselead*15/100)+($leadMinedThisWeek*5/100))}}%" },

                            @endif

                        ]
                    }]
                });
            chart.render();


        }



    </script>





    @endsection
