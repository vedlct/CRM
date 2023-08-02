@extends('main')

<style>

    .bg-light-red {
            background-color: #fa9775; 
        }

    table {
    border-collapse: collapse; 
    }

    tr, td, th {
    text-align: center;
    vertical-align: middle;
    }

</style>

@section('content')

<h2 style="text-align: center; padding: 50px 50px 0 50px;">Target vs Achievement</h2>
<h5 style="text-align: center; padding: 0 0 50px 0;">Last 12 Month's Data</h5>

<div class="col-sm-8 col-xl-12" style="text-align: center; padding: 0 100px;">

    @foreach ($data as $row)
        <div class="card">
            <div class="card-body">
                <h4 class="header-title mb-3">{{ $row['month'] }}</h4>
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead class="table-primary">
                            <tr>
                                <th></th>
                                <th>Conversation</th>
                                <th>Total Call</th>
                                <th>Followup</th>
                                <th>Test</th>
                                <th>Closed Deal</th>
                                <th>Contact</th>
                                <th>Lead Mine</th>
                                <th>Revenue</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <th>Target</th>
                                <td>{{ $row['targetConversation'] }}</td>
                                <td>{{ $row['targetCall'] }}</td>
                                <td>{{ $row['targetFollowUp'] }}</td>
                                <td>{{ $row['targetTest'] }}</td>
                                <td>{{ $row['targetClosing'] }}</td>
                                <td>{{ $row['targetContact'] }}</td>
                                <td>{{ $row['targetLeadMine'] }}</td>
                                <td>{{ $row['targetRevenue'] }}</td>
                            </tr>
                            <tr>
                                <th>Achievement</th>
                                <td>{{ $row['achvConversation'] ?? '' }}</td>
                                <td>{{ $row['achvCall'] ?? '' }}</td>
                                <td>{{ $row['achvFollowup'] ?? '' }}</td>
                                <td>{{ $row['achvTest'] ?? '' }}</td>
                                <td>{{ $row['achvClosing'] ?? '' }}</td>
                                <td>{{ $row['achvContact'] ?? '' }}</td>
                                <td>{{ $row['achvLeadMine'] ?? '' }}</td>
                                <td>{{ $row['achvRevenue'] ?? '' }}</td>
                            </tr>
                            <tr>
                                <th>%</th>
                                <td class="percentage-cell">
                                    @if ($row['targetConversation'] != 0)
                                        {{ number_format(($row['achvConversation'] / $row['targetConversation']) * 100, 1) }}%
                                    @else
                                        0%
                                    @endif
                                </td>
                                <td class="percentage-cell">
                                    @if ($row['targetCall'] != 0)
                                        {{ number_format(($row['achvCall'] / $row['targetCall']) * 100, 1) }}%
                                    @else
                                        0%
                                    @endif
                                </td>
                                <td class="percentage-cell">
                                    @if ($row['targetFollowUp'] != 0)
                                        {{ number_format(($row['achvFollowup'] / $row['targetFollowUp']) * 100, 1) }}%
                                    @else
                                        0%
                                    @endif
                                </td>
                                <td class="percentage-cell">
                                    @if ($row['targetTest'] != 0)
                                        {{ number_format(($row['achvTest'] / $row['targetTest']) * 100, 1) }}%
                                    @else
                                        0%
                                    @endif
                                </td>
                                <td class="percentage-cell">
                                    @if ($row['targetClosing'] != 0)
                                        {{ number_format(($row['achvClosing'] / $row['targetClosing']) * 100, 1) }}%
                                    @else
                                        0%
                                    @endif
                                </td>
                                <td class="percentage-cell">
                                    @if ($row['targetContact'] != 0)
                                        {{ number_format(($row['achvContact'] / $row['targetContact']) * 100, 1) }}%
                                    @else
                                        0%
                                    @endif
                                </td>
                                <td class="percentage-cell">
                                    @if ($row['targetLeadMine'] != 0)
                                        {{ number_format(($row['achvLeadMine'] / $row['targetLeadMine']) * 100, 1) }}%
                                    @else
                                        0%
                                    @endif
                                </td>
                                <td class="percentage-cell">
                                    @if ($row['targetRevenue'] != 0)
                                        {{ number_format(($row['achvRevenue'] / $row['targetRevenue']) * 100, 1) }}%
                                    @else
                                        0%
                                    @endif
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @endforeach


    <div id="chartContainer" style="height: 370px; width: 100%;"></div>

</div> <br>





@endsection


@section('foot-js')
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script src="{{url('js/chart.js')}}"></script>
    <script src="{{url('js/googlechart.js')}}"></script>

    <script>

        document.addEventListener('DOMContentLoaded', function() {
            // Get all elements with the class "percentage-cell"
            const percentageCells = document.querySelectorAll('.percentage-cell');

            // Loop through each cell and apply background color based on condition
            percentageCells.forEach(cell => {
                const percentage = parseFloat(cell.innerText);
                if (percentage < 50) {
                    cell.classList.add('bg-light-red'); // Add the class for red background
                }
            });
        });
        


        $(function () {
            google.charts.load('current', { 'packages': ['corechart'] });
            google.charts.setOnLoadCallback(drawChart);

            function drawChart() {
                var data = @json($data);

                var dataTable = new google.visualization.DataTable();
                dataTable.addColumn('string', 'Month');
                dataTable.addColumn('number', 'Test Percentage');
                dataTable.addColumn('number', 'Conversation Percentage');
                dataTable.addColumn('number', 'Closing Percentage');

                // Select the last 6 elements from the 'data' array
                var lastSixMonthsData = data;

                // Add data points for the last 6 months to the DataTable
                for (var i = 0; i < lastSixMonthsData.length; i++) {
                    var month = lastSixMonthsData[i].month;
                    var achvTest = lastSixMonthsData[i].achvTest;
                    var targetTest = lastSixMonthsData[i].targetTest;
                    // var testPercentage = achvTest * 100 / Math.max(targetTest, 1);
                    // var testPercentage = achvTest * 100 / Math.max(targetTest, 1);
                    //     testPercentage = Math.min(testPercentage, 100);
                    var testPercentage = targetTest !== 0 ? achvTest * 100 / targetTest : 0;
                        testPercentage = Math.min(testPercentage, 100);

                    var achvConversation = lastSixMonthsData[i].achvConversation;
                    var targetConversation = lastSixMonthsData[i].targetConversation;
                    // var conversationPercentage = achvConversation * 100 / Math.max(targetConversation, 1);
                    // var conversationPercentage = achvConversation * 100 / Math.max(targetConversation, 1);
                        // conversationPercentage = Math.min(conversationPercentage, 100);
                    var conversationPercentage = targetConversation !== 0 ? achvConversation * 100 / targetConversation : 0;
                        conversationPercentage = Math.min(conversationPercentage, 100);

                    var achvClosing = lastSixMonthsData[i].achvClosing;
                    var targetClosing = lastSixMonthsData[i].targetClosing;
                    // var closingPercentage = achvClosing * 100 / Math.max(targetClosing, 1);
                    // var closingPercentage = achvClosing * 100 / Math.max(targetClosing, 1);
                    //     closingPercentage = Math.min(closingPercentage, 100);
                    var closingPercentage = targetClosing !== 0 ? achvClosing * 100 / targetClosing : 0;
                        closingPercentage = Math.min(closingPercentage, 100);

                    dataTable.addRow([month, testPercentage, conversationPercentage, closingPercentage]);
                }

                var options = {
                    title: 'Test, Conversation, and Closing Percentages Comparison',
                    titleTextStyle: {
                        textAlign: 'center'
                    },
                    hAxis: {
                        title: 'Month'
                    },
                    vAxis: {
                        title: 'Percentage',
                        minValue: 0,
                        maxValue: 100,
                        format: '#\'%\''
                    },
                    legend: { position: 'bottom' }
                };

                var chart = new google.visualization.ColumnChart(document.getElementById('chartContainer'));
                chart.draw(dataTable, options);
            }
        });


    </script>

@endsection










