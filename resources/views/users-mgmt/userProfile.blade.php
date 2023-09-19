@extends('main')


@section('content')
    <!-- ============================================================== -->
    <!-- Start Page Content here -->
    <!-- ============================================================== -->
    


    <div class="content-page">
        <div class="content">
            <!-- Start Content-->
            <div class="container-fluid">
                <!-- start page title -->
                <div class="row">
                    <div class="col-12">
                        <div class="page-title-box">
                            <h4 class="page-title" align="center" style="font-weight: bold; padding:50px;">{{$profile->firstName}} {{$profile->lastName}}</h4>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-6 col-xl-3">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Total Call in this year</h4>
                                <p>Target: {{$totalCallTargetYear}}</p>
                                <p>Achievement: {{$totalCallAchievedYear}}</p>
                                <p>Percentage: 
                                    @if ($totalCallTargetYear != 0)
                                        {{ number_format(($totalCallAchievedYear / $totalCallTargetYear) * 100, 2) }}%
                                    @else
                                        N/A
                                    @endif</p>
                            </div>
                        </div> 
                    </div>

                    <div class="col-sm-6 col-xl-3">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Total Contact in this year</h4>
                                <p>Target: {{$totalContactTargetYear}}</p>
                                <p>Achievement: {{$totalContactAchievedYear}}</p>
                                <p>Percentage: 
                                    @if ($totalContactTargetYear != 0)
                                        {{ number_format(($totalContactAchievedYear / $totalContactTargetYear) * 100, 2) }}%
                                    @else
                                        N/A
                                    @endif</p>
                            </div>
                        </div> 
                    </div>

                    <div class="col-sm-6 col-xl-3">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Total Conversation in this year</h4>
                                <p>Target: {{$totalConvoTargetYear}}</p>
                                <p>Achievement: {{$totalConvoAchievedYear}}</p>
                                <p>Percentage: 
                                    @if ($totalConvoTargetYear != 0)
                                        {{ number_format(($totalConvoAchievedYear / $totalConvoTargetYear) * 100, 2) }}%
                                    @else
                                        N/A
                                    @endif</p>
                            </div>
                        </div> 
                    </div>

                    <div class="col-sm-6 col-xl-3">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Total Followup in this year</h4>
                                <p>Target: {{$totalFollowupTargetYear}}</p>
                                <p>Achievement: {{$totalFollowupAchievedYear}}</p>
                                <p>Percentage: 
                                    @if ($totalFollowupTargetYear != 0)
                                        {{ number_format(($totalFollowupAchievedYear / $totalFollowupTargetYear) * 100, 2) }}%
                                    @else
                                        N/A
                                    @endif</p>
                            </div>
                        </div> 
                    </div>

                </div>

                <div class="row">
                    <div class="col-sm-6 col-xl-3">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Total Test in this year</h4>
                                <p>Target: {{$totalTestTargetYear}}</p>
                                <p>Achievement: {{$totalTestAchievedYear}}</p>
                                <p>Percentage: 
                                    @if ($totalTestTargetYear != 0)
                                        {{ number_format(($totalTestAchievedYear / $totalTestTargetYear) * 100, 2) }}%
                                    @else
                                        N/A
                                    @endif</p>
                            </div>
                        </div> 
                    </div>

                    <div class="col-sm-6 col-xl-3">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Total Closing in this year</h4>
                                <p>Target: {{$totalClosingTargetYear}}</p>
                                <p>Achievement: {{$totalClosingAchievedYear}}</p>
                                <p>Percentage: 
                                    @if ($totalClosingTargetYear != 0)
                                        {{ number_format(($totalClosingAchievedYear / $totalClosingTargetYear) * 100, 2) }}%
                                    @else
                                        N/A
                                    @endif</p>
                            </div>
                        </div> 
                    </div>


                    <div class="col-sm-6 col-xl-3">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Total Lead Mine in this year</h4>
                                <p>Target: {{$totalLeadMineTargetYear}}</p>
                                <p>Achievement: {{$totalLeadMineAchievedYear}}</p>
                                <p>Percentage: 
                                    @if ($totalLeadMineTargetYear != 0)
                                        {{ number_format(($totalLeadMineAchievedYear / $totalLeadMineTargetYear) * 100, 2) }}%
                                    @else
                                        N/A
                                    @endif</p>
                            </div>
                        </div> 
                    </div>



                    @php
                        // Calculate individual percentages
                        $callPercentage = ($totalCallAchievedYear / $totalCallTargetYear) * 100;
                        $contactPercentage = ($totalContactAchievedYear / $totalContactTargetYear) * 100;
                        $conversationPercentage = ($totalConvoAchievedYear / $totalConvoTargetYear) * 100;
                        $followupPercentage = ($totalFollowupAchievedYear / $totalFollowupTargetYear) * 100;
                        $testPercentage = ($totalTestAchievedYear / $totalTestTargetYear) * 100;
                        $closingPercentage = ($totalClosingAchievedYear / $totalClosingTargetYear) * 100;
                        $leadMiningPercentage = ($totalLeadMineAchievedYear / $totalLeadMineTargetYear) * 100;

                        // Define the weights
                        $weights = [
                            'Call' => 5,
                            'Contact' => 5,
                            'Conversation' => 20,
                            'Followup' => 5,
                            'Test' => 40,
                            'Closing' => 20,
                            'Lead Mining' => 5,
                        ];

                        // Calculate the weighted percentage
                        $weightedPercentage = (
                            min(100, $callPercentage) * $weights['Call'] +
                            min(100, $contactPercentage) * $weights['Contact'] +
                            min(100, $conversationPercentage) * $weights['Conversation'] +
                            min(100, $followupPercentage) * $weights['Followup'] +
                            min(100, $testPercentage) * $weights['Test'] +
                            min(100, $closingPercentage) * $weights['Closing'] +
                            min(100, $leadMiningPercentage) * $weights['Lead Mining']
                        ) / array_sum($weights); // Normalize to 100%

                    @endphp


                    <div class="col-sm-6 col-xl-3">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Total Achievement in Percentage</h4>
                                <h4> {{ number_format($weightedPercentage, 2) }}%</h4>
                            </div>
                        </div>
                    </div>



                </div>




                <div class="row">

                    <div class="col-sm-6 col-xl-3">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Total Revenue in this year</h4>
                                <p>Target: {{$totalRevenueTargetYear}}</p>
                                <p>Achievement: {{$totalRevenueAchievedYear}}</p>
                                <p>Percentage: 
                                    @if ($totalRevenueTargetYear != 0)
                                        {{ number_format(($totalRevenueAchievedYear / $totalRevenueTargetYear) * 100, 2) }}%
                                    @else
                                        N/A
                                    @endif</p>
                            </div>
                        </div> 
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

    <script>

        

        $(function() {
            $('#dob').datepicker({
                dateFormat: 'yy-mm-dd', // Format the date as 'yyyy-mm-dd'
                changeMonth: true,
                changeYear: true,
                yearRange: "-60:+0" 
            });
        });


  


</script>


@endsection
