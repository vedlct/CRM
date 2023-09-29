@extends('main')
@section('content')

    <!--High Possibility Modal -->
    <div class="modal" id="highPossibility" role="dialog">
        <div class="modal-dialog" style="max-width: 80%">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title"><label id="label"></label></h4>
                </div>
                <div class="modal-body">
                    <div id="name" style="text-align: center; font-weight:bold;"></div>
                    <div id="txtHint">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <div class="card" style="padding:10px;">
        <label><b>Search</b></label>
        <form method="post" action="{{route('searchTableByDate')}}">
            {{csrf_field()}}
            <div class="row">
                <div class="col-auto mb-2">
                    <input type="text" placeholder=" From" id="fromdate" name="fromDate" style="border-radius: 50px;" >
                </div>
                <div class="col-auto mb-2">
                    <input type="text" placeholder=" To" id="todate" name="toDate" style="border-radius: 50px;" >
                </div>
                <div class="col-md-5">
                    <button type="submit" class="btn btn-success">Search</button>
                </div>
            </div>
        </form>

      {{--  <div class="card-header">
            <label><b>Search</b></label>
            <input type="text" placeholder=" From" id="fromDate" name="fromDate" style="border-radius: 50px;" >
            <input type="text" placeholder=" To" id="toDate" name="toDate" style="border-radius: 50px;" >
            <a href="" data-toggle="tab" class="btn btn-success" onclick="dateval()">Search</a>
        </div>--}}

        <div class="card-body">
            <h2>Report</h2>
            @if(isset($fromDate) && isset($toDate))
                <p>Report From {{$fromDate}} to {{$toDate}}</p>
            @else
                <p>Weekly report</p>
            @endif

            @if(Auth::user()->typeId !=4)
                <div class="table-responsive">
                <table class="table table-striped table-bordered valueReport">
                    <thead>
                    <tr>
                        <th>Name</th>
                        <th>New Contact</th>
                        <th>Conversation</th>
                        <th>Follow up</th>
                        <th>Email</th>
                        <th>Cold Email</th>
                        <th>Not Available</th>
                        <th>Gate Keeper</th>
                        <th>Not Interested</th>
                        <th>Total Call</th>
                        <th>Assigned Lead</th>
                        <th>High Possibility</th>
                        <th>Test Lead</th>
                        <th>Close Lead</th>
                        <!-- <th>New File</th> -->
                        <th>Lead Mined</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach( $users as $user)
                        <tr>
                            <td>{{$user->firstName}}</td>
                            <td>
                                @php($value=0)
                                @foreach($contacted as $c)
                                    @if($c->userId == $user->userid)
                                        <a href="#" class="highpossibility" onclick="getContactedIndividual(this)"
                                           @if(isset($fromDate) && isset($toDate))
                                           data-date-from="{{$fromDate}}"
                                           data-date-to="{{$toDate}}"
                                           @endif
                                           data-user-id="{{$user->userid}}"
                                           data-user-name="{{$user->userName}}">{{$value=$c->userContacted}}</a>
                                        @php($value1=0)
                                        @break
                                    @endif
                                @endforeach
                                @if($value==0)
                                    <a href="#" >0</a>
                                @endif
                            </td>
                            <td>
                                @php($value=0)
                                @foreach($conversation as $cs)
                                    @if($cs->userId == $user->userid)
                                        <a href="#" class="highpossibility" onclick="totalconversation(this)"
                                           @if(isset($fromDate) && isset($toDate))
                                           data-date-from="{{$fromDate}}"
                                           data-date-to="{{$toDate}}"
                                           @endif
                                           data-user-id="{{$user->userid}}"
                                           data-user-name="{{$user->userName}}">{{$value=$cs->conversation}}</a>
                                    @endif
                                @endforeach
                                @if($value==0)
                                    <a href="#" >0</a>
                                @endif
                            </td>
                            <td>
                                @php($value=0)
                                @foreach($followupThisWeek as $fu)
                                    @if($fu->userId == $user->userid)
                                        <a href="#" class="highpossibility" onclick="followup(this)"
                                           @if(isset($fromDate) && isset($toDate))
                                           data-date-from="{{$fromDate}}"
                                           data-date-to="{{$toDate}}"
                                           @endif
                                           data-user-id="{{$user->userid}}"
                                           data-user-name="{{$user->userName}}">{{$value=$fu->userFollowup}}</a>
                                        @break
                                    @endif
                                @endforeach
                                @if($value==0)
                                    <a href="#" >0</a>
                                @endif
                            </td>
                            <td>
                                @php($value=0)
                                @foreach($emailed as $uc)
                                    @if($uc->userId == $user->userid)
                                        <a href="#" class="highpossibility" onclick="totalEmail(this)"
                                           @if(isset($fromDate) && isset($toDate))
                                           data-date-from="{{$fromDate}}"
                                           data-date-to="{{$toDate}}"
                                           @endif
                                           data-user-id="{{$user->userid}}"
                                           data-user-name="{{$user->userName}}">{{$value=$uc->userEmailed}}</a>
                                    @endif
                                @endforeach
                                @if($value==0)
                                    <a href="#" >0</a>
                                @endif
                            </td>

                            <td>
                                @php($value=0)
                                @foreach($coldemailed as $uc)
                                    @if($uc->userId == $user->userid)
                                        <a href="#" class="highpossibility" onclick="totalcoldEmail(this)"
                                        @if(isset($fromDate) && isset($toDate))
                                        data-date-from="{{$fromDate}}"
                                        data-date-to="{{$toDate}}"
                                        @endif
                                        data-user-id="{{$user->userid}}"
                                        data-user-name="{{$user->userName}}">{{$value=$uc->usercoldEmailed}}</a>
                                    @endif
                                @endforeach
                                @if($value==0)
                                    <a href="#">0</a>
                                @endif
                            </td>
                            <td>
                                @php($value=0)
                                @foreach($notAvailable as $uc)
                                    @if($uc->userId == $user->userid)
                                        <a href="#" class="highpossibility" onclick="totalNotAvailable(this)"
                                           @if(isset($fromDate) && isset($toDate))
                                           data-date-from="{{$fromDate}}"
                                           data-date-to="{{$toDate}}"
                                           @endif
                                           data-user-id="{{$user->userid}}"
                                           data-user-name="{{$user->userName}}">{{$value=$uc->userNotAvialable}}</a>
                                    @endif
                                @endforeach
                                @if($value==0)
                                    <a href="#" >0</a>
                                @endif
                            </td>
                           
                            <td>
                                @php($value=0)
                                @foreach($gatekeeper as $gk)
                                    @if($gk->userId == $user->userid)
                                        <a href="#" class="highpossibility" onclick="totalgatekeeper(this)"
                                           @if(isset($fromDate) && isset($toDate))
                                           data-date-from="{{$fromDate}}"
                                           data-date-to="{{$toDate}}"
                                           @endif
                                           data-user-id="{{$user->userid}}"
                                           data-user-name="{{$user->userName}}">{{$value=$gk->gatekeeper}}</a>
                                    @endif
                                @endforeach
                                @if($value==0)
                                    <a href="#" >0</a>
                                @endif
                            </td>
                            <td>

                                {{-- not interested --}}

                                @php($value=0)
                                @foreach($notInterested as $uc)
                                    @if($uc->userId == $user->userid)
                                        <a href="#" class="highpossibility" onclick="totalNotInterested(this)"
                                           @if(isset($fromDate) && isset($toDate))
                                           data-date-from="{{$fromDate}}"
                                           data-date-to="{{$toDate}}"
                                           @endif
                                           data-user-id="{{$user->userid}}"
                                           data-user-name="{{$user->userName}}">{{$value=$uc->userNotInterested}}</a>
                                    @endif
                                @endforeach
                                @if($value==0)
                                    <a href="#" >0</a>
                                @endif




                            </td>
                            <td>
                                @php($value=0)
                                @foreach($calledThisWeek as $uc)
                                    @if($uc->userId == $user->userid)
                                        <a href="#" class="highpossibility" onclick="totalcall(this)"
                                           @if(isset($fromDate) && isset($toDate))
                                           data-date-from="{{$fromDate}}"
                                           data-date-to="{{$toDate}}"
                                           @endif
                                           data-user-id="{{$user->userid}}"
                                           data-user-name="{{$user->userName}}">{{$value=$value=$uc->userCall}}</a>
                                    @endif
                                @endforeach
                                @if($value==0)
                                <a href="#" >0</a>
                                @endif
                            </td>
                            <td>
                                @php($value=0)
                                @foreach($assignedLead as $al)
                                    @if($al->assignTo == $user->userid)
                                        <a href="#" class="highpossibility" onclick="leadassigned(this)"
                                           @if(isset($fromDate) && isset($toDate))
                                           data-date-from="{{$fromDate}}"
                                           data-date-to="{{$toDate}}"
                                           @endif
                                           data-user-id="{{$user->userid}}"
                                           data-user-name="{{$user->userName}}">{{$value=$al->userAssignedLead}}</a>
                                        @break
                                    @endif
                                @endforeach
                                @if($value==0)
                                    <a href="#" >0</a>
                                @endif
                            </td>
                            <td>
                                @php($value=0)
                                @foreach($highPosibilitiesThisWeekUser as $hp)
                                    @if($hp->userId == $user->userid)
                                        <a href="#" class="highpossibility" onclick="highpossibility(this)"
                                           @if(isset($fromDate) && isset($toDate))
                                           data-date-from="{{$fromDate}}"
                                           data-date-to="{{$toDate}}"
                                           @endif
                                           data-user-id="{{$user->userid}}"
                                           data-user-name="{{$user->userName}}">{{$value=$hp->userHighPosibilities}}</a>
                                        @break
                                    @endif
                                @endforeach
                                @if($value==0)
                                    <a href="#" >0</a>
                                @endif
                            </td>
                            <td>
                                @php($value=0)
                                @foreach($testLead as $tl)
                                    @if($tl->userId == $user->userid)
                                        <a href="#" class="highpossibility" onclick="testlead(this)"
                                           @if(isset($fromDate) && isset($toDate))
                                           data-date-from="{{$fromDate}}"
                                           data-date-to="{{$toDate}}"
                                           @endif
                                           data-user-id="{{$user->userid}}"
                                           data-user-name="{{$user->userName}}"> {{$value=$tl->userTestLead}}</a>
                                        @break
                                    @endif
                                @endforeach
                                @if($value==0)
                                    <a href="#" >0</a>
                                @endif
                            </td>
                            <td>
                                @php($value=0)
                                @foreach($closing as $cl)
                                    @if($cl->userId == $user->userid)
                                        <a href="#" class="highpossibility" onclick="closelead(this)"
                                           @if(isset($fromDate) && isset($toDate))
                                           data-date-from="{{$fromDate}}"
                                           data-date-to="{{$toDate}}"
                                           @endif
                                           data-user-id="{{$user->userid}}"
                                           data-user-name="{{$user->userName}}">{{$value=$cl->userClosing}}</a>
                                        @break
                                    @endif
                                @endforeach
                                @if($value==0)
                                    <a href="#" >0</a>
                                @endif
                            </td>
                            <!-- <td>
                                <a href="#" class="highpossibility" onclick="newFile(this)"
                                   @if(isset($fromDate) && isset($toDate))
                                   data-date-from="{{$fromDate}}"
                                   data-date-to="{{$toDate}}"
                                   @endif
                                   data-user-id="{{$user->userid}}"
                                   data-user-name="{{$user->userName}}">{{$newFiles->where('userId',$user->userid)->sum('fileCount')}}</a>
                            </td> -->

                            <td>
                                @php($value=0)
                                @foreach($leadMinedThisWeek as $lm)
                                    @if($lm->minedBy == $user->userid)
                                        <a href="#" class="highpossibility" onclick="leadmine(this)"
                                           @if(isset($fromDate) && isset($toDate))
                                           data-date-from="{{$fromDate}}"
                                           data-date-to="{{$toDate}}"
                                           @endif
                                           data-user-id="{{$user->userid}}"
                                           data-user-name="{{$user->userName}}">{{$value=$lm->userLeadMined}}</a>
                                        @break
                                    @endif
                                @endforeach
                                @if($value==0)
                                    <a href="#" >0</a>
                                @endif
                            </td>


                            {{--  <td>
                                <a href="#" class="highpossibility" onclick="newCall(this)"
                                   @if(isset($fromDate) && isset($toDate))
                                   data-date-from="{{$fromDate}}"
                                   data-date-to="{{$toDate}}"
                                   @endif
                                   data-user-id="{{$user->userid}}"
                                   data-user-name="{{$user->userName}}"
                                >
                                    {{$newCall->where('userId',$user->userid)->count()}}
                                </a>


                            </td>

                            <td>
                                @php($value=0)
                                @foreach($other as $uc)
                                    @if($uc->userId == $user->userid)

                                        <a href="#" class="highpossibility" onclick="totalOther(this)"
                                           @if(isset($fromDate) && isset($toDate))
                                           data-date-from="{{$fromDate}}"
                                           data-date-to="{{$toDate}}"
                                           @endif
                                           data-user-id="{{$user->userid}}"
                                           data-user-name="{{$user->userName}}"
                                        >{{$value=$uc->userOther}}</a>
                                    @endif
                                @endforeach
                                @if($value==0)
                                    <a href="#" >0</a>
                                @endif
                            </td>

                            <td>
                                        @php($value1=0)
                                        @foreach($contactedUsa as $cUsa)
                                            @if($cUsa->userId == $user->userid)

                                                <a href="#" class="highpossibility" onclick="getContactedUsaIndividual(this)"
                                                   @if(isset($fromDate) && isset($toDate))
                                                   data-date-from="{{$fromDate}}"
                                                   data-date-to="{{$toDate}}"
                                                   @endif
                                                   data-user-id="{{$user->userid}}"
                                                   data-user-name="{{$user->userName}}"
                                                > {{$value1=$value=$cUsa->userContactedUsa}}</a>
                                            @endif

                                        @endforeach
                                        @if($value1==0)
                                            <a href="#" > 0</a>
                                        @endif
                            </td>

                            <td>
                                @php($value=0)
                                @foreach($uniqueHighPosibilitiesThisWeek as $hp)

                                    @if($hp->userId == $user->userid)

                                        <a href="#" class="highpossibility" onclick="highpossibilityUn(this)"
                                           @if(isset($fromDate) && isset($toDate))
                                           data-date-from="{{$fromDate}}"
                                           data-date-to="{{$toDate}}"
                                           @endif
                                           data-user-id="{{$user->userid}}"
                                           data-user-name="{{$user->userName}}"
                                        >
                                            {{$value=$hp->userUniqueHighPosibilities}}
                                        </a>
                                    @endif
                                @endforeach
                                @if($value==0)
                                    <a href="#" >0</a>
                                @endif
                            </td>
                            --}}

                        </tr>
                    @endforeach
                    </tbody>

                </table>
                </div>
            @endif


            <!-- @if(Auth::user()->typeId !=5)
                <div class="mt-5">
                <div class="table-responsive">
                <table class="table table-striped table-bordered valueReport">
                    <thead>
                    <tr>
                        <th>Name</th>
                        <th>Assigned Lead</th>
                        <th>High Possibility</th>
                        <th>Lead Mined</th>
                        <th>Test Lead</th>
                    </tr>
                    </thead>
                    @foreach( $usersRa as $user)
                        <tbody>
                        <tr>
                            <td>{{$user->firstName}}</td>
                            <td>
                                @php($value=0)
                                @foreach($assignedLeadRa as $al)
                                    @if($al->assignBy == $user->userid)

                                        <a href="#" class="highpossibility" onclick="leadassigned(this)"
                                           @if(isset($fromDate) && isset($toDate))
                                           data-date-from="{{$fromDate}}"
                                           data-date-to="{{$toDate}}"
                                           @endif
                                           data-user-id="{{$user->userid}}"
                                           data-user-name="{{$user->userName}}">{{$value=$al->userAssignedLead}}</a>
                                        @break
                                    @endif
                                @endforeach
                                @if($value==0)
                                    <a href="#" >0</a>
                                @endif
                            </td>
                            <td>
                                @php($value=0)
                                @foreach($highPosibilitiesThisWeekRa as $hpra)

                                    @if($hpra->minedBy == $user->userid)

                                        <a href="#" class="highpossibility" onclick="highpossibility(this)"
                                           @if(isset($fromDate) && isset($toDate))
                                           data-date-from="{{$fromDate}}"
                                           data-date-to="{{$toDate}}"
                                           @endif
                                           data-user-id="{{$user->userid}}"
                                           data-user-name="{{$user->userName}}">{{$value=$hpra->userHighPosibilities}}</a>
                                        @break
                                    @endif
                                @endforeach
                                @if($value==0)
                                    <a href="#" >0</a>
                                @endif
                            </td>
                            <td>
                                @php($value=0)
                                @foreach($leadMinedThisWeek as $lm)

                                    @if($lm->minedBy == $user->userid)

                                        <a href="#" class="highpossibility" onclick="leadmine(this)"
                                           @if(isset($fromDate) && isset($toDate))
                                           data-date-from="{{$fromDate}}"
                                           data-date-to="{{$toDate}}"
                                           @endif
                                           data-user-id="{{$user->userid}}"
                                           data-user-name="{{$user->userName}}">{{$value=$lm->userLeadMined}}</a>
                                        @break
                                    @endif
                                @endforeach
                                @if($value==0)
                                    <a href="#" >0</a>
                                @endif
                            </td>
                            <td>
                                <a href="#" class="highpossibility" onclick="testFileRa(this)"
                                   @if(isset($fromDate) && isset($toDate))
                                   data-date-from="{{$fromDate}}"
                                   data-date-to="{{$toDate}}"
                                   @endif
                                   data-user-id="{{$user->userid}}"
                                   data-user-name="{{$user->userName}}">{{$testLeadForRa->where('minedBy',$user->userid)->count()}}</a>
                            </td>
                        </tr>
                        </tbody>
                    @endforeach
                </table>
                </div>
                </div>

            @endif -->

            <!-- <div class="mt-5">
            <hr>
            <h4 align="center"><b>Comment</b></h4>
            <div class="table-responsive">
            <table class="table table-bordered table-striped valueReport">
                <thead>
                    <th>Name</th>
                    <th>Type</th>
                    <th>Comment</th>
                    <th>Date</th>
                </thead>
                <tbody>
                    @foreach($failReport as $r)
                        <tr>
                            <td>{{$r->firstName}}</td>
                            <td>{{$r->type}}</td>
                            <td>{{$r->comment}}</td>
                            <td>{{$r->created_at}}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            </div>
            </div> -->

        </div>
    </div>
@endsection
@section('foot-js')
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <script src="{{url('assets/plugins/datatables/jquery.dataTables.min.js')}}"></script>

    <script src="https://cdn.datatables.net/buttons/1.5.6/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.flash.min.js"></script>


    <script src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.html5.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.print.min.js"></script>

    <script>
        $( function() {
            $( "#fromdate" ).datepicker();
            $( "#todate" ).datepicker();
            $(".valueReport").DataTable();
        });

       function totalEmail(x){
           var id = $(x).data('user-id');
                   @if(isset($fromDate) && isset($toDate))
           var from=$(x).data('date-from');
           var to=$(x).data('date-to');
                   @endif
           var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
           var userName=$(x).data('user-name');
           $.ajax({
               type:'POST',
               url:'{{route('getEmailIndividual')}}',
               @if(isset($fromDate) && isset($toDate))
               data:{_token: CSRF_TOKEN,'userid':id,'fromdate':from,'todate':to},
               @else
               data:{_token: CSRF_TOKEN,'userid':id},
               @endif
               cache: false,
               success:function(data) {
//                    console.log(data);
                   $('#highPossibility').modal({show:true});
                   $('#label').html('Emailed');
                   $('#txtHint').html(data);
                   // $('#name').html(userName);
                   @if(Auth::user()->typeId ==10)
                   $('#myTable').DataTable({
                       dom:'Bfrtip',
                       buttons:[
                           'excel'
                       ]
                   });
                   @else
                   $('#myTable').DataTable();
                   @endif
               }
           });
       }

        function totalcoldEmail(x){
            var id = $(x).data('user-id');
            @if(isset($fromDate) && isset($toDate))
            var from=$(x).data('date-from');
            var to=$(x).data('date-to');
            @endif
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            var userName=$(x).data('user-name');
            $.ajax({
                type:'POST',
                url:'{{route('getcoldEmailIndividual')}}',
                @if(isset($fromDate) && isset($toDate))
                data:{_token: CSRF_TOKEN,'userid':id,'fromdate':from,'todate':to},
                @else
                data:{_token: CSRF_TOKEN,'userid':id},
                @endif
                cache: false,
                success:function(data) {
//                    console.log(data);
                    $('#highPossibility').modal({show:true});
                    $('#label').html('Emailed');
                    $('#txtHint').html(data);
                    $('#name').html(userName);
                    @if(Auth::user()->typeId ==10)
                    $('#myTable').DataTable({
                        dom:'Bfrtip',
                        buttons:[
                            'excel'
                        ]
                    });
                    @else
                    $('#myTable').DataTable();
                    @endif
                }
            });
        }

        function totalconversation(x){
            var id = $(x).data('user-id');
            @if(isset($fromDate) && isset($toDate))
            var from=$(x).data('date-from');
            var to=$(x).data('date-to');
            @endif
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            var userName=$(x).data('user-name');
            $.ajax({
                type:'POST',
                url:'{{route('getconversationIndividual')}}',
                @if(isset($fromDate) && isset($toDate))
                data:{_token: CSRF_TOKEN,'userid':id,'fromdate':from,'todate':to},
                @else
                data:{_token: CSRF_TOKEN,'userid':id},
                @endif
                cache: false,
                success:function(data) {
//                    console.log(data);
                    $('#highPossibility').modal({show:true});
                    $('#label').html('Emailed');
                    $('#txtHint').html(data);
                    $('#name').html(userName);
                    @if(Auth::user()->typeId ==10)
                    $('#myTable').DataTable({
                        dom:'Bfrtip',
                        buttons:[
                            'excel'
                        ]
                    });
                    @else
                    $('#myTable').DataTable();
                    @endif
                }
            });
        }


        function totalOther(x){
           var id = $(x).data('user-id');
                   @if(isset($fromDate) && isset($toDate))
           var from=$(x).data('date-from');
           var to=$(x).data('date-to');
                   @endif
           var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
           var userName=$(x).data('user-name');
           $.ajax({
               type:'POST',
               url:'{{route('getOtherIndividual')}}',
               @if(isset($fromDate) && isset($toDate))
               data:{_token: CSRF_TOKEN,'userid':id,'fromdate':from,'todate':to},
               @else
               data:{_token: CSRF_TOKEN,'userid':id},
               @endif
               cache: false,
               success:function(data) {
//                    console.log(data);
                   $('#highPossibility').modal({show:true});
                   $('#label').html('Other');
                   $('#txtHint').html(data);
                   $('#name').html(userName);
                   @if(Auth::user()->typeId ==10)
                   $('#myTable').DataTable({
                       dom:'Bfrtip',
                       buttons:[
                           'excel'
                       ]
                   });
                   @else
                   $('#myTable').DataTable();
                   @endif
               }
           });
       }

       function totalNotAvailable(x){
           var id = $(x).data('user-id');
                   @if(isset($fromDate) && isset($toDate))
           var from=$(x).data('date-from');
           var to=$(x).data('date-to');
                   @endif
           var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
           var userName=$(x).data('user-name');

           $.ajax({
               type:'POST',
               url:'{{route('getNotAvailableIndividual')}}',
               @if(isset($fromDate) && isset($toDate))
               data:{_token: CSRF_TOKEN,'userid':id,'fromdate':from,'todate':to},
               @else
               data:{_token: CSRF_TOKEN,'userid':id},
               @endif
               cache: false,
               success:function(data) {
//                    console.log(data);
                   $('#highPossibility').modal({show:true});
                   $('#label').html('Not Available');
                   $('#txtHint').html(data);
                   $('#name').html(userName);
                   @if(Auth::user()->typeId ==10)
                   $('#myTable').DataTable({
                       dom:'Bfrtip',
                       buttons:[
                           'excel'
                       ]
                   });
                   @else
                   $('#myTable').DataTable();
                   @endif
               }
           });

       }

       function totalgatekeeper(x){
           var id = $(x).data('user-id');
           @if(isset($fromDate) && isset($toDate))
           var from=$(x).data('date-from');
           var to=$(x).data('date-to');
           @endif
           var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
           var userName=$(x).data('user-name');
           $.ajax({
               type:'POST',
               url:'{{route('getgatekeeper')}}',
               @if(isset($fromDate) && isset($toDate))
               data:{_token: CSRF_TOKEN,'userid':id,'fromdate':from,'todate':to},
               @else
               data:{_token: CSRF_TOKEN,'userid':id},
               @endif
               cache: false,
               success:function(data) {
//                    console.log(data);
                   $('#highPossibility').modal({show:true});
                   $('#label').html('Not Available');
                   $('#txtHint').html(data);
                   $('#name').html(userName);
                   @if(Auth::user()->typeId ==10)
                   $('#myTable').DataTable({
                       dom:'Bfrtip',
                       buttons:[
                           'excel'
                       ]
                   });
                   @else
                   $('#myTable').DataTable();
                   @endif
               }
           });

        }


            function totalNotInterested(x) {
                var id = $(x).data('user-id');
                @if(isset($fromDate) && isset($toDate))
                var from = $(x).data('date-from');
                var to = $(x).data('date-to');
                @endif
                var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
                var userName = $(x).data('user-name');

                $.ajax({
                    type: 'POST',
                    url: '{{route('getNotInterestedIndividual')}}',
                    @if(isset($fromDate) && isset($toDate))
                    data: {_token: CSRF_TOKEN, 'userid': id, 'fromdate': from, 'todate': to},
                    @else
                    data: {_token: CSRF_TOKEN, 'userid': id},
                    @endif
                    cache: false,
                    success: function (data) {
//                    console.log(data);
                        $('#highPossibility').modal({show: true});
                        $('#label').html('Not Available');
                        $('#txtHint').html(data);
                        $('#name').html(userName);
                        @if(Auth::user()->typeId ==10)
                        $('#myTable').DataTable({
                            dom: 'Bfrtip',
                            buttons: [
                                'excel'
                            ]
                        });
                        @else
                        $('#myTable').DataTable();
                        @endif
                    }
                });


             }

        function highpossibility(x){
            var id = $(x).data('user-id');
                    @if(isset($fromDate) && isset($toDate))
            var from=$(x).data('date-from');
            var to=$(x).data('date-to');
                    @endif
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            var userName=$(x).data('user-name');
            $.ajax({
                type:'POST',
                url:'{{route('getHighPossibilityIndividual')}}',
                @if(isset($fromDate) && isset($toDate))
                data:{_token: CSRF_TOKEN,'userid':id,'fromdate':from,'todate':to},
                @else
                data:{_token: CSRF_TOKEN,'userid':id},
                @endif
                cache: false,
                success:function(data) {
//                    console.log(data);
                    $('#highPossibility').modal({show:true});
                    $('#label').html('High Possibility');
                    $('#txtHint').html(data);
                    $('#name').html(userName);
                    @if(Auth::user()->typeId ==10)
                    $('#myTable').DataTable({
                        dom:'Bfrtip',
                        buttons:[
                            'excel'
                        ]
                    });
                    @else
                    $('#myTable').DataTable();
                    @endif
                }
            });
        }


        function listenForDoubleClick(element) {

            element.contentEditable = true;
            setTimeout(function() {
                if (document.activeElement !== element) {
                    element.contentEditable = false;
                }
            }, 300);

        }

        function changeQuantity(x) {
            var id=$(x).data('panel-id');
            var rate=$(x).html();



            $.ajax({
                type:'POST',
                url:'{{route('update.newFile')}}',
                data:{_token: "{{csrf_token()}}",'id':id,'rate':rate},

                cache: false,
                success:function(data) {
                   // console.log(data);
                    location.reload();

                }
            });


        }

        function highpossibilityUn(x){
            var id = $(x).data('user-id');
                    @if(isset($fromDate) && isset($toDate))
            var from=$(x).data('date-from');
            var to=$(x).data('date-to');
                    @endif
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            var userName=$(x).data('user-name');
            $.ajax({
                type:'POST',
                url:'{{route('getHighPossibilityUnIndividual')}}',
                @if(isset($fromDate) && isset($toDate))
                data:{_token: CSRF_TOKEN,'userid':id,'fromdate':from,'todate':to},
                @else
                data:{_token: CSRF_TOKEN,'userid':id},
                @endif
                cache: false,
                success:function(data) {
//                    console.log(data);
                    $('#highPossibility').modal({show:true});
                    $('#label').html('High Possibility');
                    $('#txtHint').html(data);
                    $('#name').html(userName);
                    @if(Auth::user()->typeId ==10)
                    $('#myTable').DataTable({
                        dom:'Bfrtip',
                        buttons:[
                            'excel'
                        ]
                    });
                    @else
                    $('#myTable').DataTable();
                    @endif
                }
            });
        }
        function totalcall(x){
            var id = $(x).data('user-id');
                    @if(isset($fromDate) && isset($toDate))
            var from=$(x).data('date-from');
            var to=$(x).data('date-to');
                    @endif
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            var userName=$(x).data('user-name');
            $.ajax({
                type:'POST',
                url:'{{route('getCallIndividual')}}',
                @if(isset($fromDate) && isset($toDate))
                data:{_token: CSRF_TOKEN,'userid':id,'fromdate':from,'todate':to},
                @else
                data:{_token: CSRF_TOKEN,'userid':id},
                @endif
                cache: false,
                success:function(data) {
//                    console.log(data);
                    $('#highPossibility').modal({show:true});
                    $('#label').html('Total Call');
                    $('#txtHint').html(data);
                    $('#name').html(userName);
                    @if(Auth::user()->typeId ==10)
                    $('#myTable').DataTable({
                        dom:'Bfrtip',
                        buttons:[
                            'excel'
                        ]
                    });
                    @else
                    $('#myTable').DataTable();
                    @endif
                }
            });
        }
        function leadmine(x){
            var id = $(x).data('user-id');
                    @if(isset($fromDate) && isset($toDate))
            var from=$(x).data('date-from');
            var to=$(x).data('date-to');
                    @endif
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            var userName=$(x).data('user-name');
            $.ajax({
                type:'POST',
                url:'{{route('getMineIndividual')}}',
                @if(isset($fromDate) && isset($toDate))
                data:{_token: CSRF_TOKEN,'userid':id,'fromdate':from,'todate':to},
                @else
                data:{_token: CSRF_TOKEN,'userid':id},
                @endif
                cache: false,
                success:function(data) {
//                    console.log(data);
                    $('#highPossibility').modal({show:true});
                    $('#label').html('Lead Mined');
                    $('#txtHint').html(data);
                    $('#name').html(userName);
                    @if(Auth::user()->typeId ==10)
                    $('#myTable').DataTable({
                        dom:'Bfrtip',
                        buttons:[
                            'excel'
                        ]
                    });
                    @else
                    $('#myTable').DataTable();
                    @endif
                }
            });
        }

        function newFile(x) {
            var id = $(x).data('user-id');
                    @if(isset($fromDate) && isset($toDate))
            var from=$(x).data('date-from');
            var to=$(x).data('date-to');
                    @endif
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            var userName=$(x).data('user-name');
            $.ajax({
                type:'POST',
                url:'{{route('getFileCountIndividual')}}',
                @if(isset($fromDate) && isset($toDate))
                data:{_token: CSRF_TOKEN,'userid':id,'fromdate':from,'todate':to},
                @else
                data:{_token: CSRF_TOKEN,'userid':id},
                @endif
                cache: false,
                success:function(data) {
//                    console.log(data);
                    $('#highPossibility').modal({show:true});
                    $('#label').html('File Count');
                    $('#txtHint').html(data);
                    $('#name').html(userName);
                    @if(Auth::user()->typeId ==10)
                    $('#myTable').DataTable({
                        dom:'Bfrtip',
                        buttons:[
                            'excel'
                        ]
                    });
                    @else
                    $('#myTable').DataTable();
                    @endif
                }
            });

        }

        function leadassigned(x){
            var id = $(x).data('user-id');
                    @if(isset($fromDate) && isset($toDate))
            var from=$(x).data('date-from');
            var to=$(x).data('date-to');
                    @endif
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            var userName=$(x).data('user-name');
            $.ajax({
                type:'POST',
                url:'{{route('getAssignedLeadIndividual')}}',
                @if(isset($fromDate) && isset($toDate))
                data:{_token: CSRF_TOKEN,'userid':id,'fromdate':from,'todate':to},
                @else
                data:{_token: CSRF_TOKEN,'userid':id},
                @endif
                cache: false,
                success:function(data) {
//                    console.log(data);
                    $('#highPossibility').modal({show:true});
                    $('#label').html('Lead Assigned');
                    $('#txtHint').html(data);
                    $('#name').html(userName);
                    @if(Auth::user()->typeId ==10)
                    $('#myTable').DataTable({
                        dom:'Bfrtip',
                        buttons:[
                            'excel'
                        ]
                    });
                    @else
                    $('#myTable').DataTable();
                    @endif
                }
            });
        }
        function testlead(x){
            var id = $(x).data('user-id');
                    @if(isset($fromDate) && isset($toDate))
            var from=$(x).data('date-from');
            var to=$(x).data('date-to');
                    @endif
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            var userName=$(x).data('user-name');
            $.ajax({
                type:'POST',
                url:'{{route('getTestIndividual')}}',
                @if(isset($fromDate) && isset($toDate))
                data:{_token: CSRF_TOKEN,'userid':id,'fromdate':from,'todate':to},
                @else
                data:{_token: CSRF_TOKEN,'userid':id},
                @endif
                cache: false,
                success:function(data) {
//                    console.log(data);
                    $('#highPossibility').modal({show:true});
                    $('#label').html('Test Lead');
                    $('#txtHint').html(data);
                    $('#name').html(userName);
                    @if(Auth::user()->typeId ==10)
                    $('#myTable').DataTable({
                        dom:'Bfrtip',
                        buttons:[
                            'excel'
                        ]
                    });
                    @else
                    $('#myTable').DataTable();
                    @endif
                }
            });
        }
        function closelead(x){

            var id = $(x).data('user-id');
                    @if(isset($fromDate) && isset($toDate))
            var from=$(x).data('date-from');
            var to=$(x).data('date-to');
                    @endif
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            var userName=$(x).data('user-name');
            $.ajax({
                type:'POST',
                url:'{{route('getClosingIndividual')}}',
                @if(isset($fromDate) && isset($toDate))
                data:{_token: CSRF_TOKEN,'userid':id,'fromdate':from,'todate':to},
                @else
                data:{_token: CSRF_TOKEN,'userid':id},
                @endif
                cache: false,
                success:function(data) {
//                    console.log(data);
                    $('#highPossibility').modal({show:true});
                    $('#label').html('Close Lead');
                    $('#txtHint').html(data);
                    $('#name').html(userName);
                    @if(Auth::user()->typeId ==10)
                    $('#myTable').DataTable({
                        dom:'Bfrtip',
                        buttons:[
                            'excel'
                        ]
                    });
                    @else
                    $('#myTable').DataTable();
                    @endif
                }
            });
        }
        function getContactedIndividual(x){
            var id = $(x).data('user-id');
                    @if(isset($fromDate) && isset($toDate))
            var from=$(x).data('date-from');
            var to=$(x).data('date-to');
                    @endif
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            var userName=$(x).data('user-name');
            $.ajax({
                type:'POST',
                url:'{{route('getContactedIndividual')}}',
                @if(isset($fromDate) && isset($toDate))
                data:{_token: CSRF_TOKEN,'userid':id,'fromdate':from,'todate':to},
                @else
                data:{_token: CSRF_TOKEN,'userid':id},
                @endif
                cache: false,
                success:function(data) {
//                    console.log(data);
                    $('#highPossibility').modal({show:true});
                    $('#label').html('Contacted Leads');
                    $('#txtHint').html(data);
                    $('#name').html(userName);
                    @if(Auth::user()->typeId ==10)
                    $('#myTable').DataTable({
                        dom:'Bfrtip',
                        buttons:[
                            'excel'
                        ]
                    });
                    @else
                    $('#myTable').DataTable();
                    @endif
                }
            });
        }
        function getContactedUsaIndividual(x){
            var id = $(x).data('user-id');
                    @if(isset($fromDate) && isset($toDate))
            var from=$(x).data('date-from');
            var to=$(x).data('date-to');
                    @endif
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            var userName=$(x).data('user-name');
            $.ajax({
                type:'POST',
                url:'{{route('getContactedUsaIndividual')}}',
                @if(isset($fromDate) && isset($toDate))
                data:{_token: CSRF_TOKEN,'userid':id,'fromdate':from,'todate':to},
                @else
                data:{_token: CSRF_TOKEN,'userid':id},
                @endif
                cache: false,
                success:function(data) {
//                    console.log(data);
                    $('#highPossibility').modal({show:true});
                    $('#label').html('Contacted Leads');
                    $('#txtHint').html(data);
                    $('#name').html(userName);
                    @if(Auth::user()->typeId ==10)
                    $('#myTable').DataTable({
                        dom:'Bfrtip',
                        buttons:[
                            'excel'
                        ]
                    });
                    @else
                    $('#myTable').DataTable();
                    @endif
                }
            });
        }
        function followup(x){
            var id = $(x).data('user-id');
                    @if(isset($fromDate) && isset($toDate))
            var from=$(x).data('date-from');
            var to=$(x).data('date-to');
                    @endif
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            var userName=$(x).data('user-name');
            $.ajax({
                type:'POST',
                url:'{{route('getFollowupIndividual')}}',
                @if(isset($fromDate) && isset($toDate))
                data:{_token: CSRF_TOKEN,'userid':id,'fromdate':from,'todate':to},
                @else
                data:{_token: CSRF_TOKEN,'userid':id},
                @endif
                cache: false,
                success:function(data) {
//                    console.log(data);
                    $('#highPossibility').modal({show:true});
                    $('#label').html('Followup Lead');
                    $('#txtHint').html(data);
                    $('#name').html(userName);

                    @if(Auth::user()->typeId ==10)
                    $('#myTable').DataTable({
                        dom:'Bfrtip',
                        buttons:[
                            'excel'
                        ]
                    });
                    @else
                    $('#myTable').DataTable();
                    @endif


                }
            });
        }

        function newCall(x) {
            var id = $(x).data('user-id');
                    @if(isset($fromDate) && isset($toDate))
            var from=$(x).data('date-from');
            var to=$(x).data('date-to');
                    @endif
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            var userName=$(x).data('user-name');
            $.ajax({
                type:'POST',
                url:'{{route('getNewCallIndividual')}}',
                @if(isset($fromDate) && isset($toDate))
                data:{_token: CSRF_TOKEN,'userid':id,'fromdate':from,'todate':to},
                @else
                data:{_token: CSRF_TOKEN,'userid':id},
                @endif
                cache: false,
                success:function(data) {
                   // console.log(data);
                    $('#highPossibility').modal({show:true});
                    $('#label').html('New Call');
                    $('#txtHint').html(data);
                    $('#name').html(userName);
                     @if(Auth::user()->typeId ==10)
                    $('#myTable').DataTable({
                        dom:'Bfrtip',
                        buttons:[
                            'excel'
                        ]
                    });
                    @else
                    $('#myTable').DataTable();
                    @endif
                }
            });

        }


        function test(x) {
            id = $(x).data('changeid');
            var value=document.getElementById(id).value;
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            $.ajax({
                type:'POST',
                url:'{{route('approval')}}',
                data:{_token: CSRF_TOKEN,'changeId':id,'value':value},
                cache: false,
                success:function(data) {
                    console.log(data);
                }
            });
        }


        function testFileRa(x) {
            var id = $(x).data('user-id');
                    @if(isset($fromDate) && isset($toDate))
            var from=$(x).data('date-from');
            var to=$(x).data('date-to');
                    @endif
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            var userName=$(x).data('user-name');

            // alert(id);
            $.ajax({
                type:'POST',
                url:'{{route('getTestFileRaIndividual')}}',
                @if(isset($fromDate) && isset($toDate))
                data:{_token: CSRF_TOKEN,'userid':id,'fromdate':from,'todate':to},
                @else
                data:{_token: CSRF_TOKEN,'userid':id},
                @endif
                cache: false,
                success:function(data) {
                    // console.log(data);
                    $('#highPossibility').modal({show:true});
                    $('#label').html('Test Call');
                    $('#txtHint').html(data);
                    $('#name').html(userName);
                    @if(Auth::user()->typeId ==10)
                    $('#myTable').DataTable({
                        dom:'Bfrtip',
                        buttons:[
                            'excel'
                        ]
                    });
                    @else
                    $('#myTable').DataTable();
                    @endif
                }
            });
        }

</script>

@endsection
