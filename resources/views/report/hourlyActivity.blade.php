@extends('main')



@section('content')


<div class="container">
        <h1>Hourly Activity</h1>
        
        <form action="{{ route('hourlyActivity') }}" method="GET">
            <div class="form-group">
                <label for="user">Select User:</label>
                <select name="user" id="user" class="form-control">
                    <!-- Loop through the users and populate the dropdown options -->
                    @foreach($users as $user)
                        <option value="{{ $user->userID }}">{{ $user->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="datetime">Select Date and Time:</label>
                <input type="text" name="datetime" id="datetime" class="form-control datetimepicker" required>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>

        <hr>

        <h2>Hourly Activities:</h2>
        @if(count($hourlyActivities) > 0)
            @php
                $previousHour = null;
            @endphp
            <table class="table">
                <thead>
                    <tr>
                        <th>Hour</th>
                        <th>Activity</th>
                        <th>Created At</th>
                        <th>Comments</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($hourlyActivities as $activity)
                        @php
                            $hour = \Carbon\Carbon::parse($activity->created_at)->format('H');
                        @endphp
                        @if($previousHour !== $hour)
                            <tr class="hourly-divider">
                                <td colspan="4">
                                    Hour: {{ $hour }}
                                </td>
                            </tr>
                        @endif
                        <tr>
                            <td></td>
                            <td>{{ $activity->activity }}</td>
                            <td>{{ $activity->created_at }}</td>
                            <td>{{ $activity->comments }}</td>
                        </tr>
                        @php
                            $previousHour = $hour;
                        @endphp
                    @endforeach
                </tbody>
            </table>
        @else
            <p>Sorry, nothing found for the selected date and time.</p>
        @endif
    </div>

@endsection

@section('foot-js')

<script>
        // Initialize the datetimepicker
        $(document).ready(function() {
            $('.datetimepicker').datetimepicker({
                format: 'YYYY-MM-DD HH:mm:ss', // Customize the format as per your requirement
                // Add any additional configuration options for the datetimepicker
                // For example, you can specify the minDate and maxDate options to restrict the date range.
            });
        });
    </script>

@endsection