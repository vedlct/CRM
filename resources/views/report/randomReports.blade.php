@extends('main')

<style>
  .card {
    transition: transform 0.5s ease;
  }

  .card:hover {
    transform: scale(1.05);
  }

  .mainrow {
    padding: 0 60px;
  }


</style>

@section('content')



<div class="row mainrow">
  <div class="col-md-12">
    <h1 class="text-center mb-4" style="padding: 30px 0 0 0;">Random Reports </h1>
    <h4 class="text-center mb-4" style="padding: 0 0 30px 0;">Since January 1st, 2023 </h4>
    
    <div class="row">
    <div class="col-md-2">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">My Calls</h4>
                <p class="card-text">
                    Total Calls: {{$totalOwnCall}}
                </p>
            </div>
        </div>
    </div>

    <div class="col-md-2">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">My Contact</h4>
                <p class="card-text">
                    Total Contact: {{$totalOwnContact}}<br>
                    Ratio Vs Call: {{ceil($callToContact)}}%
                </p>
            </div>
        </div>
    </div>

    <div class="col-md-2">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">MY Conversations</h4>
                <p class="card-text">
                    Total Convo: {{$totalOwnConvo}}<br>
                    Ratio Vs Convo: {{ceil($callToConvo)}}%
                </p>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">My Tests</h4>
                <p class="card-text">
                    Total Test: {{$totalOwnTest}}<br>
                    Ratio Vs Call: {{ceil($callToTest)}}% <br>
                    Ratio vs Contact: {{ceil($contactToTest)}}%<br>
                    Ratio vs Convo: {{ceil($convoToTest)}}%
                </p>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Comparison</h4>
                <p class="card-subtitle">others at top</p>
                <p class="card-text">
                    Max Calls: {{$maxTotalCall}}<br>
                    Max Contact: {{$maxTotalContact}}<br>
                    Max Convo: {{$maxTotalConvo}}<br>
                    Max Test: {{$maxTotalTest}}<br>
                </p>
            </div>
        </div>
    </div>
</div>



    </div>
  </div>



@endsection

@section('foot-js')

<script src="{{url('assets/plugins/datatables/jquery.dataTables.min.js')}}"></script>

<script src="{{url('cdn.datatables.net/buttons/1.2.2/js/dataTables.buttons.min.js')}}"></script>
<script src="{{url('cdn.datatables.net/buttons/1.2.2/js/buttons.flash.min.js')}}"></script>


<script src="{{url('cdn.datatables.net/buttons/1.2.2/js/buttons.html5.min.js')}}"></script>
<meta name="csrf-token" content="{{ csrf_token() }}" />


<!-- Additional JavaScript code goes here -->
<script>
  const cards = document.querySelectorAll('.card');

  cards.forEach(card => {
    card.addEventListener('mouseover', () => {
      card.classList.add('hover');
    });

    card.addEventListener('mouseout', () => {
      card.classList.remove('hover');
    });
  });


  
</script>


@endsection
