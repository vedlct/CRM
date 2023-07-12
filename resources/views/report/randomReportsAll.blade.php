@extends('main')


@section('content')


    <div class="card" style="padding:10px;">
        <div class="card-body">
            <h2 class="card-title" align="center"><b>Random Report Table</b></h2>
            <h4 class="card-subtitle" align="center">Comparison Table: how many calls lead to Test or how many conversations lead to teast and so on</h4> 

                <div class="table-responsive m-t-40">
                    <table id="myTable" class="table table-bordered table-striped">
                    <thead>
                          <tr>
                              <th>Name</th>
                              <th>Calls</th>
                              <th>Contact</th>
                              <th>Call to Contact</th>
                              <th>Conversation</th>
                              <th>Call to Convo</th>
                              <th>Tests</th>
                              <th>Call to Test</th>
                              <th >Contact to Test</th>
                              <th>Convo to Test</th>
                          </tr>
                      </thead>
                      <tbody>
                          @foreach($users as $user)
                              <tr>
                                  <td>{{$user->firstName}} {{$user->lastName}}</td>
                                  <td>{{$user->totalOwnCall}}</td>
                                  <td>{{$user->totalOwnContact}}</td>
                                  <td>{{ceil($user->callToContact)}}%</td>
                                  <td>{{$user->totalOwnConvo}}</td>
                                  <td>{{ceil($user->callToConvo)}}%</td>
                                  <td>{{$user->totalOwnTest}}</td>
                                  <td>{{ceil($user->callToTest)}}%</td>
                                  <td>{{ceil($user->contactToTest)}}%</td>
                                  <td>{{ceil($user->convoToTest)}}%</td>
                              </tr>
                          @endforeach
                      </tbody>

                    </table>
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
 
  $(document).ready(function() {
            $('#myTable').DataTable({
                "processing": true,
                stateSave: true,
            });

        });

</script>


@endsection
