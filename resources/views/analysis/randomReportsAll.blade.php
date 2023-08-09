@extends('main')

<style>
    /* Additional CSS styles for middle alignment */
    .table-middle-aligned td {
        vertical-align: middle;
    }
</style>

@section('content')


    <div class="card" style="padding:10px;">
        <div class="card-body">
            <h2  align="center"><b>Random Report Table</b></h2>
            <h5 class="card-subtitle" align="center">Comparison Table: how many calls lead to Test or how many conversations lead to teast and so on</h5> 

                <div class="table-responsive m-t-40">

                    <table id="myTable" class="table table-bordered table-striped table-middle-aligned">
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
                                <td class="text-center">{{ $user->totalOwnCall }}</td>
                                <td class="text-center">{{ $user->totalOwnContact }}</td>
                                <td class="text-center">{{ number_format($user->callToContact, 1) }}%</td>
                                <td class="text-center">{{ $user->totalOwnConvo }}</td>
                                <td class="text-center">{{ number_format($user->callToConvo, 1) }}%</td>
                                <td class="text-center">{{ $user->totalOwnTest }}</td>
                                <td class="text-center">{{ number_format($user->callToTest, 1) }}%</td>
                                <td class="text-center">{{ number_format($user->contactToTest, 1) }}%</td>
                                <td class="text-center">{{ number_format($user->convoToTest, 1) }}%</td>
                            </tr>
                            @endif
                            @endforeach
                            <tr>
                                <td><strong>.Totals</strong></td>
                                <td class="text-center"><strong>{{$users->where('totalOwnTest', '>', 1)->sum('totalOwnCall')}}</strong></td>
                                <td class="text-center"><strong>{{$users->where('totalOwnTest', '>', 1)->sum('totalOwnContact')}}</strong></td>
                                <td class="text-center"><strong>-</strong></td>
                                <td class="text-center"><strong>{{$users->where('totalOwnTest', '>', 1)->sum('totalOwnConvo')}}</strong></td>
                                <td class="text-center"><strong>-</strong></td>
                                <td class="text-center"><strong>{{$users->where('totalOwnTest', '>', 1)->sum('totalOwnTest')}}</strong></td>
                                <td class="text-center"><strong>-</strong></td>
                                <td class="text-center"><strong>-</strong></td>
                                <td class="text-center"><strong>-</strong></td>
                            </tr>
                            <tr>
                                <td><strong>.Averages</strong></td>
                                <td class="text-center"><strong>{{number_format($users->where('totalOwnTest', '>', 1)->avg('totalOwnCall'), 0)}}</strong></td>
                                <td class="text-center"><strong>{{number_format($users->where('totalOwnTest', '>', 1)->avg('totalOwnContact'), 0)}}</strong></td>
                                <td class="text-center"><strong>{{number_format($users->where('totalOwnTest', '>', 1)->avg('callToContact'), 1)}}%</strong></td>
                                <td class="text-center"><strong>{{number_format($users->where('totalOwnTest', '>', 1)->avg('totalOwnConvo'), 0)}}</strong></td>
                                <td class="text-center"><strong>{{number_format($users->where('totalOwnTest', '>', 1)->avg('callToConvo'), 1)}}%</strong></td>
                                <td class="text-center"><strong>{{number_format($users->where('totalOwnTest', '>', 1)->avg('totalOwnTest'), 0)}}</strong></td>
                                <td class="text-center"><strong>{{number_format($users->where('totalOwnTest', '>', 1)->avg('callToTest'), 1)}}%</strong></td>
                                <td class="text-center"><strong>{{number_format($users->where('totalOwnTest', '>', 1)->avg('contactToTest'), 1)}}%</strong></td>
                                <td class="text-center"><strong>{{number_format($users->where('totalOwnTest', '>', 1)->avg('convoToTest'), 1)}}%</strong></td>
                            </tr>
                        </tbody>
                    </table>
                  

                </div>
              </div>
            </div>


        <div class="row">

            <div class="col-md-4">
                <div class="card">
                <div class="card-header" style="background-color: #6F8FAF;">
                    <h5 class="font-weight-bold text-white">Closed Deals Analysis</h5>
                </div>
                    <div class="card-body">
                        <p class="card-text">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped table-middle-aligned">
                                    <thead>
                                        <tr>
                                            <th>Category</th>
                                            <th class="text-center">Clients</th>
                                            <th class="text-center">Percentage</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($clientCategoryCounts as $categoryCounts)
                                        <tr>
                                            <td>{{ ($categoryCounts->category->categoryName) }}</td>
                                            <td class="text-center">{{ $categoryCounts->count }}</td>
                                            <td class="text-center">{{ number_format(($categoryCounts->count / $totalClinetCounts) * 100, 0) }}%</td>
                                        </tr>
                                    @endforeach

                                        <tr>
                                            <td><strong>Total</strong></td>
                                            <td class="text-center"><strong>{{ $totalClinetCounts }}</strong></td>
                                            <td class="text-center"><strong>100%</strong></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </p>
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
 
  $(document).ready(function() {
            $('#myTable').DataTable({
                "processing": true,
                stateSave: true,
                "paging": false,
            });

        });

</script>


@endsection
