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

</style>
@section('content')

<div class="card">
    <h2 style="text-align: center; padding: 50px 50px 0 50px;">Graphical Presentation</h2>
    <p style="text-align: center; padding: 0 0 50px 0;">Select user name, days, and parameter to get the graphical presentation of a user's particular period.</p>

    <form method="POST" id="dataForm" action="{{ route('analysis.getUserDataPeriod') }}" >
        {{ csrf_field() }}
        <div class="col-md-3" style="float:left;">
            <select class="form-control" name="marketer">
                <option value="">Select Marketer</option>
                @foreach($users as $user)
                <option value="{{$user->id}}">{{$user->firstName}} {{$user->lastName}}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-3" style="float:left;">
            <select class="form-control" name="progress">
                <option value="">Select Parameter</option>
                <option value="totalcall">Total Call</option>
                <option value="contact">Contact</option>
                <option value="conversation">Conversation</option>
                <option value="followup">Followup</option>
                <option value="test">Test</option>
                <option value="closing">Closing</option>
            </select>
        </div>

        <div class="col-md-2" style="float: left;">
            <input type="date" class="form-control" name="fromDate" placeholder="From Date">
        </div>
        <div class="col-md-2" style="float: left;">
            <input type="date" class="form-control" name="toDate" placeholder="To Date">
        </div>
        <div class="col-md-2" style="float:right;">
            <div class="input-group-append">
                <button class="btn btn-primary" type="submit" style="float:right;">Submit</button>
            </div>
        </div>
    </form>

    <br>

    <div id="chartContainer" style="height: 600px; width: 80%;">
    </div>


    <div id="loadingIndicator" class="loading-indicator">
        <div class="spinner"></div>
        <p>Loading...</p>
    </div>


</div>

@endsection



@section('foot-js')
<meta name="csrf-token" content="{{ csrf_token() }}" />
<script src="{{url('js/googlechart.js')}}"></script>


<script>
        document.addEventListener('DOMContentLoaded', function () {
            var form = document.getElementById('dataForm');
            var chartContainer = document.getElementById('chartContainer');
            var loadingIndicator = document.getElementById('loadingIndicator');

            google.charts.load('current', { 'packages': ['corechart'] });

            form.addEventListener('submit', function (e) {
                e.preventDefault(); // Prevent the form from submitting normally

                // Show loading indicator
                loadingIndicator.style.display = 'block';
                chartContainer.style.display = 'none';

                // Fetch data and pass it to the renderChart function
                fetch('{{ route('analysis.getUserDataPeriod') }}', {
                    method: 'POST',
                    body: new FormData(form),
                })
                .then(function (response) {
                    return response.json();
                })
                .then(function (data) {
                    // Hide loading indicator and show chart
                    loadingIndicator.style.display = 'none';
                    chartContainer.style.display = 'block';

                    renderChart(data); // Call the renderChart function with the fetched data
                })
                .catch(function (error) {
                    console.error('Error:', error);
                    // Hide loading indicator and show an error message if needed
                    loadingIndicator.style.display = 'none';
                });
            });

            function renderChart(progressData) {
                // Create a DataTable to hold the data
                var data = new google.visualization.DataTable();
                data.addColumn('string', 'Date');
                data.addColumn('number', 'Count');

                // Add data from progressData to the DataTable
                for (var i = 0; i < progressData.length; i++) {
                    data.addRow([progressData[i].date, progressData[i].count]);
                }

                // Define chart options
                var options = {
                    title: 'Progress Chart',
                    hAxis: { title: 'Date' },
                    vAxis: { title: 'Count' },
                    legend: { position: 'none' }
                };

                // Create a chart and place it in the 'chartContainer' element
                var chart = new google.visualization.ColumnChart(chartContainer);
                chart.draw(data, options);
            }
        });

</script>


@endsection
