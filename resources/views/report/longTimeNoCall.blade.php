@extends('main')



@section('content')


    <div class="card" style="padding:10px;">
        <div class="card-body">
        <h2 class="card-title" align="center"><b>Last Contacted Lead</b></h2>
        <h4 class="card-subtitle" align="center"><b>List of leads that are not touched in last 6 months or more but in someone's My Lead.</b></h4>

            <div class="table-responsive m-t-40">
                <table id="myTable" class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th width="5%">Id</th>
                        <th width="10%">Company Name</th>
                        <th width="8%">Category</th>
                        <th width="10%">website</th>
                        <th width="8%">Country</th>
                        <th width="8%">Contact Number</th>
                        <th width="7%">IPP</th>
                        <th width="10%">Last Comment</th>
                        <th width="7%">Marketer</th>
                        <th width="10%">Action</th>

                    </tr>
                    </thead>
                    <tbody>

                    @foreach($leads as $lead)
                        <tr>
                            <td >{{$lead->leadId}}</td>
                            <td >{{$lead->companyName}}</td>
                            <td >{{$lead->category->categoryName}}</td>
                            <td >{{$lead->website}}</td>
                            <td >{{$lead->country->countryName}}</td>
                            <td >{{$lead->contactNumber}}</td>
                                @if($lead->ippStatus == '0') 
                                    <td>No</td>
                                @else 
                                    <td>Yes</td>
                                @endif                                 
                            <td >{{ $lead->workprogress_created_at }}</td>
                            <td >{{$lead->firstName}} {{$lead->lastName}}
                            </td>
                            <td >
                                <!-- Trigger the modal with a button -->
                                <a href="#my_modal" data-toggle="modal" class="btn btn-success btn-sm"
                                   data-lead-id="{{$lead->leadId}}"
                                   data-lead-possibility="{{$lead->possibilityId}}"
                                   data-lead-probability="{{$lead->probabilityId}}">
                                    <i class="fa fa-phone" aria-hidden="true"></i></a>
                                <!-- Trigger the Edit modal with a button -->
                                <a href="#edit_modal" data-toggle="modal" class="btn btn-info btn-sm"
                                   data-lead-id="{{$lead->leadId}}"
                                   data-lead-name="{{$lead->companyName}}"
                                   data-lead-email="{{$lead->email}}"
                                   data-lead-number="{{$lead->contactNumber}}"
                                   data-lead-person="{{$lead->personName}}"
                                   data-lead-website="{{$lead->website}}"
                                   data-lead-mined="{{$lead->mined->firstName}}"
                                   data-lead-category="{{$lead->category->categoryId}}"
                                   data-lead-country="{{$lead->countryId}}"
                                   data-lead-designation="{{$lead->designation}}"
                                   data-lead-process="{{$lead->process}}"
                                   data-lead-frequency="{{$lead->frequency}}"
                                   data-lead-volume="{{$lead->volume}}"
                                   data-lead-employee="{{$lead->employee}}"
                                   data-lead-linkedin="{{$lead->linkedin}}"
                                   data-lead-founded="{{$lead->founded}}"
                                   data-lead-ipp="{{$lead->ippStatus}}"
                                   data-lead-comments="{{$lead->comments}}"

                                >
                                    <i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>

                                    <!-- Trigger the Activties modal with a button -->
                                    <a href="#lead_activities" data-toggle="modal" class="btn btn-warning btn-sm"
                                   data-lead-id="{{$lead->leadId}}"
                                   data-lead-possibility="{{$lead->possibilityId}}"
                                   data-lead-probability="{{$lead->probabilityId}}">
                                    <i class="fa fa-tasks" aria-hidden="true"></i></a>
                            </td>

                        </tr>

                    @endforeach

                    </tbody>
              
                </table>
            </div>

            <div class="col-md-5" style="float:left;">
                <form method="POST" action="{{ route('exportLongTimeNoCall') }}">
                    {{ csrf_field() }}
                    <button class="btn btn-primary" type="submit">Export The List</button><br>
                </form>
            </div>

        </div>
    </div>









   <!-- Edit Modal -->
   <div class="modal" id="edit_modal" style="">
        <div class="modal-dialog" style="max-width: 60%;">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span
                                aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title" name="modal-title">Edit Lead</h4>
                </div>
                <div class="modal-body">
                <form  method="post" action="{{route('leadUpdate')}}">
                        {{csrf_field()}}
                        <div class="row">
                            <!-- <div class="col-md-12" align="center">
                                <label><b> Mined By: </b></label>  <div class="mined" id="mined"></div><br>
                            </div> -->

                            <div class="col-md-3">
                                <input type="hidden" name="leadId">
                                <label><b>Company:</b></label>
                                <input type="text" class="form-control" name="companyName" value="">
                            </div>

                            <div class="col-md-3">
                                <label><b>Phone:</b></label>
                                <input type="text" class="form-control" name="number" value="">
                            </div>

                            <div class="col-md-2">
                                <label><b>Category:</b></label>
                                <select class="form-control"  name="category" id="category">
                                    <option value="">Please Select</option>
                                    @foreach($categories as $category)
                                        <option value="{{$category->categoryId}}">{{$category->categoryName}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-2">
                                <label><b>Country:</b></label>
                                <select class="form-control"  name="country" id="country">
                                    @foreach($country as $c)
                                        <option value="{{$c->countryId}}">{{$c->countryName}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-2">
                                <label><b>Founded:</b></label>
                                <input type="text" class="form-control" name="founded" value="">
                                <br><br>
                            </div>



                            <div class="col-md-3">
                                <label><b>Website:</b></label>
                                <input type="text" class="form-control" name="website" value="">
                            </div>

                            <div class="col-md-3">
                                <label><b>Current Process:</b></label>
                                <input type="text" class="form-control" name="process" value="">
                                <br><br>
                            </div>

                            <div class="col-md-2">
                                <label><b>File Volume:</b></label>
                                <input type="text" class="form-control" name="volume" value="">
                            </div>

                            <div class="col-md-2">
                                <label><b>Frequency:</b></label>
                                <input type="text" class="form-control" name="frequency" value="">
                            </div>

                            <div class="col-md-2">
                                <label><b>Employee Size:</b></label>
                                <input type="text" class="form-control" name="employee" value="">
                                <br><br>
                            </div>




                            <div class="col-md-4">
                                <label><b>Contact Person:</b></label>
                                <input type="text" class="form-control" name="personName" value="">
                            </div>

                            <div class="col-md-4">
                                <label><b>Designation:</b></label>
                                <input type="text" class="form-control" name="designation" value="">
                            </div>

                            <div class="col-md-4">
                                <label><b>Email:</b></label>
                                <input type="email" class="form-control" name="email" value="">
                                <br><br>
                            </div>




                            <div class="col-md-6">
                                <label><b>Extra Information:</b></label>
                                <textarea class="form-control" id="comments" name="comments"></textarea>
                            </div>

                            <div class="col-md-3">
                                <label><b>LinkedIn Profile:</b></label>
                                <input type="text" class="form-control" name="linkedin" value="">
                            </div>

                            <div class="col-md-3">
                                <label ><b>Is it your IPP?</b></label>
                                <select class="form-control" name="ippStatus"  id="ippStatus">
                                    <!-- <option value="">(select one)</option> -->
                                    <option value="0">No</option>
                                    <option value="1">Yes</option>
                                </select>
                            </div>


                            
                            <div class="col-md-6">
                                <button class="btn btn-success" type="submit">Update</button>
                            </div>
                        </div>
                    </form>

                    <br><br>

                    @if(Request::url()!=route('highPossibility'))
                        <form method="post" action="{{route('leaveLead')}}">
                            <div class="row">
                                {{csrf_field()}}

                                <div class=" form-group col-md-6">
                                    <input type="hidden" name="leadId">
                                    <label>Status:</label>
                                    <select class="form-control" name="Status" id="Status" required>
                                        <option value="">Please Select</option>
                                        @foreach($status as $s)
                                            <option value="{{$s->statusId}}">{{$s->statusName}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class=" form-group col-md-6" style="margin-top: 3.2%">
                                    <button class="btn btn-danger" type="submit"
                                            onclick="return confirm('Are you sure you want to leave this Lead?')">Leave
                                    </button>
                                </div>
                            </div>

                        </form>
                    @endif
                </div>
                <div class="modal-footer">
                    <div class="mineIdDate" id="mineIdDate" align="left"></div> &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>











    <!-- Call Modal -->
    <div class="modal" id="my_modal" style="">
        <div class="modal-dialog" style="max-width: 60%;">

            <form class="modal-content" action="{{route('storeReport')}}" method="post">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title" name="modal-title">Calling Report</h4>
                </div>
                <div class="modal-body" >
                    {{csrf_field()}}
                    <input type="hidden" name="leadId">

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label ><b>Calling Report : </b></label>
                                <select class="form-control" name="report" required>
                                    <option value=""><b>(select one)</b></option>

                                    @foreach($callReports as $report)
                                        <option value="{{$report->callingReportId}}">{{$report->report}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label ><b>Progress : </b></label>
                                <select class="form-control" name="progress" >
                                    <option value=""><b>(select one)</b></option>
                                    <option value="Test Job">Test Job</option>
                                    <option value="Closing">Closing</option>
                                </select>
                                <br>
                            </div>

                            <div class="form-group">
                                <label class=""><b>Follow Up Date : </b> <span id="exceed" style="color:red;display: none"><i>Already Exceed the limit 10</i></span></label>
                                <input class="form-control changedate" id="datepicker"  rows="3" name="followup" placeholder="pick Date">
                            </div>


                            <div class="form-group">
                                <label class=""><b>Possibility : </b></label>
                                <select class="form-control"  name="possibility" id="possibility">
                                    @foreach($possibilities as $p)
                                        <option value="{{$p->possibilityId}}">{{$p->possibilityName}}</option>
                                    @endforeach

                                </select>
                            </div>


                            <div class="form-group">
                                <label class=""><b>Comment : </b></label>
                                <textarea class="form-control" rows="3" name="comment" required></textarea>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <ul class="list-group" style="margin: 10px; "><br>
                                <div  style="height: 460px; width: 100%; overflow-y: scroll; border: solid black 1px;" id="comment">

                                </div>
                            </ul>
                            <ul>
                                <b>Call Statistics per marketer</b>
                                <p>Here you will see who reached out to this company for how many times.</p>
                                <div id="counter"></div>
                            </ul>
                            
                        </div>

                        <div class="col-md-12"><br>
                            <button class="btn btn-success">Submit</button>
                        </div>
                    </div>


                </div>
                <div class="modal-footer">
                    <div id="latestFollowups"></div>

                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>


   <!--ALL Activities-->
    
   <div class="modal" id="lead_activities" >
        <div class="modal-dialog" style="max-width: 60%">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title" name="modal-title">All Activities</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-4">
                    <b>Company Name:</b>
                    <input type="text" name="companyName" readonly>
                        </div>

                        <div class="col-md-6">
                        <div class="form-group">
                        <label class=""><b>Activities : </b></label>

                                <ul class="list-group" style="margin: 10px; "><br>
                                    <div  style="height: 460px; width: 100%; overflow-y: scroll; border: solid black 1px;" id="activity">

                                    </div>
                                </ul>
                            </div>

                        </div>

                    </div>
                </div>

                <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div></div>
            </div>
        </div>




@endsection

@section('foot-js')

    <script src="{{url('assets/plugins/datatables/jquery.dataTables.min.js')}}"></script>

    <script src="{{url('cdn.datatables.net/buttons/1.2.2/js/dataTables.buttons.min.js')}}"></script>
    <script src="{{url('cdn.datatables.net/buttons/1.2.2/js/buttons.flash.min.js')}}"></script>


    <script src="{{url('cdn.datatables.net/buttons/1.2.2/js/buttons.html5.min.js')}}"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}" />



    <script>

        //for Edit modal

        $('#edit_modal').on('show.bs.modal', function (e) {

            //get data-id attribute of the clicked element
            var leadId = $(e.relatedTarget).data('lead-id');
            var leadName = $(e.relatedTarget).data('lead-name');
            var email = $(e.relatedTarget).data('lead-email');
            var number = $(e.relatedTarget).data('lead-number');
            var personName = $(e.relatedTarget).data('lead-person');
            var website = $(e.relatedTarget).data('lead-website');
            var linkedin=$(e.relatedTarget).data('lead-linkedin');
            var minedBy=$(e.relatedTarget).data('lead-mined');
            var category=$(e.relatedTarget).data('lead-category');
            var designation=$(e.relatedTarget).data('lead-designation');
            var country=$(e.relatedTarget).data('lead-country');
            var founded=$(e.relatedTarget).data('lead-founded');
            var employee=$(e.relatedTarget).data('lead-employee');
            var volume=$(e.relatedTarget).data('lead-volume');
            var frequency=$(e.relatedTarget).data('lead-frequency');
            var process=$(e.relatedTarget).data('lead-process');
            var ippStatus=$(e.relatedTarget).data('lead-ipp');
            var createdAt=$(e.relatedTarget).data('lead-created');
            var comments=$(e.relatedTarget).data('lead-comments');
            //populate the textbox
            $('#category').val(category);
            // $('div.mined').text(minedBy);
            // $('div.mined').text(minedBy+' _'+createdAt);
            $('div.mineIdDate').text(leadId+' was mined by '+minedBy+' at '+createdAt);
            $('#country').val(country);
//            $(e.currentTarget).find('input[name="minedBy"]').val(minedBy);
            $(e.currentTarget).find('input[name="leadId"]').val(leadId);
            $(e.currentTarget).find('input[name="companyName"]').val(leadName);
            $(e.currentTarget).find('input[name="email"]').val(email);
            $(e.currentTarget).find('input[name="number"]').val(number);
            $(e.currentTarget).find('input[name="personName"]').val(personName);
            $(e.currentTarget).find('input[name="website"]').val(website);
            $(e.currentTarget).find('input[name="linkedin"]').val(linkedin);
            $(e.currentTarget).find('input[name="designation"]').val(designation);
            $(e.currentTarget).find('input[name="founded"]').val(founded);
            $(e.currentTarget).find('input[name="employee"]').val(employee);
            $(e.currentTarget).find('input[name="volume"]').val(volume);
            $(e.currentTarget).find('input[name="frequency"]').val(frequency);
            $(e.currentTarget).find('input[name="process"]').val(process);
            $(e.currentTarget).find('#ippStatus').val(ippStatus);

            $('#comments').val(comments);
            // $(e.currentTarget).find('#leave').attr('href', '/lead/leave/'+leadId);

            @if(Auth::user()->typeId == 4 || Auth::user()->typeId == 5 )

            $(e.currentTarget).find('input[name="companyName"]').attr('readonly', true);
           // $(e.currentTarget).find('input[name="website"]').attr('readonly', true);

            @endif


        });


        $( function() {
            $( "#datepicker" ).datepicker();
        } );





        //for Call Modal

        $('#my_modal').on('show.bs.modal', function(e) {

            //get data-id attribute of the clicked element
            var leadId = $(e.relatedTarget).data('lead-id');
            var possibility=$(e.relatedTarget).data('lead-possibility');


            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            $(e.currentTarget).find('input[name="leadId"]').val(leadId);



            $('#possibility').val(possibility);
            //$(e.currentTarget).find('input[name="possibility"]').val(possibility);

            // $.ajax({
            //     type : 'post' ,
            //     url : '{{route('getComments')}}',
            //     data : {_token: CSRF_TOKEN,'leadId':leadId} ,
            //     success : function(data){
            //         $('#comment').html(data);
            //         $("#comment").scrollTop($("#comment")[0].scrollHeight);
            //     }
            // });

            $.ajax({
                type: 'post',
                url: '{{ route('getComments') }}',
                data: {_token: CSRF_TOKEN, 'leadId': leadId},
                success: function(data) {
                    $('#comment').html(data.comments);
                    $("#comment").scrollTop($("#comment")[0].scrollHeight);

                    var counterHtml = '';

                    // Loop through the counter data
                    $.each(data.counter, function(index, counter) {
                        counterHtml += '<div><strong>' + counter.userId + '</strong> tried <strong>' + counter.userCounter + '</strong> times</div>';
                    });

                    // Set the counter HTML to the counter div
                    $('#counter').html(counterHtml);

                    var latestFollowupsHtml = '';

                    // Loop through the latest follow-up data
                    $.each(data.latestFollowups, function(index, followup) {
                        latestFollowupsHtml += '<div>';
                        latestFollowupsHtml += 'Lead ID: ' + followup.leadId + ' || ';
                        latestFollowupsHtml += 'Latest Follow-up: ' + followup.lastFollowUpDate;
                        latestFollowupsHtml += '</div>';
                    });

                    // Set the latest follow-up HTML to the latestFollowups div
                    $('#latestFollowups').html(latestFollowupsHtml);
                }
            });

            
            $.ajax({
                type: 'post',
                url: '{{ route('getLatestFollowup') }}',
                data: {_token: CSRF_TOKEN, 'leadId': leadId},
                success: function(data) {
                    var latestFollowupsHtml = '';

                    // Loop through the latest follow-up data
                    $.each(data.latestFollowups, function(index, followup) {
                        latestFollowupsHtml += '<div>';
                        latestFollowupsHtml += 'Lead ID: ' + followup.leadId + ' || ';
                        latestFollowupsHtml += 'Latest Follow-up: ' + followup.lastFollowUpDate;
                        latestFollowupsHtml += '</div>';
                    });

                    // Set the latest follow-up HTML to the latestFollowups div
                    $('#latestFollowups').html(latestFollowupsHtml);
                }
            });


        });        



        //        check followup date count

        $('.changedate').on('change',function(){
            var currentdate = $('.changedate').val();
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            $.ajax({
                type:'post',
                url:'{{route('followupCheck')}}',
                data:{_token: CSRF_TOKEN,'currentdate':currentdate},
                success : function(data)
                {
                    if(data >= 10)
                    {
                        document.getElementById('exceed').style.display="inline";
                    }
                    else
                    {
                        document.getElementById('exceed').style.display="none";
                    }
                }
            });
        });


        $(document).ready(function() {
            $('#myTable').DataTable({
                "processing": true,
                stateSave: true,
            });

        });


       $('#lead_activities').on('show.bs.modal', function(e) {

            var leadId = $(e.relatedTarget).data('lead-id');
            var leadName = $(e.relatedTarget).data('lead-name');
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

            $(e.currentTarget).find('input[name="companyName"]').val(leadName);

            $.ajax({
                type : 'post' ,
                url : '{{route('getActivities')}}',
                data : {_token: CSRF_TOKEN,'leadId':leadId} ,
                success : function(data){

                    $("#activity").html(data);
                    $("#activity").scrollTop($("#activity")[0].scrollHeight);
                }
            });

        });
        




    </script>


@endsection