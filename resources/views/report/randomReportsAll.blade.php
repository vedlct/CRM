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
                                <th>Contact to Test</th>
                                <th>Convo to Test</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($users as $user)
                            @if($user->totalOwnTest > 1)
                            <tr>
                                <td>{{ $user->firstName}} {{$user->lastName}}</td>
                                <td>{{ $user->totalOwnCall }}</td>
                                <td>{{ $user->totalOwnContact }}</td>
                                <td>{{ number_format($user->callToContact, 1) }}%</td>
                                <td>{{ $user->totalOwnConvo }}</td>
                                <td>{{ number_format($user->callToConvo, 1) }}%</td>
                                <td>{{ $user->totalOwnTest }}</td>
                                <td>{{ number_format($user->callToTest, 1) }}%</td>
                                <td>{{ number_format($user->contactToTest, 1) }}%</td>
                                <td>{{ number_format($user->convoToTest, 1) }}%</td>
                            </tr>
                            @endif
                            @endforeach
                            <tr>
                                <td><strong>.Totals</strong></td>
                                <td><strong>{{$users->where('totalOwnTest', '>', 1)->sum('totalOwnCall')}}</strong></td>
                                <td><strong>{{$users->where('totalOwnTest', '>', 1)->sum('totalOwnContact')}}</strong></td>
                                <td><strong>-</strong></td>
                                <td><strong>{{$users->where('totalOwnTest', '>', 1)->sum('totalOwnConvo')}}</strong></td>
                                <td><strong>-</strong></td>
                                <td><strong>{{$users->where('totalOwnTest', '>', 1)->sum('totalOwnTest')}}</strong></td>
                                <td><strong>-</strong></td>
                                <td><strong>-</strong></td>
                                <td><strong>-</strong></td>
                            </tr>
                            <tr>
                                <td><strong>.Averages</strong></td>
                                <td><strong>{{number_format($users->where('totalOwnTest', '>', 1)->avg('totalOwnCall'), 0)}}</strong></td>
                                <td><strong>{{number_format($users->where('totalOwnTest', '>', 1)->avg('totalOwnContact'), 0)}}</strong></td>
                                <td><strong>{{number_format($users->where('totalOwnTest', '>', 1)->avg('callToContact'), 1)}}%</strong></td>
                                <td><strong>{{number_format($users->where('totalOwnTest', '>', 1)->avg('totalOwnConvo'), 0)}}</strong></td>
                                <td><strong>{{number_format($users->where('totalOwnTest', '>', 1)->avg('callToConvo'), 1)}}%</strong></td>
                                <td><strong>{{number_format($users->where('totalOwnTest', '>', 1)->avg('totalOwnTest'), 0)}}</strong></td>
                                <td><strong>{{number_format($users->where('totalOwnTest', '>', 1)->avg('callToTest'), 1)}}%</strong></td>
                                <td><strong>{{number_format($users->where('totalOwnTest', '>', 1)->avg('contactToTest'), 1)}}%</strong></td>
                                <td><strong>{{number_format($users->where('totalOwnTest', '>', 1)->avg('convoToTest'), 1)}}%</strong></td>
                            </tr>
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
