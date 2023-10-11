@php
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

@endphp

        <div>
            <h2 class="page-title" style="text-align:center;">{!! $data['profile']->firstName!!} {!!$data['profile']->lastName!!}</h2>
            <h5 class="page-subtitle" style="text-align:center;">Report Dates: ({!!$data['fromDate']!!} to  {!!$data['toDate']!!})</h5>
        </div>


        <br><hr><br>


        <h3>Call Updates:</h3>

        <p>During this time period, {!!$data['profile']->firstName!!} made a total of <strong>{!! $data['totalCall'] !!}</strong> calls. These calls were distributed as follows: <strong>{!! $data['lowLeadTotalCall'] !!}</strong> calls to Low Leads ({!!$lowLeadPercentage!!}%), <strong>{!! $data['mediumLeadTotalcall'] !!}</strong> to Medium Leads ({!!$mediumLeadPercentage!!}%), and <strong>{!! $data['highLeadTotalCall'] !!}</strong> to High Leads ({!!$highLeadPercentage!!}%).</p>

        <p>Out of these calls, {!!$data['profile']->firstName!!} successfully made contact with <strong>{!! $data['totalContact'] !!}</strong> leads ({{$contactPercentage}}% of Total Call), with a majority of them located in <strong>{!! $data['contactCountry'] !!}</strong> ({!!$data['contactCountryCount']!!} contacts).</p>

        <p> {!!$data['profile']->firstName!!} also engaged in <strong>{!! $data['totalConversation'] !!}</strong> conversations, primarily with leads in the <strong>{!! $data['highConversationCountry'] !!}</strong>.Additionally, {!!$data['profile']->firstName!!} conducted <strong>{!! $data['totalFollowup'] !!}</strong> follow-ups, mainly with leads in <strong>{!! $data['highestFollowupCountry'] !!}</strong>.</p>

        <p>{!!$data['profile']->firstName!!} encountered <strong>{!! $data['totalGatekeepers'] !!}</strong> Gatekeepers, with a majority from the <strong>{!! $data['highestGKcountry'] !!}</strong>. Besides, {!!$data['profile']->gender == 'M' ? 'he' : 'she'!!}  sent <strong>{!! $data['totalEmailSent'] !!}</strong> emails, where the number of Cold Email is <strong>{!! $data['totalColdEmail'] !!}</strong>.</p>


        <p>Finally, there were <strong>{!! $data['totalUnavailable'] !!}</strong> unavailable leads, of which the majority were from <strong>{!! $data['highestUnavailableCountry'] !!}</strong>.</p>

        <p>On average, {!!$data['profile']->firstName!!} made <strong>{!! $data['averageCall'] !!}</strong> calls per day, with the highest number of calls (<strong>{!! $data['heightsCall'] !!}</strong>) on <strong>{!! $data['highestCallDate'] !!}</strong>, and the lowest (<strong>{!! $data['lowestCall'] !!}</strong>) on <strong>{!! $data['lowestCallDate'] !!}</strong>.</p>



        <br><hr><br>



        <h3>Conversation Updates:</h3>

        <p>{!!$data['profile']->firstName!!} engaged in <strong>{!! $data['totalConversation'] !!}</strong> conversations, with <strong>{!! $data['conversationHighLead'] !!}</strong> high leads ({!!$conversationHighLeadPercentage!!}}%), <strong>{!! $data['conversationMedumLead'] !!}</strong> medium leads ({!!$conversationMediumLeadPercentage!!}%), and <strong>{!! $data['conversationLowLead'] !!}</strong> low leads ({!!$conversationLowLeadPercentage!!}%).</p>

        <p>The majority of {!!$data['profile']->firstName!!}'s conversations took place in the  <strong>{!! $data['highestConvoCountry'] !!}</strong> ({!!$data['highestConvoCountryCount']!!} conversations), while <strong>{!! $data['lowestConvoCountry'] !!}</strong> had the lowest number ({!!$data['lowestConvoCountryCount']!!} conversations).</p>

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
                    {{$lead->leadId}} - {{$lead->companyName}}(
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

        <br>
        <p>On average, it took <strong>{!! $data['avgAttemptInConvo'] !!}</strong> attempts per lead to initiate a conversation.</p>



        <br><hr><br>



        <h3>Follow-up Updates:</h3>

        <p>{!!$data['profile']->firstName!!} followed up with <strong>{!! $data['totalFollowup'] !!}</strong> leads, including <strong>{!! $data['highLeadsFollowup'] !!}</strong> high leads ({!!$highLeadsFollowupPercentage!!}%), <strong>{!! $data['mediumLeadsFollowup'] !!}</strong> medium leads ({!!$mediumLeadsFollowupPercentage!!}%), and <strong>{!! $data['lowLeadsFollowup'] !!}</strong> low leads ({!!$lowLeadsFollowupPercentage!!}%). Unfortunately, {!!$data['profile']->firstName!!} missed <strong>{!! $data['missedFollowup'] !!}</strong> follow-ups during this period, with <strong>{!! $data['highLeadMissedFollowup'] !!}</strong> high leads ({!!$highLeadMissedFollowupPercentage!!}%) and <strong>{!! $data['mediumLeadMissedFollowup'] !!}</strong> medium leads ({!!$mediumLeadMissedFollowupPercentage!!}%) among them.</p>



        <br><hr><br>



        <h3>Test Updates:</h3>

        <p>During this time frame, {!!$data['profile']->firstName!!} received <strong>{!! $data['testInPeriod'] !!}</strong> tests where {!! $data['highestTestCountryCount'] !!} of the tests came from the {!! $data['highestTestCountry'] !!}.</p>

        <p>Among these tests, there were <strong>{!! $data['highLeadTest'] !!}</strong> high leads, <strong>{!! $data['mediumLeadTest'] !!}</strong> medium lead, and <strong>{!! $data['lowLeadTest'] !!}</strong> low lead.</p>

        <br>

        <p>
            {!!$data['profile']->firstName!!} has brought Tests from following leads:
        </p>

        @foreach ($data['testLeadData'] as $lead)
            <p>
                <ul>
                    <li>
                        {{$lead['leadId']}} - {{$lead['companyName']}} - {{$lead['website']}} ({{$lead['possibilityName']}})
                        in {{$lead['country']}} after {{$lead['attempts']}} attempts,
                        with a {{$lead['differenceInDays']}} days gap between the first call and free trial day.
                    </li>
                </ul>
            </p>
        @endforeach

        <p>&nbsp;</p>

        <p><strong>{!! $data['testFromOwnLead'] !!}</strong> of the tests were from leads that {!!$data['profile']->firstName!!} had mined {!!$data['profile']->gender == 'M' ? 'himself' : 'herself'!!} ({!!$testFromOwnLeadPercentage!!}% of total tests), and there was <strong>{!! $data['brandTest'] !!}</strong> brand involved ({!!$brandTestPercentage!!}% of total tests).</p>



        <br><hr><br>


        <h3>Closing Updates:</h3>

        <p>{{$data['profile']->firstName}} achieved <strong>{!! $data['clientsInPeriod'] !!}</strong> closings during this periodwhere {!! $data['highestClosingCountryCount'] !!} of the clients came from the {!! $data['highestClosingCountry'] !!}.</p>

        <p>These closings included <strong>{!! $data['highLeadClosing'] !!}</strong> high lead, <strong>{!! $data['mediumLeadClosing'] !!}</strong> medium lead, and <strong>{!! $data['lowLeadClosing'] !!}</strong> low lead. The conversion rate from tests to closings was <strong>{!! $data['testToClosingRatio'] !!}</strong>%.</p>

        <br>

        <p>
            {!!$data['profile']->firstName!!} closed deals with the following leads:
        </p>

        @foreach ($data['closingLeadData'] as $lead)
            <p>
                <ul>
                    <li>
                        {{$lead['leadId']}} - {{$lead['companyName']}} - {{$lead['website']}} ({{$lead['possibilityName']}})
                        in {{$lead['country']}} after {{$lead['attempts']}} attempts,
                        with a {{$lead['differenceInDays']}} days gap between the test and closing.
                    </li>
                </ul>
            </p>
        @endforeach

        <br>

        <p><strong>{!! $data['clientFromOwnLead'] !!}</strong> of the closings were from leads that {!!$data['profile']->firstName!!} had mined {!!$data['profile']->gender == 'M' ? 'himself' : 'herself'!!} ({!!$clientFromOwnLeadPercentage!!}% of total clients), and there were <strong>{!! $data['brandClosing'] !!}</strong> brand involved ({!!$brandClosingPercentage!!}% of total clients).</p>




        <br><hr><br>



        <h3>Lead Mine Updates:</h3>

        <p>{!!$data['profile']->firstName!!} mined a total of <strong>{!! $data['totalLeadMine'] !!}</strong> leads, categorized as follows: <strong>{!! $data['highLeadMine'] !!}</strong> High ({!!$highLeadMinePercentage!!}%), <strong>{!! $data['mediumLeadMine'] !!}</strong> Medium ({!!$mediumLeadMinePercentage!!}%), and <strong>{!! $data['lowLeadMine'] !!}</strong> Low leads ({!!$lowLeadMinePercentage!!}%). Among these leads, there were <strong>{!! $data['onlineStoreLeadMine'] !!}</strong> online stores ({!!$onlineStoreLeadMinePercentage!!}%), <strong>{!! $data['agencyLeadMine'] !!}</strong> agencies ({!!$agencyLeadMinePercentage!!}%), and <strong>{!! $data['brandLeadMine'] !!}</strong> brands ({!!$brandLeadMinePercentage!!}%). The majority of leads (<strong>{!! $data['highestLeadMineCountryCount'] !!}</strong>) were mined from {!! $data['highestLeadMineCountry'] !!}, while the lowest number of leads (<strong>{!! $data['lowestLeadMineCountryCount'] !!}</strong>) were from {!! $data['lowestLeadMineCountry'] !!}.</p>

        <p>During this period, {!!$data['profile']->firstName!!} received <strong>{!! $data['leadAssigned'] !!}</strong> leads from the supervisors.</p>



        <br><hr><br>



        <h3>Current Status</h3>

        <p>{!!$data['profile']->firstName!!} is currently chasing <strong>{!! $data['chasingTotal'] !!}</strong> accounts where {!!$data['profile']->gender == 'M' ? 'he' : 'she'!!} has <strong>{!! $data['onlineStoreChasing'] !!}</strong> Online Stores ({!!$onlineStoreChasingPercentage!!}%), <strong>{!! $data['brandChasing'] !!}</strong> Brands ({!!$brandChasingPercentage!!}%), <strong>{!! $data['agencyChasing'] !!}</strong> Agencies ({!!$agencyChasingPercentage!!}%), and <strong>{!! $data['photographerChasing'] !!}</strong> Photographers ({!!$photographerChasingPercentage!!}%).</p>

        <p>In {!!$data['profile']->gender == 'M' ? 'his' : 'her'!!} Sales Pipeline, {!!$data['profile']->firstName!!} has <strong>{!! $data['salesPipelineContact'] !!}</strong> in Contact stage, <strong>{!! $data['salesPipelineConversation'] !!}</strong> in Conversation stage and <strong>{!! $data['salesPipelinePossibility'] !!}</strong> in Test Possibility stage.</p>

        <p>Currently, {!!$data['profile']->firstName!!} has <strong>{!! count($data['longTimeNoChase']) !!}</strong> leads that {!!$data['profile']->gender == 'M' ? 'he' : 'she'!!} has not been chasing for more than 6 months. {!!$data['profile']->gender == 'M' ? 'He' : 'She'!!} also has <strong>{!! $data['testButNotClosed'] !!}</strong> leads with tests that are not closed yet, but {!!$data['profile']->gender == 'M' ? 'he' : 'she'!!} is still chasing them. Additionally, {!!$data['profile']->firstName!!} has <strong>{!! $data['ippList'] !!}</strong> leads in the IPP List. Besides, {!!$data['profile']->gender == 'M' ? 'he' : 'she'!!} has <strong>{!! $data['followupNotSet'] !!}</strong> leads which do not have any followup dates.</p>

        <br><br>

        <h5>Long Time No Chase Lead Id</h5>
        <hr>
            @foreach ($data['longTimeNoChase'] as $lead)
                <p>{{ $lead->leadId }} - {{ $lead->website }}</p>
            @endforeach

