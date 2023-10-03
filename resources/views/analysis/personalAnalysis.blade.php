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


.lds-dual-ring.hidden {
    display: none;
}
.lds-dual-ring {
    display: inline-block;
    width: 80px;
    height: 80px;
}
.lds-dual-ring:after {
    content: " ";
    display: block;
    width: 64px;
    height: 64px;
    margin: 5% auto;
    border-radius: 50%;
    border: 6px solid #fff;
    border-color: #fff transparent #fff transparent;
    animation: lds-dual-ring 1.2s linear infinite;
}
@keyframes lds-dual-ring {
    0% {
        transform: rotate(0deg);
    }
    100% {
        transform: rotate(360deg);
    }
}


.overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100vh;
    background: rgba(0,0,0,.8);
    z-index: 999;
    opacity: 1;
    transition: all 0.5s;
}

</style>
@section('content')

<div class="card">
    <h2 style="text-align: center; padding: 50px 50px 0 50px;">Personal Analysis</h2>
    <p style="text-align: center; padding: 0 0 50px 0;">Select user name and dates to get an user's analysis. What they did in a certain timeframe.</p>

    <div id="richList"></div>

    <div id="loader" class="lds-dual-ring hidden overlay"></div>
    <form  id="dataForm" >
        {{ csrf_field() }}

        <div class="col-md-4" style="float:left;">
            <select class="form-control" id="marketer" name="marketer">
                <option value="">Select Marketer</option>
                @foreach($users as $user)
                <option value="{{$user->id}}">{{$user->firstName}} {{$user->lastName}}</option>
                @endforeach
            </select>
        </div>

        <div class="col-md-3" style="float: left;">
            <input type="date" class="form-control" id="fromDate" name="fromDate" placeholder="From Date">
        </div>
        <div class="col-md-3" style="float: left;">
            <input type="date" class="form-control" id="toDate" name="toDate" placeholder="To Date">
        </div>
        <div class="col-md-2" style="float:right;">
            <div class="input-group-append">
                <button class="btn btn-primary" type="submit" style="float:right;">Submit</button>
            </div>
        </div>
    </form>

    <br>

    


    <div id="loadingIndicator" class="loading-indicator">
        <div class="spinner"></div>
        <p>Analysis Loading...</p>
    </div>

    
    <div class="row" style="font-size: 24px;">
        <div class="col-sm-12 col-xl-2">

        </div>

        <div class="col-sm-12 col-xl-8">
            <div id="showdataDiv">
            </div>
        </div>

        <div class="col-sm-12 col-xl-2">

        </div>
    </div>

    

</div>

@endsection



@section('foot-js')
<meta name="csrf-token" content="{{ csrf_token() }}" />
<script type="text/javascript">

    $('#dataForm').on('submit',function(e){
        e.preventDefault();

        let marketer = $('#marketer').val();
        let fromDate = $('#fromDate').val();
        let toDate = $('#toDate').val();
        //let message = $('#InputMessage').val();

        $.ajax({
            url: "{{ route('analysis.getPersonalAnalysis') }}",
            type:"POST",
            data:{
                "_token": "{{ csrf_token() }}",
                marketer:marketer,
                fromDate:fromDate,
                toDate:toDate,

            },
            beforeSend: function() {
                $('#loader').removeClass('hidden')
            },
            success:function(response){
                $('#showdataDiv').html(response);

              //  console.log(response);
            },
            error: function(response) {
                // $('#nameErrorMsg').text(response.responseJSON.errors.name);
                // $('#emailErrorMsg').text(response.responseJSON.errors.email);
                // $('#mobileErrorMsg').text(response.responseJSON.errors.mobile);
                // $('#messageErrorMsg').text(response.responseJSON.errors.message);
            },
            complete: function(){
                $('#loader').addClass('hidden')
            },
        });
    });
</script>


@endsection