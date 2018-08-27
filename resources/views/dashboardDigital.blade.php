@extends('main')
@section('content')
    <br>

    <div class="row" >

        <?php $count=0; $total=0; $lastCallPercent=0; $lastLeadMinedPercent=0; ?>


        <div class="col-lg-3 col-md-6">
                <div class="card">
                <div class="card-body">
                    <h4 class="card-title"><a href="#">Meeting</a></h4>
                    <div class="text-right">
                        <h2 class="font-light m-b-0"> {{$meeting}} | 0</h2>
                        <span class="text-muted">This Month</span>
                    </div>

                        <span class="text-success">100%</span>

                    <div class="progress">
                        {{--@if($target->targetCall>0)--}}
                            <div class="progress-bar bg-success" role="progressbar" style="width: 90%; height: 6px;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
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
                            <h2 class="font-light m-b-0"> {{$followup}} | 0</h2>
                            <span class="text-muted">This Month</span>
                        </div>

                        <span class="text-success">100%</span>

                        <div class="progress">
                            {{--@if($target->targetCall>0)--}}
                            <div class="progress-bar bg-success" role="progressbar" style="width: 90%; height: 6px;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                            {{--@endif--}}
                        </div>
                    </div>
                </div>
            </div>









    </div>




@endsection