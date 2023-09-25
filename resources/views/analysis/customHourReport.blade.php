@extends('main')
<style>
.max-cell {
    background-color: #FFFF66; /* Yellow, adjust the color as desired */
    font-weight: bold;
}
</style>

@section('content')
    <div class="card" style="padding:10px;">
        <div class="card-body">
            <h2 align="center"><b>Hour Report for last 2 months</b></h2><br>
            <div class="row">
                <div class="table table-bordered table-responsive table-striped">
                    <table>
                        <thead>
                            <tr>
                                <th>User</th>
                                @for ($hour = 0; $hour < 24; $hour++)
                                    <th>{{ $hour }}:00</th>
                                @endfor
                            </tr>
                        </thead>
                        <tbody>
                        @foreach ($users as $user)
                        <tr>
                            <td>{{ $user->firstName }}</td>
                            @for ($hour = 0; $hour < 24; $hour++)
                                @php
                                    $activityCount = $hourlyActivityData[$hour][$user->id] ?? 0;
                                    $isMax = $activityCount === ($userMaxValues[$user->id] ?? 0);
                                @endphp
                                <td class="{{ $isMax ? 'max-cell' : '' }}">{{ $activityCount }}</td>
                            @endfor
                        </tr>
                    @endforeach
                        </tbody>
                    </table>
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
    <meta name="csrf-token" content="{{ csrf_token() }}"/>
@endsection
