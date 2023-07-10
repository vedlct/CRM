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

  .faq-container {
    margin-top: 30px;
  }

  .accordion .card-header {
    background-color: #f7f7f7;
    border-bottom: 1px solid #ddd;
    padding: 10px;
  }

  .accordion .card-header button {
    color: #555;
    font-weight: bold;
    text-align: left;
    font-size: 18px !important;

  }

  .accordion .card-header button span.accordion-icon {
    display: inline-block;
    width: 20px;
    height: 20px;
    text-align: center;
    border-radius: 50%;
    background-color: #f7f7f7;
    color: #555;
    transition: all 0.3s ease;
  }

  .accordion .card-header button.collapsed span.accordion-icon {
    transform: rotate(45deg);
  }

  .accordion .card-body {
    padding: 10px;
    background-color: #fff;
    font-size: 17px !important;

  }

</style>

@section('content')


<div class="row mainrow">
  <div class="col-md-12">
    <h1 class="text-center mb-4" style="padding: 30px 0;">FAQ </h1>



    <div class="faq-container">
      <div class="accordion" id="faqAccordion">

        <div class="card">
          <div class="card-header" id="heading1">
            <h5 class="mb-0">
              <button class="btn btn-link question" type="button" data-toggle="collapse" data-target="#collapse1" aria-expanded="true" aria-controls="collapse1">
                <span class="accordion-icon">+</span> How long does a lead take time to close?
              </button>
            </h5>
          </div>
          <div id="collapse1" class="collapse show" aria-labelledby="heading1" data-parent="#faqAccordion">
            <div class="card-body">
              Ans: It usually takes 1 month to 6 months.
            </div>
          </div>
        </div>

        <div class="card">
          <div class="card-header" id="heading2">
            <h5 class="mb-0">
              <button class="btn btn-link question collapsed" type="button" data-toggle="collapse" data-target="#collapse2" aria-expanded="false" aria-controls="collapse2">
                <span class="accordion-icon">+</span> Duration from contact to test?
              </button>
            </h5>
          </div>
          <div id="collapse2" class="collapse" aria-labelledby="heading2" data-parent="#faqAccordion">
            <div class="card-body">
              Your answer for question 2 goes here.
            </div>
          </div>
        </div>

        <div class="card">
          <div class="card-header" id="heading3">
            <h5 class="mb-0">
              <button class="btn btn-link question collapsed" type="button" data-toggle="collapse" data-target="#collapse3" aria-expanded="false" aria-controls="collapse3">
                <span class="accordion-icon">+</span> how many total calls needed per day for each test - own and others - year wise
              </button>
            </h5>
          </div>
          <div id="collapse3" class="collapse" aria-labelledby="heading3" data-parent="#faqAccordion">
            <div class="card-body">
              Your answer for question 3 goes here.
            </div>
          </div>
        </div>

        <div class="card">
          <div class="card-header" id="heading4">
            <h5 class="mb-0">
              <button class="btn btn-link question collapsed" type="button" data-toggle="collapse" data-target="#collapse4" aria-expanded="false" aria-controls="collapse4">
                <span class="accordion-icon">+</span> case study of big closes
              </button>
            </h5>
          </div>
          <div id="collapse4" class="collapse" aria-labelledby="heading4" data-parent="#faqAccordion">
            <div class="card-body">
              Your answer for question 3 goes here.
            </div>
          </div>
        </div>

        <div class="card">
          <div class="card-header" id="heading5">
            <h5 class="mb-0">
              <button class="btn btn-link question collapsed" type="button" data-toggle="collapse" data-target="#collapse5" aria-expanded="false" aria-controls="collapse5">
                <span class="accordion-icon">+</span> lead source analysis. Calls to test of owned mined leads vs others leads
              </button>
            </h5>
          </div>
          <div id="collapse5" class="collapse" aria-labelledby="heading5" data-parent="#faqAccordion">
            <div class="card-body">
              Your answer for question 3 goes here.
            </div>
          </div>
        </div>

        <div class="card">
          <div class="card-header" id="heading6">
            <h5 class="mb-0">
              <button class="btn btn-link question collapsed" type="button" data-toggle="collapse" data-target="#collapse6" aria-expanded="false" aria-controls="collapse6">
                <span class="accordion-icon">+</span> Country wise deal closed,  category wise deal closed,  maximum deal closed
              </button>
            </h5>
          </div>
          <div id="collapse6" class="collapse" aria-labelledby="heading7" data-parent="#faqAccordion">
            <div class="card-body">
              Your answer for question 3 goes here.
            </div>
          </div>
        </div>

        <div class="card">
          <div class="card-header" id="heading7">
            <h5 class="mb-0">
              <button class="btn btn-link question collapsed" type="button" data-toggle="collapse" data-target="#collapse7" aria-expanded="false" aria-controls="collapse7">
                <span class="accordion-icon">+</span> Duration from contact to test
              </button>
            </h5>
          </div>
          <div id="collapse7" class="collapse" aria-labelledby="heading7" data-parent="#faqAccordion">
            <div class="card-body">
              Your answer for question 3 goes here.
            </div>
          </div>
        </div>


      </div>
    </div>
    </div>
    </div>    




@endsection

@section('foot-js')

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
