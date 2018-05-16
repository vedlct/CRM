

<table border="1">
<tr>
    <th>Name</th>
    <th>Total Call</th>
    <th>Follow up</th>
    <th>Contacted</th>
    <th>Assigned Lead</th>
    <th>High Possibility</th>
    <th>Test Lead</th>
    <th>Closing Lead</th>
    <th>Lead Mined</th>
</tr>
    @foreach( $users as $user)
        <tr>
    <td>{{$user->firstName}}</td>
    <td>@foreach($calledThisWeek as $uc)

    @if($uc->userId == $user->userid)
        {{$uc->userCall}}
        @endif
        @endforeach
    </td>
            <td>@foreach($followupThisWeek as $fu)

                    @if($fu->userId == $user->userid)
                        {{$fu->userFollowup}}
                    @endif
                @endforeach
            </td>
            <td>@foreach($contacted as $c)

                    @if($c->userId == $user->userid)
                        {{$c->userContacted}}
                    @endif
                @endforeach
            </td>
            <td>@foreach($assignedLead as $al)

                    @if($al->assignTo == $user->userid)
                        {{$al->userAssignedLead}}
                    @endif
                @endforeach
            </td>

            <td>@foreach($highPosibilitiesThisWeekUser as $hp)

                    @if($hp->userId == $user->userid)
                        {{$hp->userHighPosibilities}}
                    @endif
                @endforeach
            </td>
            <td>@foreach($testLead as $tl)

                    @if($tl->userId == $user->userid)
                        {{$tl->userTestLead}}
                    @endif
                @endforeach
            </td>
            <td>@foreach($followupThisWeek as $fu)

                    @if($fu->userId == $user->userid)
                        {{$fu->userFollowup}}
                    @endif
                @endforeach
            </td>
            <td>@foreach($leadMinedThisWeek as $lm)

                    @if($lm->minedBy == $user->userid)
                        {{$lm->userLeadMined}}
                    @endif
                @endforeach
            </td>


        </tr>
      @endforeach

</table>

