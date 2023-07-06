@extends('main')

<style>
  .card {
  transition: transform 0.5s ease;
}

.card:hover {
  transform: scale(1.05);
}

    /* .card:hover {
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        transform: translateY(-2px);
        background-color: #e6e6fa;
        border: 2px solid #0018F9;
    } */
.mainrow {
  padding: 0 100px;
}
    
</style>

@section('content')



<!-- <div class="container"> -->
  <div class="row mainrow">
    <div class="col-md-12">
      <h1 class="text-center mb-4" style="padding: 30px 0;">Analysis Tools</h1>
      
      <div class="row">

      <div class="col-md-3">
          <div class="card">
            <div class="view overlay">
            <img class="card-img-top" src="{{ url('public/img/analysisHome/salesPipeline.jpg')}}" alt="Card image cap">
              <a href="#!">
                <div class="mask rgba-white-slight"></div>
              </a>
            </div>
            <div class="card-body">
              <h4 class="card-title">Sales Pipeline</h4>
              <p class="card-text">Where leads go on an adventure, battling objections, jumping through hoops, and finally emerging as victorious customers. Ready to conquer?</p>
              <p class="card-text"><small class="text-muted">Important: please check frequently</small></p>
              <a href="{{route('salesPipeline')}}" target="_blank" class="btn btn-primary">Visit Pipeline</a>
            </div>
            <div class="card-footer">
            <div class="d-flex justify-content-between align-items-center">
                <div class="text-muted">Available for: Only Users</div>
            </div>
            </div>
          </div>
          </div>


      <div class="col-md-3">
          <div class="card">
            <div class="view overlay">
              <img class="card-img-top" src="{{ url('public/img/analysisHome/testbutnotclosed.jpg')}}" alt="Card image cap">
              <a href="#!">
                <div class="mask rgba-white-slight"></div>
              </a>
            </div>
            <div class="card-body">
              <h4 class="card-title">Test But Not Closed</h4>
              <p class="card-text">Where do the other 80% of tests go? Join the search party as we unravel the mystery of the disappearing acts in the world of closures</p>
              <p class="card-text"><small class="text-muted">Caution: takes long time to load</small></p>
              <a href="{{route('getTestButNotClosedList')}}" target="_blank" class="btn btn-primary">See The List</a>
            </div>
            <div class="card-footer">
            <div class="d-flex justify-content-between align-items-center">
                <div class="text-muted">Available for: All Users</div>
            </div>
            </div>
          </div>
        </div>


        <div class="col-md-3">
          <div class="card">
            <div class="view overlay">
                <img class="card-img-top" src="{{ url('public/img/analysisHome/longtimenocall.jpg')}}" alt="Card image cap">
              <a href="#!">
                <div class="mask rgba-white-slight"></div>
              </a>
            </div>
            <div class="card-body">
              <h4 class="card-title">Long Time No Call</h4>
              <p class="card-text">Missed follow-ups and untouched leads? Don't worry, we've got your back. Get insights into the neglected opportunities and follow-up fails </p>
              <p class="card-text"><small class="text-muted">Caution: takes long time to load</small></p>
              <a href="{{route('getLongTimeNoCall')}}" target="_blank" class="btn btn-primary">Get Me There</a>
            </div>
            <div class="card-footer">
            <div class="d-flex justify-content-between align-items-center">
                <div class="text-muted">Available for: All Users</div>
            </div>
            </div>
          </div>
        </div>
                
        <div class="col-md-3">
          <div class="card">
            <div class="view overlay">
              <img class="card-img-top" src="{{ url('public/img/analysisHome/Analysiscomments.jpg')}}" alt="Card image cap">
              <a href="#!">
                <div class="mask rgba-white-slight"></div>
              </a>
            </div>
            <div class="card-body">
              <h4 class="card-title">Analysis Comments</h4>
              <p class="card-text">Unlock hidden conversations and lead details with ease. Find specific call reports and uncover interesting discussions, like those mentioning 'outsourcing'</p>
              <a href="{{route('analysisComments')}}" target="_blank" class="btn btn-primary">Let's Analyze</a>
            </div>
            <div class="card-footer">
            <div class="d-flex justify-content-between align-items-center">
                <div class="text-muted">Available for: Admin, Supervisor</div>               
            </div>
            </div>
          </div>
        </div>      

      </div>

      
      <div class="row">

        <div class="col-md-3">
          <div class="card">
            <div class="view overlay">
            <img class="card-img-top" src="{{ url('public/img/analysisHome/conversations.jpg')}}" alt="Card image cap">
              <a href="#!">
                <div class="mask rgba-white-slight"></div>
              </a>
            </div>
            <div class="card-body">
              <h4 class="card-title">All Conversations</h4>
              <p class="card-text">Curious about the successful long pitches? Feast your eyes on the list of companies we've impressed with our charm and marketing prowess.</p>
              <a href="{{route('getallConversations')}}" target="_blank" class="btn btn-primary">Find Conversations</a>
            </div>
            <div class="card-footer">
            <div class="d-flex justify-content-between align-items-center">
                <div class="text-muted">Available for: All Users</div>
            </div>
            </div>
          </div>
        </div>

        <div class="col-md-3">
          <div class="card">
            <div class="view overlay">
            <img class="card-img-top" src="{{ url('public/img/analysisHome/maxchasing.jpg')}}" alt="Card image cap">
              <a href="#!">
                <div class="mask rgba-white-slight"></div>
              </a>
            </div>
            <div class="card-body">
              <h4 class="card-title">Maximum Chasing</h4>
              <p class="card-text">How persistent are we in chasing our prospects? Discover the companies that have witnessed our unwavering pursuit, with at least 10 attempts or more</p>
              <a href="{{route('getAllChasingLeads')}}" target="_blank" class="btn btn-primary">Explore The List</a>
            </div>
            <div class="card-footer">
            <div class="d-flex justify-content-between align-items-center">
                <div class="text-muted">Available for: All Users</div>
            </div>
            </div>
          </div>
        </div>

        <div class="col-md-3">
          <div class="card">
            <div class="view overlay">
            <img class="card-img-top" src="{{ url('public/img/analysisHome/ipplist.jpg')}}" alt="Card image cap">
              <a href="#!">
                <div class="mask rgba-white-slight"></div>
              </a>
            </div>
            <div class="card-body">
              <h4 class="card-title">Ideal Prospect Profile</h4>
              <p class="card-text">Explore the Ideal Prospect Profile (IPP) list, revealing the companies our marketers consider perfect for pursuit based on their conversations with KDMs</p>
              <a href="{{route('ippList')}}" target="_blank" class="btn btn-primary">Get IPP List</a>
            </div>
            <div class="card-footer">
            <div class="d-flex justify-content-between align-items-center">
                <div class="text-muted">Available for: All Users</div>
            </div>
            </div>
          </div>
        </div>

        <div class="col-md-3">
          <div class="card">
            <div class="view overlay">
            <img class="card-img-top" src="{{ url('public/img/analysisHome/assignedbutnottaken.jpg')}}" alt="Card image cap">
              <a href="#!">
                <div class="mask rgba-white-slight"></div>
              </a>
            </div>
            <div class="card-body">
              <h4 class="card-title">Assigned But Not Taken</h4>
              <p class="card-text">Lost leads alert! We've spotted some unclaimed assignments. Help us reunite the assigned leads with their rightful marketers in the My Lead section</p>
              <a href="{{route('allAssignedButNotMyleads')}}" target="_blank" class="btn btn-primary">Browse The List</a>
            </div>
            <div class="card-footer">
            <div class="d-flex justify-content-between align-items-center">
                <div class="text-muted">Available for: Admin, Manager, Supervisor</div>
            </div>
            </div>
          </div>
        </div>

      </div>


      <div class="row">

        <div class="col-md-3">
          <div class="card">
            <div class="view overlay">
            <img class="card-img-top" src="{{ url('public/img/analysisHome/frequentlyfiltered.jpg')}}" alt="Card image cap">
              <a href="#!">
                <div class="mask rgba-white-slight"></div>
              </a>
            </div>
            <div class="card-body">
              <h4 class="card-title">Frequently Filtered</h4>
              <p class="card-text">Quick filters, quick decisions. Find out why some leads are swiftly filtered after mining. Unveil the reasons behind the rapid selection process</p>
              <a href="{{route('frequentlyFilteredLeads')}}" target="_blank" class="btn btn-primary">Analyze Recently Filtered</a>
            </div>
            <div class="card-footer">
            <div class="d-flex justify-content-between align-items-center">
                <div class="text-muted">Available for: Admin, Manager, Supervisor</div>
            </div>
            </div>
          </div>
        </div>

      <div class="col-md-3">
          <div class="card">
            <div class="view overlay">
            <img class="card-img-top" src="{{ url('public/img/analysisHome/duplicateleads.jpg')}}" alt="Card image cap">
              <a href="#!">
                <div class="mask rgba-white-slight"></div>
              </a>
            </div>
            <div class="card-body">
              <h4 class="card-title">Duplicacy or Conspiracy!</h4>
              <p class="card-text">Double trouble or mere coincidence? Dive into the intriguing world of duplicate leads marked by our marketers. Are they duplicates or part of a master plan?</p>
              <a href="{{route('getDuplicateLeads')}}" target="_blank" class="btn btn-primary">Duplicate Leads</a>
            </div>
            <div class="card-footer">
            <div class="d-flex justify-content-between align-items-center">
                <div class="text-muted">Available for: Admin, Manager, Supervisor</div>
            </div>
            </div>
          </div>
        </div>

 
        <div class="col-md-3">
          <div class="card">
            <div class="view overlay">
            <img class="card-img-top" src="{{ url('public/img/analysisHome/fredchasingleads.jpg')}}" alt="Card image cap">
              <a href="#!">
                <div class="mask rgba-white-slight"></div>
              </a>
            </div>
            <div class="card-body">
              <h4 class="card-title">Fred's Leads</h4>
              <p class="card-text">Fred chased these leads in his tenure with Tech Cloud. Now, some leads are already assigned to the marketers, some are not. </p>
              <a href="{{route('getFredChasingLeads')}}" target="_blank" class="btn btn-primary">Get Fred</a>
            </div>
            <div class="card-footer">
            <div class="d-flex justify-content-between align-items-center">
                <div class="text-muted">Available for: Supervisor</div>
            </div>
            </div>
          </div>
        </div>


        <div class="col-md-3">
          <div class="card">
            <div class="view overlay">
              <img class="card-img-top" src="{{ url('public/img/analysisHome/allActivities.jpg')}}" alt="Card image cap">
              <a href="#!">
                <div class="mask rgba-white-slight"></div>
              </a>
            </div>
            <div class="card-body">
              <h4 class="card-title">All Activities</h4>
              <p class="card-text">Step into the realm of marketers' daily CRM adventures. From mining to updating and everything in between, this is where their magic happens </p>
              <p class="card-text"><small class="text-muted">Caution: takes long time to load</small></p>
              <a href="{{route('reportAllActivties')}}" target="_blank" class="btn btn-primary">See Activities</a>
            </div>
            <div class="card-footer">
            <div class="d-flex justify-content-between align-items-center">
                <div class="text-muted">Available for: All Users</div>
            </div>
            </div>
          </div>
        </div>

      </div>

<!--Main Container-->	  
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
