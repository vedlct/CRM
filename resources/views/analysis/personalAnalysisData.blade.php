<h4>Call Updates:</h4>

<p>During this time period, {{$data['user']->firstName}} made a <strong>total of {!! $data['totalCall'] !!} calls</strong>. These calls were distributed as follows: {!! $data['lowLeadTotalCall'] !!} calls to <strong>Low Leads</strong> (23.67%), {!! $data['mediumLeadTotalcall'] !!} to <strong>Medium Leads</strong> (35.50%), and {!! $data['highLeadTotalCall'] !!} to <strong>High Leads</strong> (40.83%).</p>

<p>Out of these calls, {{$data['user']->firstName}} successfully made <strong>contact</strong> with {!! $data['totalContact'] !!} leads (9.57% of Total Call), with a majority of them located in <strong>{!! $data['contactCountry'] !!}</strong> (24 contacts).</p>

<p> {{$data['user']->firstName}} also engaged in {!! $data['totalConversation'] !!} <strong>conversations</strong>, primarily with leads in the <strong>{!! $data['highConversationCountry'] !!}</strong> (7 conversations).</p>

<p>Additionally, {{$data['user']->firstName}} conducted {!! $data['totalFollowup'] !!} <strong>follow-ups</strong>, mainly with leads in <strong>{!! $data['highestFollowupCountry'] !!}</strong> (12 follow-ups).</p>

<p>{{$data['user']->firstName}} encountered {!! $data['totalGatekeepers'] !!} <strong>Gatekeepers</strong>, with a majority from the {!! $data['highestGKcountry'] !!} (23 GK).</p>

<p>Finally, there were {!! $data['totalUnavailable'] !!} <strong>unavailable leads</strong>, of which 102 were from <strong>{!! $data['highestUnavailableCountry'] !!}</strong>.</p>

<p>On <strong>average</strong>, {{$data['user']->firstName}} made {!! $data['averageCall'] !!} calls per day, with the <strong>highest number of calls</strong> ({!! $data['heightsCall'] !!}) on {!! $data['highestCallDate'] !!}, and the <strong>lowest</strong> ({!! $data['lowestCall'] !!}) on {!! $data['lowestCallDate'] !!}.</p>



<h4>&nbsp;</h4>

<h4>Conversation Updates:</h4>

<p>{{$data['user']->firstName}} engaged in {!! $data['totalConversation'] !!} conversations, with {!! $data['conversationHighLead'] !!} high leads (18.75%), {!! $data['conversationMedumLead'] !!} medium leads (12.50%), and {!! $data['conversationLowLead'] !!} low leads (68.75%). 
The majority of {{$data['user']->firstName}}'s conversations took place in the  {!! $data['highestConvoCountry'] !!} (7 conversations, 43.75%), while {!! $data['lowestConvoCountry'] !!} had the lowest number (2 conversations, 12.50%).</p>

<p>
    @if (count($data['missingLeadInfoInConvo']) == 1)
        One lead is missing information:
    @else
        {{count($data['missingLeadInfoInConvo'])}} leads are missing information:
    @endif
</p>

@foreach ($data['missingLeadInfoInConvo'] as $lead)
    <p>
        - "{{$lead->companyName}}" (
        @if (is_null($lead->volume))
            Volume
        @endif

        @if (is_null($lead->volume) && is_null($lead->frequency))
            and
        @endif

        @if (is_null($lead->frequency))
            Frequency
        @endif

        @if (is_null($lead->process))
            Process
        @endif
        )
    </p>
@endforeach



<p>On average, it took {!! $data['avgAttemptInConvo'] !!} attempts per lead to initiate a conversation.</p>

<p>&nbsp;</p>

<h4>Follow-up Updates:</h4>

<p>{{$data['user']->firstName}} followed up with {!! $data['totalFollowup'] !!} leads, including {!! $data['highLeadsFollowup'] !!} high leads (24.07%), {!! $data['mediumLeadsFollowup'] !!} medium leads (20.37%), and {!! $data['lowLeadsFollowup'] !!} low leads (55.56%). Unfortunately, {{$data['user']->firstName}} missed {!! $data['missedFollowup'] !!} follow-ups during this month, with {!! $data['highLeadMissedFollowup'] !!} high leads (28.05%) and {!! $data['mediumLeadMissedFollowup'] !!} medium leads (19.51%) among them.</p>

<p>&nbsp;</p>

<h4>Test Updates:</h4>

<p>During this time frame, {{$data['user']->firstName}} received {!! $data['testInPeriod'] !!} tests. 
    
    <i>Three of these tests came from the UK (60%), and two from Germany (40%).</i> 

Among these tests, there were {!! $data['highLeadTest'] !!} high leads (60%), {!! $data['mediumLeadTest'] !!} medium lead (20%), and {!! $data['lowLeadTest'] !!} low lead (20%).</p>

<p>&nbsp;</p>

<p>
    {{$data['user']->firstName}} has brought Tests from following leads:
</p>

@foreach ($data['testLeadData'] as $lead)
    <p>
        <ul>
            <strong>{{$lead['companyName']}}</strong> - {{$lead['website']}} ({{$lead['possibilityName']}})
            in {{$lead['country']}} after <strong>{{$lead['attempts']}} attempts</strong>,
            with a {{$lead['differenceInDays']}}-day gap between the first call and free trial day.
        </ul>
    </p>
@endforeach


<p>&nbsp;</p>

<p>Two of the tests were from leads that {{$data['user']->firstName}} had mined himself (40%), and there was one brand involved (20%).</p>

<p>&nbsp;</p>

<h4>Closing Updates:</h4>

<p>{{$data['user']->firstName}} achieved {!! $data['clientsInPeriod'] !!} closings during this period. 
    
    <i>One closing came from the UK (33.33%), one from Italy (33.33%), and one from Germany (33.33%).</i> 

These closings included {!! $data['highLeadClosing'] !!} high lead (33.33%), {!! $data['mediumLeadClosing'] !!} medium lead (33.33%), and {!! $data['lowLeadClosing'] !!} low lead (33.33%). The conversion rate from tests to closings was {!! $data['testToClosingRatio'] !!}%.</p>

<p>&nbsp;</p>

<p>
    {{$data['user']->firstName}} closed deals with the following leads:
</p>

@foreach ($data['closingLeadData'] as $lead)
    <p>
        <ul>
            <strong>{{$lead['companyName']}}</strong> - {{$lead['website']}} ({{$lead['possibilityName']}})
            in {{$lead['country']}} after <strong>{{$lead['attempts']}} attempts</strong>,
            with a {{$lead['differenceInDays']}} days gap between the test and closing.
        </ul>
    </p>
@endforeach


<p>&nbsp;</p>

<p>{!! $data['clientFromOwnLead'] !!} of the closings were from leads that {{$data['user']->firstName}} had mined himself (66.67%), and there were {!! $data['brandClosing'] !!} brand involved (33.33%).</p>

<p>&nbsp;</p>

<h4>Lead Mine Updates:</h4>

<p>{{$data['user']->firstName}} mined a total of {!! $data['totalLeadMine'] !!} leads, categorized as follows: {!! $data['highLeadMine'] !!} High (19.61%), {!! $data['mediumLeadMine'] !!} Medium (32.35%), and {!! $data['lowLeadMine'] !!} Low leads (48.04%). Among these leads, there were {!! $data['onlineStoreLeadMine'] !!} online stores (40.20%), {!! $data['agencyLeadMine'] !!} agencies (38.24%), and {!! $data['brandLeadMine'] !!} brands (14.71%). The majority of leads ({!! $data['highestLeadMineCountryCount'] !!}) were mined from {!! $data['highestLeadMineCountry'] !!} (68.63%), accounting for 68%, while the lowest number of leads ({!! $data['lowestLeadMineCountryCount'] !!}) were from {!! $data['lowestLeadMineCountry'] !!} (1.96%), making up only 2% of the total.</p>

<p>&nbsp;</p>

<h4>Current Status</h4>

<p>{{$data['user']->firstName}} is currently chasing {!! $data['chasingTotal'] !!} accounts where {{$data['user']->gender == 'M' ? 'he' : 'she'}} has {!! $data['onlineStoreChasing'] !!} Online Stores (20%), {!! $data['brandChasing'] !!} Brands (30%), {!! $data['agencyChasing'] !!}  Agencies (25%), and {!! $data['photographerChasing'] !!} Photographers (25%). </p>

<p>In {{$data['user']->gender == 'M' ? 'his' : 'her'}} Sales Pipeline, {{$data['user']->firstName}} has {!! $data['salesPipelineContact'] !!} in Contact stage, {!! $data['salesPipelineConversation'] !!} in Conversation stage and {!! $data['salesPipelinePossibility'] !!} in Test Possibility stage. </p>

<p>Currently, {{$data['user']->firstName}} has {!! $data['longTimeNoChase'] !!} leads that {{$data['user']->gender == 'M' ? 'he' : 'she'}} hasn’t been chasing for more than 6 months. {{$data['user']->gender == 'M' ? 'He' : 'She'}} also has {!! $data['testButNotClosed'] !!} leads with tests that are not closed yet, but {{$data['user']->gender == 'M' ? 'he' : 'she'}} is still chasing them. Additionally, {{$data['user']->firstName}} has {!! $data['ippList'] !!} leads in the IPP List.</p>
