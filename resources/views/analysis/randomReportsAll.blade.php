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



        <div class="col-md-8">
            <div class="card">
                <div class="card-header" style="background-color: #6F8FAF;">
                    <h5 class="font-weight-bold text-white">Sales Pipeline Report Table</h5>
                </div>
                <div class="card-body">
                    <p class="card-text">
                        <div class="table-responsive">
                            <table id="pipelineTable" class="table table-bordered table-striped table-middle-aligned">
                                <thead>
                                    <tr>
                                        <th>Marketer</th>
                                        <th>Contact</th>
                                        <th>Conversation</th>
                                        <th>Test Possibility</th>
                                        <th>Test Received</th>
                                        <th>Closed</th>
                                        <th>Lost Deal</th>
                                        <th>Total</th> <!-- New column for the total -->
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- Data will be populated here using JavaScript -->
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>Total</th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th> <!-- New column for the total -->
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </p>
                </div>
            </div>
        </div>


            
        </div>




        <div class="row">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header" style="background-color: #6F8FAF;">
                        <h5 class="font-weight-bold text-white">Marketers Are Chasing:</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped table-middle-aligned">
                                <tbody>
                                    <tr>
                                        <td>Agencies</td>
                                        <td>{{ $showCategories['Agency'] }}</td>
                                    </tr>
                                    <tr>
                                        <td>Online Stores</td>
                                        <td>{{ $showCategories['Online Store'] }}</td>
                                    </tr>
                                    <tr>
                                        <td>Brands</td>
                                        <td>{{ $showCategories['Brand'] }}</td>
                                    </tr>
                                    <tr>
                                        <td>Boutiques</td>
                                        <td>{{ $showCategories['Boutique'] }}</td>
                                    </tr>
                                    <tr>
                                        <td>Furniture</td>
                                        <td>{{ $showCategories['Furniture'] }}</td>
                                    </tr>
                                    <tr>
                                        <td>Jewelry</td>
                                        <td>{{ $showCategories['Jewelry'] }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>



            <div class="col-md-4">
                <div class="card">
                    <div class="card-header" style="background-color: #6F8FAF;">
                        <h5 class="font-weight-bold text-white">Current Year Total</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped table-middle-aligned">
                                <thead>
                                    <tr>
                                        <th>Statistic</th>
                                        <th>Count</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Total Yearly Calls</td>
                                        <td>{{ $showYearlyStat['totalYearlyCall'] }}</td>
                                    </tr>
                                    <tr>
                                        <td>Total Yearly Contacts</td>
                                        <td>{{ $showYearlyStat['totalYearlyContact'] }}</td>
                                    </tr>
                                    <tr>
                                        <td>Total Yearly Conversations</td>
                                        <td>{{ $showYearlyStat['totalYearlyConvo'] }}</td>
                                    </tr>
                                    <tr>
                                        <td>Total Yearly Tests</td>
                                        <td>{{ $showYearlyStat['totalYearlyTest'] }}</td>
                                    </tr>
                                    <tr>
                                        <td>Total Yearly Closings</td>
                                        <td>{{ $showYearlyStat['totalYearlyClosing'] }}</td>
                                    </tr>
                                    <tr>
                                        <td>Total Yearly Lead Mining</td>
                                        <td>{{ $showYearlyStat['totalYearlyLeadMining'] }}</td>
                                    </tr>
                                </tbody>
                            </table>
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
 
        $(document).ready(function() {
            $('#myTable').DataTable({
                "processing": true,
                stateSave: true,
                "paging": false,
            });

        });





    $(document).ready(function() {
        $.ajax({
            url: "{{ route('pipelineReport') }}",
            method: "GET",
            success: function(data) {
                populateTable(data);

                // Initialize DataTables after populating the table
                $('#pipelineTable').DataTable({
                    "processing": true,
                    "paging": false,
                    "ordering": false, // Disable column ordering if needed
                    "info": false, // Disable information display at the bottom
                });
            },
            error: function(error) {
                console.error("Error fetching pipeline report:", error);
            }
        });
    });

    function populateTable(data) {
        var tableBody = $("#pipelineTable tbody");
        var tableFooter = $("#pipelineTable tfoot");

        // Create an object to store stage totals
        var stageTotals = {
            contact_count: 0,
            conversation_count: 0,
            possibility_count: 0,
            test_count: 0,
            closed_count: 0,
            lost_count: 0
        };

        // Iterate through the data and populate the table rows
        data.forEach(function(row) {
            var rowHtml = '<tr>';
            var total = 0;

            // Populate the row with user ID and stage counts
            rowHtml += '<td>' + row.userId + '</td>';
            rowHtml += '<td>' + row.contact_count + '</td>';
            rowHtml += '<td>' + row.conversation_count + '</td>';
            rowHtml += '<td>' + row.possibility_count + '</td>';
            rowHtml += '<td>' + row.test_count + '</td>';
            rowHtml += '<td>' + row.closed_count + '</td>';
            rowHtml += '<td>' + row.lost_count + '</td>';

            // Calculate and populate the total count for the user
            total = parseInt(row.contact_count) + parseInt(row.conversation_count) + parseInt(row.possibility_count) +
                    parseInt(row.test_count) + parseInt(row.closed_count) + parseInt(row.lost_count);
            rowHtml += '<td>' + total + '</td>';

            rowHtml += '</tr>';
            tableBody.append(rowHtml);

            // Update the stage totals
            stageTotals.contact_count += parseInt(row.contact_count);
            stageTotals.conversation_count += parseInt(row.conversation_count);
            stageTotals.possibility_count += parseInt(row.possibility_count);
            stageTotals.test_count += parseInt(row.test_count);
            stageTotals.closed_count += parseInt(row.closed_count);
            stageTotals.lost_count += parseInt(row.lost_count);
        });

        // Calculate and append stage totals to table footer
        var stageTotalHtml = '<tr><th>Stage Total</th>';
        var grandTotal = 0;

        // Populate stage totals in the footer
        stageTotalHtml += '<td>' + stageTotals.contact_count + '</td>';
        stageTotalHtml += '<td>' + stageTotals.conversation_count + '</td>';
        stageTotalHtml += '<td>' + stageTotals.possibility_count + '</td>';
        stageTotalHtml += '<td>' + stageTotals.test_count + '</td>';
        stageTotalHtml += '<td>' + stageTotals.closed_count + '</td>';
        stageTotalHtml += '<td>' + stageTotals.lost_count + '</td>';

        // Calculate grand total
        data.forEach(function(row) {
            grandTotal += parseInt(row.contact_count) + parseInt(row.conversation_count) + parseInt(row.possibility_count) +
                            parseInt(row.test_count) + parseInt(row.closed_count) + parseInt(row.lost_count);
        });

        stageTotalHtml += '<td>' + grandTotal + '</td></tr>';
        tableFooter.html(stageTotalHtml);
    }





    


</script>


@endsection
