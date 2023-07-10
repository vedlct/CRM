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
    <h1 class="text-center mb-4" style="padding: 30px 0;">Random Reports </h1>
    
    <div class="row">

      <div class="col-md-2">
        <div class="card">
          <div class="card-body">
            <h4 class="card-title">My Calls</h4>
            <p class="card-text">
              Total Calls: @if ($totalOwnCall > 0) {{$totalOwnCall}} @endif
            </p>
          </div>
        </div>
      </div>

      <div class="col-md-2">
        <div class="card">
          <div class="card-body">
            <h4 class="card-title">My Contact</h4>
            <p class="card-text">
              Total Contact: @if ($totalOwnContact > 0) {{$totalOwnContact}} @endif<br>
              Ratio Vs Call:  {{ceil($callToContact)}}%
            </p>
          </div>
        </div>
      </div>

      <div class="col-md-2">
        <div class="card">
          <div class="card-body">
            <h4 class="card-title">MY Conversations</h4>
            <p class="card-text">
              Total Convo:   @if ($totalOwnConvo > 0) {{$totalOwnConvo}} @endif<br>
              Ratio Vs Convo:  {{ceil($callToConvo)}}%
            </p>
          </div>
        </div>
      </div>

      <div class="col-md-3">
        <div class="card">
          <div class="card-body">
            <h4 class="card-title">My Tests</h4>
            <p class="card-text">
              Total Test:   @if ($totalOwnTest > 0) {{$totalOwnTest}} @endif<br>
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
              Max Calls: @if ($maxTotalCall > 0) {{$maxTotalCall}} @endif<br>
              Max Contact: @if ($maxTotalContact > 0) {{$maxTotalContact}} @endif<br>
              Max Convo: @if ($maxTotalConvo > 0) {{$maxTotalConvo}} @endif<br>
              Max Test:  @if ($maxTotalTest > 0) {{$maxTotalTest}} @endif<br>
            </p>
          </div>
        </div>
      </div>

    </div>



    </div>
      </div>
    </div>










@endsection

@section('foot-js')

<script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.11.3/js/dataTables.bootstrap4.min.js"></script>


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
