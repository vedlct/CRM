@extends('main')


@section('content')
    
    <div class="content-page">
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="page-title-box">
                            <h4 class="page-title" align="center" style="font-weight: bold; padding:50px;">{{$profile->firstName}} {{$profile->lastName}}</h4>
                        </div>
                    </div>
                </div>

                <div class="row">
					<div class="col-sm-12 col-xl-4">
						<div class="card">
							<div class="card-body">
								<h4 class="card-title">Short Analysis</h4>
								<p>
									{{$profile->firstName}} has been with the company since {{$profile->created_at}}. His/her designation is @if (isset($profile->designation)){{$profile->designation->designationName}}@endif. S/he attended @if ($workingDays != 0) {{ $workingDays }} @endif days in current year and dialled <span style="font-weight:bold;">{{ $totalCallAchievedYear }}</span> during this time. On average s/he dialled 
                                    <span style="font-weight:bold;"> 
                                    @if ($avergareDailyCall != 0) {{ $avergareDailyCall }} </span> 
                                        which is 

										@if ($avergareDailyCall < 34)
											<span style="color:red; font-weight:bold;">Poor </span>
										@elseif ($avergareDailyCall < 44)
											<span style="color:orange; font-weight:bold;">Average </span>
										@elseif ($avergareDailyCall < 54)
											<span style="color:green; font-weight:bold;">Good </span>
										@else
											<span style="color:purple; font-weight:bold;">Extraordinary </span>
										@endif
									@else
										'N/A'
									@endif
                                </p>
								<p style="font-style: italic;">
                                    If anyone makes less than 35 calls per day, it's poor. If it's less than 45, we can call it average. If it's in between 45 to 55, it's a good number. More than 55 per day? It's extraordinary.
                                </p> 
								<p>
									{{$profile->firstName}} has achieved <span style="font-weight:bold;">USD {{$totalRevenueAchievedYear}}</span> in this year. As his/her target was <span style="font-weight:bold;">USD {{ $totalRevenueTargetYear }}</span>, his/her achievement is <span style="font-weight:bold;">
									@if ($totalRevenueAchievedYear != 0)
										{{ number_format(($totalRevenueAchievedYear  / $totalRevenueTargetYear) * 100, 0) }} %
									@else
										N/A
									@endif </span>
								</p>
                            </div>
                        </div> 
                    </div>

					<div class="col-sm-12 col-xl-8">
						<div class="row">
							<div class="col-sm-6 col-xl-3">
								<div class="card">
									<div class="card-body">
										<h4 class="card-title">Total Call in this year</h4>
										<p>Target:  {{ $totalCallTargetYear }}</p>
										<p>Achievement: {{ $totalCallAchievedYear }}</p>
										<p>Percentage: 
                                        @if ($totalCallTargetYear != 0)
                                            {{ number_format(($totalCallAchievedYear / $totalCallTargetYear) * 100, 2) }}%
                                        @else
                                            N/A
                                        @endif
                                        </p>
									</div>
								</div> 
							</div>
							<div class="col-sm-6 col-xl-3">
								<div class="card">
									<div class="card-body">
										<h4 class="card-title">Total Contact in this year</h4>
										<p>Target:  {{ $totalContactTargetYear }}</p>
										<p>Achievement: {{ $totalContactAchievedYear }}</p>
										<p>Percentage: 
                                        @if ($totalContactTargetYear != 0)
                                            {{ number_format(($totalContactAchievedYear / $totalContactTargetYear) * 100, 2) }}%
                                        @else
                                            N/A
                                        @endif
                                        </p>
									</div>
								</div> 
							</div>
							<div class="col-sm-6 col-xl-3">
								<div class="card">
									<div class="card-body">
										<h4 class="card-title">Total Conversation in this year</h4>
										<p>Target:  {{ $totalConvoTargetYear }}</p>
										<p>Achievement: {{ $totalConvoAchievedYear }}</p>
										<p>Percentage: 
                                        @if ($totalConvoTargetYear != 0)
                                            {{ number_format(($totalConvoAchievedYear / $totalConvoTargetYear) * 100, 2) }}%
                                        @else
                                            N/A
                                        @endif
                                        </p>
									</div>
								</div> 
							</div>
							<div class="col-sm-6 col-xl-3">
								<div class="card">
									<div class="card-body">
										<h4 class="card-title">Total Followup in this year</h4>
										<p>Target:  {{ $totalFollowupTargetYear }}</p>
										<p>Achievement: {{ $totalFollowupAchievedYear }}</p>
										<p>Percentage: 
                                        @if ($totalFollowupTargetYear != 0)
                                            {{ number_format(($totalFollowupAchievedYear / $totalFollowupTargetYear ) * 100, 2) }}%
                                        @else
                                            N/A
                                        @endif
                                        </p>
									</div>
								</div> 
							</div>
						</div>    
                    				
						<div class="row">
                        <div class="col-sm-6 col-xl-3">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title">Total Test in this year</h4>
                                    <p>Target:  {{ $totalTestTargetYear }}</p>
										<p>Achievement: {{ $totalTestAchievedYear }}</p>
										<p>Percentage: 
                                        @if ($totalTestTargetYear != 0)
                                            {{ number_format(($totalTestAchievedYear / $totalTestTargetYear) * 100, 2) }}%
                                        @else
                                            N/A
                                        @endif
                                    </p>
                                </div>
                            </div> 
                        </div>

                        <div class="col-sm-6 col-xl-3">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title">Total Closing in this year</h4>
                                    <p>Target:  {{ $totalClosingTargetYear }}</p>
										<p>Achievement: {{ $totalClosingAchievedYear }}</p>
										<p>Percentage: 
                                        @if ($totalClosingTargetYear != 0)
                                            {{ number_format(($totalClosingAchievedYear / $totalClosingTargetYear) * 100, 2) }}%
                                        @else
                                            N/A
                                        @endif
                                    </p>
                                </div>
                            </div> 
                        </div>

                        <div class="col-sm-6 col-xl-3">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title">Total Lead Mine in this year</h4>
                                    <p>Target:  {{ $totalLeadMineTargetYear }}</p>
										<p>Achievement: {{ $totalLeadMineAchievedYear }}</p>
										<p>Percentage: 
                                        @if ($totalLeadMineTargetYear != 0)
                                            {{ number_format(($totalLeadMineAchievedYear / $totalLeadMineTargetYear) * 100, 2) }}%
                                        @else
                                            N/A
                                        @endif
                                    </p>
                                </div>
                            </div> 
                        </div>

                        <?php
                            if ($totalCallTargetYear != 0) {
                                $callPercentage = ($totalCallAchievedYear / $totalCallTargetYear) * 100;
                            } else {
                                $callPercentage = 0;
                            }

                            if ($totalContactTargetYear != 0) {
                                $contactPercentage = ($totalContactAchievedYear / $totalContactTargetYear) * 100;
                            } else {
                                $contactPercentage = 0;
                            }

                            if ($totalConvoTargetYear != 0) {
                                $conversationPercentage = ($totalConvoAchievedYear / $totalConvoTargetYear) * 100;
                            } else {
                                $conversationPercentage = 0;
                            }

                            if ($totalFollowupTargetYear != 0) {
                                $followupPercentage = ($totalFollowupAchievedYear / $totalFollowupTargetYear) * 100;
                            } else {
                                $followupPercentage = 0;
                            }

                            if ($totalTestTargetYear != 0) {
                                $testPercentage = ($totalTestAchievedYear / $totalTestTargetYear) * 100;
                            } else {
                                $testPercentage = 0;
                            }

                            if ($totalClosingTargetYear != 0) {
                                $closingPercentage = ($totalClosingAchievedYear / $totalClosingTargetYear) * 100;
                            } else {
                                $closingPercentage = 0;
                            }

                            if ($totalLeadMineTargetYear != 0) {
                                $leadMinePercentage = ($totalLeadMineAchievedYear / $totalLeadMineTargetYear) * 100;
                            } else {
                                $leadMinePercentage = 0;
                            }
								

                            // Define the weights
                            $weights = [
                                'Call' => 5,
                                'Contact' => 5,
                                'Conversation' => 20,
                                'Followup' => 5,
                                'Test' => 40,
                                'Closing' => 20,
                                'LeadMine' => 5,
                            ];

                            // Calculate the weighted percentage
                            $weightedPercentage = (
                                min(100, $callPercentage) * $weights['Call'] +
                                min(100, $contactPercentage) * $weights['Contact'] +
                                min(100, $conversationPercentage) * $weights['Conversation'] +
                                min(100, $followupPercentage) * $weights['Followup'] +
                                min(100, $testPercentage) * $weights['Test'] +
                                min(100, $closingPercentage) * $weights['Closing'] +
                                min(100, $leadMinePercentage) * $weights['LeadMine']
                            ) / array_sum($weights); // Normalize to 100%

                        ?>

                        <div class="col-sm-6 col-xl-3">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title">Achievement in Percentage</h4>
                                    <h3> 
                                        @if ($weightedPercentage != 0)
                                            {{ number_format($weightedPercentage, 2) }}%
                                        @endif
                                    </h3>
                                    <p>This is based on marketer's target and achievement of current year.</p>
                                </div>
                            </div>
                        </div>
                    </div>

				</div>    
			</div>


            <div class="row">
			    <div class="col-sm-12 col-xl-12">
                    <div class="card">
                        <div class="card-body">
                            <h4>Quarterly Achievement</h4>

                            <div class="table-responsive">
                                @foreach ($quarterlyData as $quarterData)
                                    <table class="table table-bordered">
                                        <thead class="table-primary">
                                            
                                            <tr>
                                                <th style="background-color:#0000FF; color: white;">{{ $quarterData['quarterName'] }}</th>
                                                <th>Total Call (5%)</th>
                                                <th>Contact (5%)</th>
                                                <th>Conversation (20%)</th>
                                                <th>Followup (5%)</th>
                                                <th>Test (40%)</th>
                                                <th>Closing (20%)</th>
                                                <th>Lead Mine (5%)</th>
                                                <th>Total (100%)</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <th>Target</th>
                                                <td>{{ $quarterData['totalCallTarget'] }}</td>
                                                <td>{{ $quarterData['totalContactTarget'] }}</td>
                                                <td>{{ $quarterData['totalConvoTarget'] }}</td>
                                                <td>{{ $quarterData['totalFollowupTarget'] }}</td>
                                                <td>{{ $quarterData['totalTestTarget'] }}</td>
                                                <td>{{ $quarterData['totalClosingTarget'] }}</td>
                                                <td>{{ $quarterData['totalLeadMineTarget'] }}</td>
                                            </tr>
                                            <tr>
                                                <th>Achievement</th>
                                                <td>{{ $quarterData['totalCallAchieved'] ?? '' }}</td>
                                                <td>{{ $quarterData['totalContactAchieved'] ?? '' }}</td>
                                                <td>{{ $quarterData['totalConvoAchieved'] ?? '' }}</td>
                                                <td>{{ $quarterData['totalFollowupAchieved'] ?? '' }}</td>
                                                <td>{{ $quarterData['totalTestAchieved'] ?? '' }}</td>
                                                <td>{{ $quarterData['totalClosingAchieved'] ?? '' }}</td>
                                                <td>{{ $quarterData['totalLeadMineAchieved'] ?? '' }}</td>
                                            </tr>
                                            <tr>
                                                <th>%</th>
                                                <td class="percentage-cell">
                                                    @if ($quarterData['totalCallTarget'] != 0)
                                                        {{ number_format(($quarterData['totalCallAchieved'] / $quarterData['totalCallTarget']) * 100, 0) }}%
                                                    @else
                                                        0%
                                                    @endif
                                                </td>
                                                <td class="percentage-cell">
                                                    @if ($quarterData['totalContactTarget'] != 0)
                                                        {{ number_format(($quarterData['totalContactAchieved'] / $quarterData['totalContactTarget']) * 100, 0) }}%
                                                    @else
                                                        0%
                                                    @endif
                                                </td>
                                                <td class="percentage-cell">
                                                    @if ($quarterData['totalConvoTarget'] != 0)
                                                        {{ number_format(($quarterData['totalConvoAchieved'] / $quarterData['totalConvoTarget']) * 100, 0) }}%
                                                    @else
                                                        0%
                                                    @endif
                                                </td>
                                                <td class="percentage-cell">
                                                    @if ($quarterData['totalFollowupTarget'] != 0)
                                                        {{ number_format(($quarterData['totalFollowupAchieved'] / $quarterData['totalFollowupTarget']) * 100, 0) }}%
                                                    @else
                                                        0%
                                                    @endif
                                                </td>
                                                <td class="percentage-cell">
                                                    @if ($quarterData['totalTestTarget'] != 0)
                                                        {{ number_format(($quarterData['totalTestAchieved'] / $quarterData['totalTestTarget']) * 100, 0) }}%
                                                    @else
                                                        0%
                                                    @endif
                                                </td>
                                                <td class="percentage-cell">
                                                    @if ($quarterData['totalClosingTarget'] != 0)
                                                        {{ number_format(($quarterData['totalClosingAchieved'] / $quarterData['totalClosingTarget']) * 100, 0) }}%
                                                    @else
                                                        0%
                                                    @endif
                                                </td>
                                                <td class="percentage-cell">
                                                    @if ($quarterData['totalLeadMineTarget'] != 0)
                                                        {{ number_format(($quarterData['totalLeadMineAchieved'] / $quarterData['totalLeadMineTarget']) * 100, 0) }}%
                                                    @else
                                                        0%
                                                    @endif
                                                </td>
                                                
                                                <td class="percentage-cell" style="text-align: center; font-weight: 500;">
                                                    
                                                <?php
                                                    // Calculate the total percentage based on the given percentages in the table headers
                                                    $categories = [
                                                        'Call' => ['totalCallAchieved', 'totalCallTarget', 0.05],
                                                        'Contact' => ['totalContactAchieved', 'totalContactTarget', 0.05],
                                                        'Conversation' => ['totalConvoAchieved', 'totalConvoTarget', 0.20],
                                                        'Followup' => ['totalFollowupAchieved', 'totalFollowupTarget', 0.05],
                                                        'Test' => ['totalTestAchieved', 'totalTestTarget', 0.40],
                                                        'Closing' => ['totalClosingAchieved', 'totalClosingTarget', 0.20],
                                                        'LeadMine' => ['totalLeadMineAchieved', 'totalLeadMineTarget', 0.05],
                                                    ];
                                                    
                                                    $totalPercentage = 0;
                                                    
                                                    foreach ($categories as $category => $data) {
                                                        list($achieved, $target, $weight) = $data;
                                                        $percentage = ($quarterData[$target] != 0) ? ($quarterData[$achieved] / $quarterData[$target]) * 100 : 0;
                                                        $percentage = min($percentage, 100); // Cap the percentage at 100%
                                                        $totalPercentage += $percentage * $weight;
                                                    }
                                                    
                                                    echo number_format($totalPercentage, 0) . '%';
                                                    
                                                ?>
                                                    
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                @endforeach
                                </div>
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

        


  


	</script>


@endsection
