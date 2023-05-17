@extends('main')

@section('header')
    <link rel="stylesheet" href="{{url('css/jconfirm.css')}}">
@endsection


    @section('content')

    <div class="card" style="padding:10px;">
        <div class="card-body">
            @if(Request::url()==route('assignedLeads'))
                <h2 class="card-title" align="center"><b>My List</b></h2>
            @endif

            @if(Request::url()==route('contacted'))
                <h2 class="card-title" align="center"><b>My Lead </b></h2>
            @endif
                <div class="form-group col-md-2" style="float: right">
                    <label>Lead Status</label>
                    <select id="statuschanges" class="form-control" onchange="leadstatussearch()">

                        <option value="">select lead status</option>
                       @foreach($callReports as $cr)
                        <option value="{{$cr->callingReportId }}">{{$cr->report}}</option>
                        @endforeach
                        <option value="newlead">New Lead</option>

                    </select>
                </div>
                <div class="form-group col-md-2" style="float: right">
                    <label>Mined by</label>
                    <select id="minedby" class="form-control" name="minedby" onchange="mindbychanged()">

                        <option value="">select Mined By</option>
                        @foreach($usersforminded as $urs)
                            <option value="{{$urs->id }}">{{$urs->firstName}} {{$urs->lastName}}</option>
                        @endforeach


                    </select>
                </div>
            <div class="table-responsive m-t-40">

                <table id="myTable" class="table table-bordered table-striped" cellspacing="0" width="100%">
                    <thead>
                    <tr>
                        <th width="2%">Select</th>
                        <th width="5%">Id</th>
                        <th width="8%">Company</th>
                        <th width="8%">Category</th>
                        <th width="5%">Website</th>
                        <th width="8%">Possi</th>
                        <th width="8%">Proba</th>
                        <th width="8%">Country</th>
                        <th width="8%">KDM</th>
                        <th width="8%">Phone</th>
                        <th width="8%">Volume</th>
                        <th width="5%">Process</th>
                        <th width="5%">Frequency</th>
                        <th width="5%">Status</th>
                        <th width="8%">Mined By</th>
                        <th width="8%">Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    </tbody>

                </table>
            </div>

            <input type="checkbox" id="selectall" onClick="selectAll(this)" /><b>Select All</b>


            <div class="row">



            <div class="form-group col-md-8">

                {{--<div class="form-group col-md-5">--}}
                <label ><b>Select Status:</b></label>
                <select class="form-control"  name="status" id="otherCatches" style="width: 30%">
                    <option value="">select</option>
                    @foreach($outstatus as $s)
                        <option value="{{$s->statusId}}">{{$s->statusName}} </option>

                    @endforeach


                </select>
            </div>


            <div class="form-group col-md-4">

                {{--<div class="form-group col-md-5">--}}
                <label ><b>Assign To:</b></label>
                <select class="form-control"  name="assignTo" id="otherCatches2" style="width: 50%">
                    <option value="">select</option>
                    @foreach($assignto as $user)
                        <option value="{{$user->id}}">{{$user->firstName}} {{$user->lastName}}</option>

                    @endforeach

                </select>
            </div>
        </div>

            <input type="hidden" class="form-control" id="inp" name="leadId">




        </div>
    </div>



    <!-- Edit Modal -->
    <div class="modal" id="edit_modal" style="">
        <div class="modal-dialog" style="max-width: 60%;">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
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
                    <form method="post" action="{{route('leaveLead')}}" id="leaveLeadForm">
                        <div class="row">
                            {{csrf_field()}}

                            <input type="hidden" name="leadId">
                            <div class="form-group col-md-4">

                                <label><b>Status:</b> Select status and cick Leave button</label>
                                <select class="form-control"  name="Status" id="Status" onchange="changeLeadStatus(this)" required>
                                    <option value="">Please Select</option>
                                    @foreach($status as $s)
                                        <option value="{{$s->statusId}}">{{$s->statusName}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-md-4" id="newFileField"></div>
                            <div class="form-group col-md-4" style="margin-top: 3.2%">
                                <button class="btn btn-danger" type="submit" onclick="return confirm('Are you sure you want to leave this Lead?')">Leave</button>
                            </div>
                        </div>

                    </form>
                </div>
                <div class="modal-footer">
                    <div class="mineIdDate" id="mineIdDate" align="left"></div> &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
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




    <!-- Call Modal -->

    <div class="modal" id="my_modal" style="">
        <div class="modal-dialog" style="max-width: 60%;">
            <style>
                th.ui-datepicker-week-end,
                td.ui-datepicker-week-end {
                    display: none;
                }
            </style>
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
                                <label ><b>Call Status : </b></label>
                                <select class="form-control" id="reporttest" name="report" required>
                                    <option value=""><b>(select one)</b></option>

                                    {{--@foreach($callReports as $report)--}}

                                    {{-- @if($workprocess->contains('callingReport' , $report->callingReportId))--}}

                                    {{--<option value="{{$report->callingReportId}}">{{$report->report}}</option>--}}

                                    {{--@else--}}


                                    {{--@endif--}}

                                    {{--@endforeach--}}

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

                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label class=""><b>Follow Up Date : </b></label>
                                    <input class="form-control changedate" id="datepicker"  rows="3" name="followup" placeholder="pick Date">
                                </div>

                                <div class="form-group col-md-6">
                                    <label class=""><b>Time: </b> </label>
                                    <input class="form-control" name="time" placeholder="pick Time">
                                </div>
                                <div class="col-md-12" style="text-align: center; font-size: 14px; font-weight: bold;">
                                    <span id="exceed" style="color: red; display: none"><i>Already Exceed the limit 10</i></span>
                                    <span id="total" style="color: #00aa88; display: none"></span>
                                </div>
                            </div>


                            <div class="col-md-12" style="text-align: center; font-weight: bold;">
                                <span id="follow-show" style="color:grey;"><i></i></span>
                            </div>

                            {{--<div class="col-md-4">--}}
                            {{--<label><b>Follow up Date:</b></label>--}}
                            {{--<input type="text" class="form-control" id="follow-show" value="" readonly>--}}
                            {{--</div>--}}

                            <div class="form-group">
                                <label class=""><b>Possibility : </b></label>
                                <select class="form-control"  name="possibility" id="possibility">
                                    @foreach($possibilities as $p)
                                    <option value="{{$p->possibilityId}}">{{$p->possibilityName}}</option>
                                    @endforeach
                                    </select>
                            </div>


                            <div class="form-group">
                                <label class=""><b>Closing Probability : </b></label>
                                <select class="form-control"  name="probability" id="probability">
                                    <option value=""><b>(select one)</b></option>
                                    @foreach($probabilities as $p)
                                        <option value="{{$p->probabilityId}}">{{$p->probabilityName}}</option>
                                    @endforeach

                                </select>
                            </div>


                            <div class="form-group">
                                <label class=""><b>Comment* </b></label>
                                <textarea class="form-control" rows="3" name="comment" required></textarea>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <ul class="list-group" style="margin: 10px; "><br>
                                <div  style="height: 460px; width: 100%; overflow-y: scroll; border: solid black 1px;" id="comment">

                                </div>
                            </ul>
                        </div>

                        <div class="col-md-12"><br>
                            <button class="btn btn-success">Submit</button>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>



@endsection

@section('foot-js')

    <script src="{{url('assets/plugins/datatables/jquery.dataTables.min.js')}}"></script>

    <script src="{{url('cdn.datatables.net/buttons/1.2.2/js/dataTables.buttons.min.js')}}"></script>
    <script src="{{url('cdn.datatables.net/buttons/1.2.2/js/buttons.flash.min.js')}}"></script>


    <script src="{{url('cdn.datatables.net/buttons/1.2.2/js/buttons.html5.min.js')}}"></script>

    <script src="{{url('js/jconfirm.js')}}"></script>

    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js" integrity="sha512-AA1Bzp5Q0K1KanKKmvN/4d3IRKVlv9PYgwFPvm32nPO6QS8yH1HO7LbgB1pgiOxPtfeg5zEn2ba64MUcqJx6CA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>






    <script>




function selectAll(source) {
            checkboxes = document.getElementsByName('checkboxvar[]');
            for(var i in checkboxes)
                checkboxes[i].checked = source.checked;
        }




        $("#otherCatches").change(function() {




            var chkArray = [];
            var status=$(this).val();
            $('.checkboxvar:checked').each(function (i) {

                chkArray[i] = $(this).val();
            });
            //alert(chkArray)
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            // $("#inp").val(JSON.stringify(chkArray));
            // $( "#assign-form" ).submit();
            jQuery('input:checkbox:checked').parents("tr").remove();
            $(this).prop('selectedIndex',0);





            $.ajax({
                type : 'post' ,
                url : '{{route('contactedStatus')}}',
                data : {_token: CSRF_TOKEN,'leadId':chkArray,'status':status} ,
                beforeSend:function(){
                 return confirm("Are you sure?");
                },
                success : function(data){
                    console.log(data);
                    if(data == 'true'){
                        // $('#myTable').load(document.URL +  ' #myTable');
//                        $.alert({
//                            title: 'Success!',
//                            content: 'successfully assigned!',
//                        });
                        $('#alert').html(' <strong>Success!</strong> Status Changed');
                        $('#alert').show();

                    }

                }
            });

        });


        //for Edit modal
        function changeLeadStatus(x){
            var value=$(x).val();
            if(value == 6){
                // alert(value);
                $('#newFileField').html('<label><b>New Files* :</b></labe><input type="number" class="form-control" name="newFile" required>');
            }
            else {
                $('#newFileField').html('');
            }
        }

        $('#edit_modal').on('show.bs.modal', function(e) {
//            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
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
            // alert(createdAt);
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
            //$(e.currentTarget).find('input[name="website"]').attr('readonly', true);
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
            var probability=$(e.relatedTarget).data('lead-probability');
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            $(e.currentTarget).find('input[name="leadId"]').val(leadId);
            $('#possibility').val(possibility);
            $('#probability').val(probability);
            //$(e.currentTarget).find('input[name="possibility"]').val(possibility);
            $.ajax({
                type : 'post' ,
                url : '{{route('getComments')}}',
                data : {_token: CSRF_TOKEN,'leadId':leadId} ,
                success : function(data){
                    $('#comment').html(data);
                    $("#comment").scrollTop($("#comment")[0].scrollHeight);
                }
            });
            $.ajax({
                type : 'post' ,
                url : '{{route('getCallingReport')}}',
                data : {_token: CSRF_TOKEN,'leadId':leadId} ,
                success : function(data){
                    document.getElementById("reporttest").innerHTML = data;
                }
            });
            $.ajax({
                type : 'post',
                url : '{{route('editcontactmodalshow')}}',
                data : {_token:CSRF_TOKEN,'leadId':leadId} ,
                success : function(data){
                    // $('#txtHint').html(data);
                    console.log(data);
//                    $('#follow-show').val(data.followUpDate);
                    if(data !=''){
                        $('#follow-show').html('Follow-up Set  '+data.followUpDate);}
                }
            });
        });
        //seted followup date
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
                        document.getElementById('total').innerHTML='ON '+ currentdate +  ' Already Have '+ data +' followup';
                        document.getElementById('exceed').style.display="inline";
                    }
                    else
                    {
                        document.getElementById('exceed').style.display="none";
                        document.getElementById('total').style.display="inline";
                        document.getElementById('total').innerHTML='On this date you already have '+ data +' followups';
                    }
                }
            });
        });
        $(document).ready(function () {
            var status = document.getElementById("statuschanges").value;
            dataTable =  $('#myTable').DataTable({
                processing: true,
                serverSide: true,
                stateSave: true,
                type:"POST",
                "ajax":{
                    "url": "{!! route('getContacedData') !!}",
                    "type": "POST",
                    data:function (d){
                        d._token="{{csrf_token()}}";
                        if ($("#statuschanges").val() != '') {
                            d.status=$("#statuschanges").val();
                        }
                        if ($("#minedby").val() != '') {
                            d.minedby=$("#minedby").val();

                        }
                    },
                },
                columns: [

                    {data: 'check', name: 'check', orderable: false, searchable: false},

                    { data: 'leadId', name: 'leads.leadId'},
                    { data: 'companyName', name: 'leads.companyName'},
                    { data: 'category.categoryName', name: 'category.categoryName'},
                    { data: 'website', name: 'leads.website'},
                    { data: 'possibility.possibilityName', name: 'possibility.possibilityName'},

                    { data: 'probability.probabilityName',
                        render: function(data) {
                            if(data != null) {
                                return data
                            }
                            else {
                                return 'null'
                            }

                        },
                    },
                    { data: 'country.countryName', name: 'country.countryName'},
                    { data: 'personName', name: 'personName',searchable: true},
                    { data: 'call', name: 'leads.contactNumber',searchable: true},
                    { data: 'volume', name: 'volume', searchable: false},
                    { data: 'process', name: 'process', searchable: true},
                    { data: 'frequency', name: 'frequency', searchable: true},
                    { data: 'callreport', name: 'callreport', searchable: false},
                    { data: 'minedby', name: 'minedby', searchable: false},
                    { data: 'action', name: 'action', orderable: false, searchable: false},
                ],
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




        $("#otherCatches2").change(function() {

        var chkArray = [];
        var userId=$(this).val();
        $('.checkboxvar:checked').each(function (i) {

            chkArray[i] = $(this).val();
        });
        //alert(chkArray)
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        // $("#inp").val(JSON.stringify(chkArray));
        // $( "#assign-form" ).submit();
        jQuery('input:checkbox:checked').parents("tr").remove();
        $(this).prop('selectedIndex',0);

        $.ajax({
            type : 'post' ,
            url : '{{route('assignStore')}}',
            data : {_token: CSRF_TOKEN,'leadId':chkArray,'userId':userId} ,
            success : function(data){
                console.log(data);
                if(data == 'true'){
                    // $('#myTable').load(document.URL +  ' #myTable');
        //                        $.alert({
        //                            title: 'Success!',
        //                            content: 'successfully assigned!',
        //                        });
                    $('#alert').html(' <strong>Success!</strong> Assigned');
                    $('#alert').show();

                }
            }
        });



        });




        });


        function leadstatussearch(){

            dataTable.ajax.reload();
        }
        function mindbychanged(){
            dataTable.ajax.reload();
        }

        {{--function edtcontactmodal(x) {--}}
        {{--leadId = $(x).data('lead-id');--}}
        {{--var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');--}}
        {{--// alert(leadId);--}}
        {{--$.ajax({--}}
        {{--type : 'post' ,--}}
        {{--url : '{{route('editcontactmodalshow')}}',--}}
        {{--data : {_token: CSRF_TOKEN,'leadId':leadId} ,--}}
        {{--success : function(data){--}}
        {{--$('#txtHint').html(data);--}}
        {{--}--}}
        {{--});--}}
        {{--// document.getElementById("edit_modal").style.display = "block";--}}
        {{--$('#edit_modal').modal('show');--}}
        {{--$(".custom-close").on('click', function() {--}}
        {{--$('#edit_modal').modal('hide');--}}
        {{--});--}}
        {{--}--}}
    </script>
    <script src="https://cdn.datatables.net/select/1.3.1/js/dataTables.select.min.js"></script>
@endsection
