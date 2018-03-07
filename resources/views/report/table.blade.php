@extends('main')



@section('content')



    <!--High Possibility Modal -->
    <div class="modal fade" id="highPossibility" role="dialog">
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
                <input type="text" placeholder=" From" id="fromdate" name="fromDate" style="border-radius: 50px;" required>
                <input type="text" placeholder=" To" id="todate" name="toDate" style="border-radius: 50px;" required>
                <button type="submit" class="btn btn-success">Search</button>

            </form>
            <div class="card-body">
        <h2>Report</h2>
         @if(isset($fromDate) && isset($toDate))
                    <p>Report From {{$fromDate}} to {{$toDate}}</p>
                @else
        <p>Weekly report</p>
         @endif
        <table class="table">
            <thead>
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
            </thead>
            <tbody>
            @foreach($report as $r)

            @if($r->type !=4)


                <tr>
                <td>{{$r->userName}}</td>
                <td><a href="#" class="highpossibility" onclick="totalcall(this)"
                       @if(isset($fromDate) && isset($toDate))
                       data-date-from="{{$fromDate}}"
                       data-date-to="{{$toDate}}"
                       @endif
                       data-user-id="{{$r->id}}"
                       data-user-name="{{$r->userName}}"
                    >{{$r->called}}</a></td>

                <td><a href="#" class="highpossibility" onclick="followup(this)"
                       @if(isset($fromDate) && isset($toDate))
                       data-date-from="{{$fromDate}}"
                       data-date-to="{{$toDate}}"
                       @endif
                       data-user-id="{{$r->id}}"
                       data-user-name="{{$r->userName}}"
                    >{{$r->followupThisWeek}}</a>
                </td>
                <td><a href="#" class="highpossibility" onclick="getContactedIndividual(this)"
                       @if(isset($fromDate) && isset($toDate))
                       data-date-from="{{$fromDate}}"
                       data-date-to="{{$toDate}}"
                       @endif
                       data-user-id="{{$r->id}}"
                       data-user-name="{{$r->userName}}"
                    >
                        {{$r->contacted}}
                    </a></td>
                <td><a href="#" class="highpossibility" onclick="leadassigned(this)"
                       @if(isset($fromDate) && isset($toDate))
                       data-date-from="{{$fromDate}}"
                       data-date-to="{{$toDate}}"
                       @endif
                       data-user-id="{{$r->id}}"
                       data-user-name="{{$r->userName}}">{{$r->assignedLead}}</a>
                </td>
                <td><a href="#" class="highpossibility" onclick="highpossibility(this)"
                            @if(isset($fromDate) && isset($toDate))
                            data-date-from="{{$fromDate}}"
                            data-date-to="{{$toDate}}"
                            @endif
                            data-user-id="{{$r->id}}"
                            data-user-name="{{$r->userName}}">{{$r->highPosibilities}}
                    </a>
                </td>
                <td><a href="#" class="highpossibility" onclick="testlead(this)"
                       @if(isset($fromDate) && isset($toDate))
                       data-date-from="{{$fromDate}}"
                       data-date-to="{{$toDate}}"
                       @endif
                       data-user-id="{{$r->id}}"
                       data-user-name="{{$r->userName}}"
                    >{{$r->test}}</a>
                </td>

                <td><a href="#" class="highpossibility" onclick="closelead(this)"
                       @if(isset($fromDate) && isset($toDate))
                       data-date-from="{{$fromDate}}"
                       data-date-to="{{$toDate}}"
                       @endif
                       data-user-id="{{$r->id}}"
                       data-user-name="{{$r->userName}}">
                        {{$r->closing}}
                    </a></td>
                <td><a href="#" class="highpossibility" onclick="leadmine(this)"
                       @if(isset($fromDate) && isset($toDate))
                       data-date-from="{{$fromDate}}"
                       data-date-to="{{$toDate}}"
                       @endif
                       data-user-id="{{$r->id}}"
                       data-user-name="{{$r->userName}}">{{$r->leadMined}}</a>
                </td>
            </tr>



            @endif

                @endforeach
            </tbody>
        </table>


<br><br>


                <table class="table">
                    <thead>
                    <tr>
                        <th>Name</th>
                        <th>Assigned Lead</th>
                        <th>High Possibility</th>
                        <th>Lead Mined</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($report as $r)

                        @if($r->type ==4)


                            <tr>
                                <td>{{$r->userName}}</td>


                                <td><a href="#" class="highpossibility" onclick="leadassigned(this)"
                                       @if(isset($fromDate) && isset($toDate))
                                       data-date-from="{{$fromDate}}"
                                       data-date-to="{{$toDate}}"
                                       @endif
                                       data-user-id="{{$r->id}}"
                                       data-user-name="{{$r->userName}}">{{$r->assignedLead}}</a>
                                </td>
                                <td><a href="#" class="highpossibility" onclick="highpossibility(this)"
                                       @if(isset($fromDate) && isset($toDate))
                                       data-date-from="{{$fromDate}}"
                                       data-date-to="{{$toDate}}"
                                       @endif
                                       data-user-id="{{$r->id}}"
                                       data-user-name="{{$r->userName}}">{{$r->highPosibilities}}
                                    </a>
                                </td>

                                <td><a href="#" class="highpossibility" onclick="leadmine(this)"
                                       @if(isset($fromDate) && isset($toDate))
                                       data-date-from="{{$fromDate}}"
                                       data-date-to="{{$toDate}}"
                                       @endif
                                       data-user-id="{{$r->id}}"
                                       data-user-name="{{$r->userName}}">{{$r->leadMined}}</a>
                                </td>
                            </tr>



                        @endif

                    @endforeach
                    </tbody>
                </table>





            </div></div>

@endsection

@section('foot-js')
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <script src="{{url('assets/plugins/datatables/jquery.dataTables.min.js')}}"></script>

    <script src="{{url('cdn.datatables.net/buttons/1.2.2/js/dataTables.buttons.min.js')}}"></script>
    <script src="{{url('cdn.datatables.net/buttons/1.2.2/js/buttons.flash.min.js')}}"></script>


    <script src="{{url('cdn.datatables.net/buttons/1.2.2/js/buttons.html5.min.js')}}"></script>

    <script>
        $( function() {
            $( "#fromdate" ).datepicker();
            $( "#todate" ).datepicker();
        } );



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
                    $('#myTable').DataTable();


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
                    $('#myTable').DataTable();

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
                    $('#myTable').DataTable();

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
                    $('#myTable').DataTable();

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
                    $('#label').html('Lead Assigned');
                    $('#txtHint').html(data);
                    $('#name').html(userName);
                    $('#myTable').DataTable();

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
                    $('#label').html('Lead Assigned');
                    $('#txtHint').html(data);
                    $('#name').html(userName);
                    $('#myTable').DataTable();

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
                    $('#myTable').DataTable();

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
                    $('#label').html('Lead Assigned');
                    $('#txtHint').html(data);
                    $('#name').html(userName);
                    $('#myTable').DataTable();

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





    </script>




    @endsection