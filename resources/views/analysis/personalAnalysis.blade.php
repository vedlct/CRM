@extends('main')

<style>
.loading-indicator {
    display: none;
    align-items: center;
    justify-content: center;
    background-color: rgba(255, 255, 255, 0.7);
    position: absolute;
    top: 50%;
    left: 50%;
    width: 100%;
    height: 100%;
    z-index: 999;
}

.spinner {
    border: 4px solid rgba(255, 255, 255, 0.3);
    border-radius: 50%;
    border-top: 4px solid #007bff; /* You can change the color */
    width: 40px;
    height: 40px;
    animation: spin 2s linear infinite;
}

@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}

</style>
@section('content')

<div class="card">
    <h2 style="text-align: center; padding: 50px 50px 0 50px;">Personal Analysis</h2>
    <p style="text-align: center; padding: 0 0 50px 0;">Select user name and dates to get an user's analysis. What they did in a certain timeframe.</p>

    <form method="POST" id="dataForm" action="{{ route('analysis.getPersonalAnalysis') }}">
        {{ csrf_field() }}

        <div class="col-md-4" style="float:left;">
            <select class="form-control" name="marketer">
                <option value="">Select Marketer</option>
                @foreach($users as $user)
                <option value="{{$user->id}}">{{$user->firstName}} {{$user->lastName}}</option>
                @endforeach
            </select>
        </div>

        <div class="col-md-3" style="float: left;">
            <input type="date" class="form-control" name="fromDate" placeholder="From Date">
        </div>
        <div class="col-md-3" style="float: left;">
            <input type="date" class="form-control" name="toDate" placeholder="To Date">
        </div>
        <div class="col-md-2" style="float:right;">
            <div class="input-group-append">
                <button class="btn btn-primary" type="submit" style="float:right;">Submit</button>
            </div>
        </div>
    </form>

    <br>

    <div class="card">
    <div id="variables">
        <p id="fromDate">{{ $fromDate ?? '' }}</p>
        <p id="toDate">{{ $toDate ?? '' }}</p>
        <p id="totalCall">{{ $totalCall ?? '' }}</p>
        <p id="totalTest">{{ $totalTest ?? '' }}</p>


    </div>


    <div id="loadingIndicator" class="loading-indicator">
        <div class="spinner"></div>
        <p>Analysis Loading...</p>
    </div>


</div>

@endsection



@section('foot-js')
<meta name="csrf-token" content="{{ csrf_token() }}" />


<script>
       


</script>


@endsection
