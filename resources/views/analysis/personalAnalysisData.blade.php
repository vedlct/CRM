<?php
$lowLeadPercentage = ($data['totalCall'] > 0) ? round(($data['lowLeadTotalCall'] / $data['totalCall']) * 100, 2) : 0;
$mediumLeadPercentage = ($data['totalCall'] > 0) ? round(($data['mediumLeadTotalcall'] / $data['totalCall']) * 100, 2) : 0;
$highLeadPercentage = ($data['totalCall'] > 0) ? round(($data['highLeadTotalCall'] / $data['totalCall']) * 100, 2) : 0;

$contactPercentage = ($data['totalCall'] > 0) ? round(($data['totalContact'] / $data['totalCall']) * 100, 2) : 0;

$conversationHighLeadPercentage = ($data['totalConversation'] > 0) ? round(($data['conversationHighLead'] / $data['totalConversation']) * 100, 2) : 0;
$conversationMediumLeadPercentage = ($data['totalConversation'] > 0) ? round(($data['conversationMedumLead'] / $data['totalConversation']) * 100, 2) : 0;
$conversationLowLeadPercentage = ($data['totalConversation'] > 0) ? round(($data['conversationLowLead'] / $data['totalConversation']) * 100, 2) : 0;

$highLeadsFollowupPercentage = ($data['totalFollowup'] > 0) ? round(($data['highLeadsFollowup'] / $data['totalFollowup']) * 100, 2) : 0;
$mediumLeadsFollowupPercentage = ($data['totalFollowup'] > 0) ? round(($data['mediumLeadsFollowup'] / $data['totalFollowup']) * 100, 2) : 0;
$lowLeadsFollowupPercentage = ($data['totalFollowup'] > 0) ? round(($data['lowLeadsFollowup'] / $data['totalFollowup']) * 100, 2) : 0;

$highLeadMissedFollowupPercentage = ($data['missedFollowup'] > 0) ? round(($data['highLeadMissedFollowup'] / $data['missedFollowup']) * 100, 2) : 0;
$mediumLeadMissedFollowupPercentage = ($data['missedFollowup'] > 0) ? round(($data['mediumLeadMissedFollowup'] / $data['missedFollowup']) * 100, 2) : 0;

$testFromOwnLeadPercentage = ($data['testInPeriod'] > 0) ? round(($data['testFromOwnLead'] / $data['testInPeriod']) * 100, 2) : 0;
$brandTestPercentage = ($data['testInPeriod'] > 0) ? round(($data['brandTest'] / $data['testInPeriod']) * 100, 2) : 0;

$clientFromOwnLeadPercentage = ($data['clientsInPeriod'] > 0) ? round(($data['clientFromOwnLead'] / $data['clientsInPeriod']) * 100, 2) : 0;
$brandClosingPercentage = ($data['clientsInPeriod'] > 0) ? round(($data['brandClosing'] / $data['clientsInPeriod']) * 100, 2) : 0;

$highLeadMinePercentage = ($data['totalLeadMine'] > 0) ? round(($data['highLeadMine'] / $data['totalLeadMine']) * 100, 2) : 0;
$mediumLeadMinePercentage = ($data['totalLeadMine'] > 0) ? round(($data['mediumLeadMine'] / $data['totalLeadMine']) * 100, 2) : 0;
$lowLeadMinePercentage = ($data['totalLeadMine'] > 0) ? round(($data['lowLeadMine'] / $data['totalLeadMine']) * 100, 2) : 0;

$onlineStoreLeadMinePercentage = ($data['totalLeadMine'] > 0) ? round(($data['onlineStoreLeadMine'] / $data['totalLeadMine']) * 100, 2) : 0;
$agencyLeadMinePercentage = ($data['totalLeadMine'] > 0) ? round(($data['agencyLeadMine'] / $data['totalLeadMine']) * 100, 2) : 0;
$brandLeadMinePercentage = ($data['totalLeadMine'] > 0) ? round(($data['brandLeadMine'] / $data['totalLeadMine']) * 100, 2) : 0;

$onlineStoreChasingPercentage = ($data['chasingTotal'] > 0) ? round(($data['onlineStoreChasing'] / $data['chasingTotal']) * 100, 2) : 0;
$brandChasingPercentage = ($data['chasingTotal'] > 0) ? round(($data['brandChasing'] / $data['chasingTotal']) * 100, 2) : 0;
$agencyChasingPercentage = ($data['chasingTotal'] > 0) ? round(($data['agencyChasing'] / $data['chasingTotal']) * 100, 2) : 0;
$photographerChasingPercentage = ($data['chasingTotal'] > 0) ? round(($data['photographerChasing'] / $data['chasingTotal']) * 100, 2) : 0;

?>

<h2 class="page-title" style="text-align:center;">{{$data['profile']->firstName}} {{$data['profile']->lastName}}</h4>
<h5 class="page-title" style="text-align:center;">Report Dates: ({{$data['fromDate']}} to  {{$data['toDate']}})</h5>

<p>&nbsp;</p>
<hr>
<h3>&nbsp;</h3>


<h3>Call Updates:</h3>

<p>During this time period, {{$data['profile']->firstName}} made a total of {!! $data['totalCall'] !!} calls. These calls were distributed as follows: {!! $data['lowLeadTotalCall'] !!} calls to Low Leads ({{$lowLeadPercentage}}%), {!! $data['mediumLeadTotalcall'] !!} to Medium Leads ({{$mediumLeadPercentage}}%), and {!! $data['highLeadTotalCall'] !!} to High Leads ({{$highLeadPercentage}}%).</p>

<p>Out of these calls, {{$data['profile']->firstName}} successfully made contact with {!! $data['totalContact'] !!} leads ({{$contactPercentage}}% of Total Call), with a majority of them located in {!! $data['contactCountry'] !!} ({{$data['contactCountryCount'][0]->totalcontact}} contacts).</p>

<p> {{$data['profile']->firstName}} also engaged in {!! $data['totalConversation'] !!} conversations, primarily with leads in the {!! $data['highConversationCountry'] !!}.</p>

<p>Additionally, {{$data['profile']->firstName}} conducted {!! $data['totalFollowup'] !!} follow-ups, mainly with leads in {!! $data['highestFollowupCountry'] !!}.</p>

<p>{{$data['profile']->firstName}} encountered {!! $data['totalGatekeepers'] !!} Gatekeepers, with a majority from the {!! $data['highestGKcountry'] !!}.</p>

<p>Finally, there were {!! $data['totalUnavailable'] !!} unavailable leads, of which majority were from {!! $data['highestUnavailableCountry'] !!}.</p>

<p>On average, {{$data['profile']->firstName}} made {!! $data['averageCall'] !!} calls per day, with the highest number of calls ({!! $data['heightsCall'] !!}) on {!! $data['highestCallDate'] !!}, and the lowest ({!! $data['lowestCall'] !!}) on {!! $data['lowestCallDate'] !!}.</p>



<p>&nbsp;</p>
<hr>
<h3>&nbsp;</h3>



<h3>Conversation Updates:</h3>

<p>{{$data['profile']->firstName}} engaged in {!! $data['totalConversation'] !!} conversations, with {!! $data['conversationHighLead'] !!} high leads ({{$conversationHighLeadPercentage}}%), {!! $data['conversationMedumLead'] !!} medium leads ({{$conversationMediumLeadPercentage}}%), and {!! $data['conversationLowLead'] !!} low leads ({{$conversationLowLeadPercentage}}%).

The majority of {{$data['profile']->firstName}}'s conversations took place in the  {!! $data['highestConvoCountry'] !!} (1000 conversations, 1000%), while {!! $data['lowestConvoCountry'] !!} had the lowest number (1000 conversations, 1000%).</p>

<p>
    @if (count($data['missingLeadInfoInConvo']) == 1)
        One lead is missing information:
    @else
        <strong>{{count($data['missingLeadInfoInConvo'])}} leads are missing information:</strong>
    @endif
</p>

@foreach ($data['missingLeadInfoInConvo'] as $lead)
    <p>
        <ul>
            {{$lead->leadId}} - {{$lead->companyName}} (
            @if (is_null($lead->volume))
                Volume
            @endif

            @if (is_null($lead->volume) && is_null($lead->frequency))
                and
            @endif

            @if (is_null($lead->frequency))
                Frequency,
            @endif

            @if (is_null($lead->process))
                Process
            @endif
            )
        </ul>
    </p>
@endforeach


<p>On average, it took {!! $data['avgAttemptInConvo'] !!} attempts per lead to initiate a conversation.</p>



<p>&nbsp;</p>
<hr>
<p>&nbsp;</p>



<h3>Follow-up Updates:</h3>

<p>{{$data['profile']->firstName}} followed up with {!! $data['totalFollowup'] !!} leads, including {!! $data['highLeadsFollowup'] !!} high leads ({{$highLeadsFollowupPercentage}}%), {!! $data['mediumLeadsFollowup'] !!} medium leads ({{$mediumLeadsFollowupPercentage}}%), and {!! $data['lowLeadsFollowup'] !!} low leads ({{$lowLeadsFollowupPercentage}}%). Unfortunately, {{$data['profile']->firstName}} missed {!! $data['missedFollowup'] !!} follow-ups during this month, with {!! $data['highLeadMissedFollowup'] !!} high leads ({{$highLeadMissedFollowupPercentage}}%) and {!! $data['mediumLeadMissedFollowup'] !!} medium leads ({{$mediumLeadMissedFollowupPercentage}}%) among them.</p>




<p>&nbsp;</p>
<hr>
<p>&nbsp;</p>



<h3>Test Updates:</h3>

<p>During this time frame, {{$data['profile']->firstName}} received {!! $data['testInPeriod'] !!} tests. 
    
    <span style="text-decoration: line-through;">Three of these tests came from the UK (1000%), and two from Germany (1000%).</span> 

Among these tests, there were {!! $data['highLeadTest'] !!} high leads, {!! $data['mediumLeadTest'] !!} medium lead, and {!! $data['lowLeadTest'] !!} low lead.</p>

<p>&nbsp;</p>

<p>
    {{$data['profile']->firstName}} has brought Tests from following leads:
</p>

@foreach ($data['testLeadData'] as $lead)
    <p>
        <ul>
            {{$lead['companyName']}} - {{$lead['website']}} ({{$lead['possibilityName']}})
            in {{$lead['country']}} after {{$lead['attempts']}} attempts,
            with a {{$lead['differenceInDays']}}-day gap between the first call and free trial day.
        </ul>
    </p>
@endforeach


<p>&nbsp;</p>

<p>{!! $data['testFromOwnLead'] !!} of the tests were from leads that {{$data['profile']->firstName}} had mined himself ({{$testFromOwnLeadPercentage}}%), and there was {!! $data['brandTest'] !!} brand involved ({{$brandTestPercentage}}%).</p>



<p>&nbsp;</p>
<hr>
<p>&nbsp;</p>




<h3>Closing Updates:</h3>

<p>{{$data['profile']->firstName}} achieved {!! $data['clientsInPeriod'] !!} closings during this period. 
    
    <span style="text-decoration: line-through;">One closing came from the UK (1000%), one from Italy (1000%), and one from Germany (1000%).</span> 

These closings included {!! $data['highLeadClosing'] !!} high lead (1000%), {!! $data['mediumLeadClosing'] !!} medium lead (1000%), and {!! $data['lowLeadClosing'] !!} low lead (1000%). The conversion rate from tests to closings was {!! $data['testToClosingRatio'] !!}%.</p>

<p>&nbsp;</p>

<p>
    {{$data['profile']->firstName}} closed deals with the following leads:
</p>

@foreach ($data['closingLeadData'] as $lead)
    <p>
        <ul>
            {{$lead['companyName']}} - {{$lead['website']}} ({{$lead['possibilityName']}})
            in {{$lead['country']}} after {{$lead['attempts']}} attempts,
            with a {{$lead['differenceInDays']}} days gap between the test and closing.
        </ul>
    </p>
@endforeach


<p>&nbsp;</p>

<p>{!! $data['clientFromOwnLead'] !!} of the closings were from leads that {{$data['profile']->firstName}} had mined himself ({{$clientFromOwnLeadPercentage}}%), and there were {!! $data['brandClosing'] !!} brand involved ({{$brandClosingPercentage}}%).</p>




<p>&nbsp;</p>
<hr>
<p>&nbsp;</p>



<h3>Lead Mine Updates:</h3>

<p>{{$data['profile']->firstName}} mined a total of {!! $data['totalLeadMine'] !!} leads, categorized as follows: {!! $data['highLeadMine'] !!} High ({{$highLeadMinePercentage}}%), {!! $data['mediumLeadMine'] !!} Medium ({{$mediumLeadMinePercentage}}%), and {!! $data['lowLeadMine'] !!} Low leads ({{$lowLeadMinePercentage}}%). Among these leads, there were {!! $data['onlineStoreLeadMine'] !!} online stores ({{$onlineStoreLeadMinePercentage}}%), {!! $data['agencyLeadMine'] !!} agencies ({{$agencyLeadMinePercentage}}%), and {!! $data['brandLeadMine'] !!} brands ({{$brandLeadMinePercentage}}%). The majority of leads ({!! $data['highestLeadMineCountryCount'] !!}) were mined from {!! $data['highestLeadMineCountry'] !!}, while the lowest number of leads ({!! $data['lowestLeadMineCountryCount'] !!}) were from {!! $data['lowestLeadMineCountry'] !!}.</p>




<p>&nbsp;</p>
<hr>
<p>&nbsp;</p>



<h3>Current Status</h3>

<p>{{$data['profile']->firstName}} is currently chasing {!! $data['chasingTotal'] !!} accounts where {{$data['profile']->gender == 'M' ? 'he' : 'she'}} has {!! $data['onlineStoreChasing'] !!} Online Stores ({{$onlineStoreChasingPercentage}}%), {!! $data['brandChasing'] !!} Brands ({{$brandChasingPercentage}}%), {!! $data['agencyChasing'] !!}  Agencies ({{$agencyChasingPercentage}}%), and {!! $data['photographerChasing'] !!} Photographers ({{$photographerChasingPercentage}}%). </p>

<p>In {{$data['profile']->gender == 'M' ? 'his' : 'her'}} Sales Pipeline, {{$data['profile']->firstName}} has {!! $data['salesPipelineContact'] !!} in Contact stage, {!! $data['salesPipelineConversation'] !!} in Conversation stage and {!! $data['salesPipelinePossibility'] !!} in Test Possibility stage. </p>

<p>Currently, {{$data['profile']->firstName}} has {!! $data['longTimeNoChase'] !!} leads that {{$data['profile']->gender == 'M' ? 'he' : 'she'}} hasn’t been chasing for more than 6 months. {{$data['profile']->gender == 'M' ? 'He' : 'She'}} also has {!! $data['testButNotClosed'] !!} leads with tests that are not closed yet, but {{$data['profile']->gender == 'M' ? 'he' : 'she'}} is still chasing them. Additionally, {{$data['profile']->firstName}} has {!! $data['ippList'] !!} leads in the IPP List.</p>

<p>&nbsp;</p>

