@extends('main')
@section('content')
    <br>

    <div class="row" >

        <?php $count=0; $total=0; $lastCallPercent=0; $lastLeadMinedPercent=0; ?>


        <div class="col-lg-3 col-md-6">
                <div class="card">
                <div class="card-body">
                    <h4 class="card-title"><a href="#">Revenue</a></h4>
                    <div class="text-right">
                        <h2 class="font-light m-b-0"> {{$revenue}} | {{$target->earn}} </h2>
                        <span class="text-muted">This Month</span>
                    </div>

                        <span class="text-success">{{round($revenue*100/$target->earn)}}%</span>

                    <div class="progress">
                        {{--@if($target->targetCall>0)--}}
                            <div class="progress-bar bg-success" role="progressbar" style="width: {{round($revenue*100/$target->earn)}}%; height: 6px;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                        {{--@endif--}}
                    </div>
                </div>
            </div>
        </div>
            <div class="col-lg-3 col-md-6">
                <div class="card">
                <div class="card-body">
                    <h4 class="card-title"><a href="#">Meeting</a></h4>
                    <div class="text-right">
                        <h2 class="font-light m-b-0"> {{$meeting}} | {{$target->meeting}} </h2>
                        <span class="text-muted">This Month</span>
                    </div>

                        <span class="text-success">{{round($meeting*100/$target->meeting)}}%</span>

                    <div class="progress">
                        {{--@if($target->targetCall>0)--}}
                            <div class="progress-bar bg-success" role="progressbar" style="width: {{round($meeting*100/$target->meeting)}}%; height: 6px;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                        {{--@endif--}}
                    </div>
                </div>
            </div>
        </div>
            <div class="col-lg-3 col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title"><a href="#">Followup</a></h4>
                        <div class="text-right">
                            <h2 class="font-light m-b-0"> {{$followup}} | {{$target->followup}}</h2>
                            <span class="text-muted">This Month</span>
                        </div>

                        <span class="text-success">{{round($followup*100/$target->followup)}}%</span>

                        <div class="progress">
                            {{--@if($target->targetCall>0)--}}
                            <div class="progress-bar bg-success" role="progressbar" style="width: {{round($followup*100/$target->followup)}}%; height: 6px;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                            {{--@endif--}}
                        </div>
                    </div>
                </div>
            </div>









    </div>




@endsection