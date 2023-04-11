@extends('main')



@section('content')


    <div class="card" style="padding:10px;">
        <div class="card-body">
            @if(Request::url()==route('assignedLeads'))
                <h2 class="card-title" align="center"><b>Assigned Leads</b></h2>
                <p class="card-subtitle" align="center">Please check if there's any suspicious leads in your assigned leads.</h2>
            @endif

            @if(Request::url()==route('contacted'))
                <h2 class="card-title" align="center"><b>Contacted</b></h2>
            @endif

            <div class="table-responsive m-t-40">
                <table id="myTable" class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th width="5%"> Select</th>
                        <th width="5%">Id</th>
                        <th width="7%">Assigned by</th>
                        <th width="10%">Company Name</th>
                       
                        <th width="7%">Category</th>
                        <th width="9%">website</th>
                        <th width="8%">Possibility</th>
                        <th width="8%">Probability</th>
                        <th width="5%">Country</th>
                        <th width="8%">Contact Person</th>
                        <th width="8%">Contact Number</th>
                        <th width="10%">Action</th>

                    </tr>
                    </thead>
                    <tbody>

                    @foreach($leads as $lead)
                        <tr>
                            <td width="5%"><input type="checkbox" class="checkboxvar"   name="checkboxvar[]" value="{{$lead->leadId}}"></td>
                            <td width="5%">{{$lead->leadId}}</td>
                            <td width="7%">{{$lead->leadId}}</td>
                            <td width="10%">{{$lead->companyName}}</td>
                           
                            <td width="8%">{{$lead->category->categoryName}}</td>
                            <td width="9%"><a href="{{$lead->website}}" target="_blank">{{$lead->website}}</a></td>
                            <td width="8%">{{$lead->possibility->possibilityName}}</td>
                            <td width="8%">@if($lead->probability != null){{$lead->probability->probabilityName}} @else null @endif</td>
                            <td width="5%">{{$lead->country->countryName}}</td>
                            <td width="8%">{{$lead->personName}}</td>
                            <td width="8%"><a
                                        href="skype::{{$lead->contactNumber."?call"}}">{{$lead->contactNumber}}</a></td>

                            <td width="9%">

                                @if($lead->contactedUserId==null)
                                    <form method="post" action="{{route('addContacted')}}" style="float: left;">
                                        {{csrf_field()}}
                                        <input type="hidden" value="{{$lead->leadId}}" name="leadId">
                                        <button class="btn btn-info btn-sm"><i class="fa fa-bookmark"
                                                                               aria-hidden="true"></i></button>

                                    </form>
                                @endif
                                &nbsp;
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
                                   data-lead-comments="{{$lead->comments}}"

                                >
                                    <i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                            </td>
                        </tr>

                    @endforeach

                    </tbody>
                </table>

                <input type="checkbox" id="selectall" onClick="selectAll(this)" /><b>Select All</b>

                <div class="mt-2">
                    <input id = "makemy" type="submit" class="btn btn-outline-primary" value="Make My Lead"/>

                </div>


              

               
            </div>
        </div>

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
                    @foreach($users as $user)
                        <option value="{{$user->id}}">{{$user->firstName}} {{$user->lastName}}</option>
    
                    @endforeach
    
                </select>
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
                    <form method="post" action="{{route('leadUpdate')}}">
                        {{csrf_field()}}
                        <div class="row">
                            <div class="col-md-12" align="center">
                                <b> Mined By:
                                    <div class="mined" id="mined"></div>
                                </b>
                            </div>
                            <div class="col-md-4">
                                <label>Category:</label>
                                <select class="form-control" name="category" id="category">
                                    <option value="">Please Select</option>
                                    @foreach($categories as $category)
                                        <option value="{{$category->categoryId}}">{{$category->categoryName}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4">
                                <input type="hidden" name="leadId">
                                <label>Company Name:</label>
                                <input type="text" class="form-control" name="companyName" value="">
                            </div>

                            <div class="col-md-4">
                                <label>Email:</label>
                                <input type="email" class="form-control" name="email" value="">
                            </div>
                            <div class="col-md-4">
                                <label>Contact Person:</label>
                                <input type="text" class="form-control" name="personName" value=""> <br>
                            </div>
                            <div class="col-md-4">
                                <label>Number:</label>
                                <input type="text" class="form-control" name="number" value="">
                            </div>
                            <div class="col-md-4">
                                <label>Website:</label>
                                <input type="text" class="form-control" name="website" value=""> <br>
                            </div>

                            <div class="col-md-4">
                                <label>Designation:</label>
                                <input type="text" class="form-control" name="designation" value="">
                            </div>

                            <div class="col-md-4">
                                <label>Country:</label>
                                <select class="form-control" name="country" id="country">
                                    @foreach($country as $c)
                                        <option value="{{$c->countryId}}">{{$c->countryName}}</option>
                                    @endforeach
                                </select>
                                <br><br><br>
                            </div>

                            <div class="col-md-8">
                                <label><b>Comment:</b></label>
                                <textarea class="form-control" id="comments" name="comments"></textarea>
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
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
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
                    <button type="button" class="close" data-dismiss="modal"><span
                                aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title" name="modal-title">Calling Report</h4>
                </div>
                <div class="modal-body">
                    {{csrf_field()}}
                    <input type="hidden" name="leadId">

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label><b>Calling Report : </b></label>
                                <select class="form-control" name="report" id="reporttest" required>
                                    {{--<option value=""><b>(select one)</b></option>--}}

                                    {{--@foreach($callReports as $report)--}}
                                    {{--<option value="{{$report->callingReportId}}">{{$report->report}}</option>--}}
                                    {{--@endforeach--}}
                                </select>
                            </div>

                            <div class="form-group">
                                <label><b>Progress : </b></label>
                                <select class="form-control" name="progress">
                                    <option value=""><b>(select one)</b></option>
                                    <option value="Test Job">Test Job</option>
                                    <option value="Closing">Closing</option>
                                </select>
                                <br>
                            </div>

                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label class=""><b>Follow Up Date : </b> {{--<span id="exceed" style="color:red;display: none"><i>Already Exceed the limit 10</i></span>--}}</label>
                                    <input class="form-control changedate" id="datepicker" rows="3" name="followup" placeholder="pick Date">
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

                            <div class="form-group">
                                <label class=""><b>Possibility : </b></label>
                                <select class="form-control" name="possibility" id="possibility">
                                    <option value=""><b>(select one)</b></option>
                                @foreach($possibilities as $p)
                                        <option value="{{$p->possibilityId}}">{{$p->possibilityName}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label class=""><b>Probability : </b></label>
                                <select class="form-control" name="probability" id="probability">
                                    <option value=""><b>(select one)</b></option>
                                @foreach($probabilities as $p)
                                        <option value="{{$p->probabilityId}}">{{$p->probabilityName}}</option>
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
                                <div style="height: 460px; width: 100%; overflow-y: scroll; border: solid black 1px;"
                                     id="comment">

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
    <meta name="csrf-token" content="{{ csrf_token() }}"/>



    <script>



        
function selectAll(source) {
            checkboxes = document.getElementsByName('checkboxvar[]');
            for(var i in checkboxes)
                checkboxes[i].checked = source.checked;
        }



    $(document).ready(function() {
    $("#makemy").click(function(){
        var chkArray = [];
        //var userId=$(this).val();
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
                url : '{{route('addmyContacted')}}',
                data : {_token: CSRF_TOKEN,'leadId':chkArray} ,
                success : function(data){
                    console.log(data);
                    if(data == 'true'){
                        // $('#myTable').load(document.URL +  ' #myTable');
//                        $.alert({
//                            title: 'Success!',
//                            content: 'successfully assigned!',
//                        });
                        $('#alert').html(' <strong>Success!</strong> Contacted');
                        $('#alert').show();

                    }
                }
            });
    }); 
})






















        //for Edit modal

        $('#edit_modal').on('show.bs.modal', function (e) {

            //get data-id attribute of the clicked element
            var leadId = $(e.relatedTarget).data('lead-id');
            var leadName = $(e.relatedTarget).data('lead-name');
            var email = $(e.relatedTarget).data('lead-email');
            var number = $(e.relatedTarget).data('lead-number');
            var personName = $(e.relatedTarget).data('lead-person');
            var website = $(e.relatedTarget).data('lead-website');
            var minedBy = $(e.relatedTarget).data('lead-mined');
            var category = $(e.relatedTarget).data('lead-category');
            var country = $(e.relatedTarget).data('lead-country');
            var designation = $(e.relatedTarget).data('lead-designation');
            var comments = $(e.relatedTarget).data('lead-comments');

            //populate the textbox
            $('#category').val(category);
            $('#country').val(country);
            $('div.mined').text(minedBy);
//            $(e.currentTarget).find('input[name="minedBy"]').val(minedBy);
            $(e.currentTarget).find('input[name="leadId"]').val(leadId);
            $(e.currentTarget).find('input[name="companyName"]').val(leadName);
            $(e.currentTarget).find('input[name="email"]').val(email);
            $(e.currentTarget).find('input[name="number"]').val(number);
            $(e.currentTarget).find('input[name="personName"]').val(personName);
            $(e.currentTarget).find('input[name="website"]').val(website);
            $(e.currentTarget).find('input[name="designation"]').val(designation);
            $('#comments').val(comments);
            // $(e.currentTarget).find('#leave').attr('href', '/lead/leave/'+leadId);

            @if(Auth::user()->typeId == 4 || Auth::user()->typeId == 5 )

            $(e.currentTarget).find('input[name="companyName"]').attr('readonly', true);
           // $(e.currentTarget).find('input[name="website"]').attr('readonly', true);

            @endif


        });

        $(function () {
            $("#datepicker").datepicker();
        });


        //for Call Modal

        $('#my_modal').on('show.bs.modal', function (e) {

            //get data-id attribute of the clicked element
            var leadId = $(e.relatedTarget).data('lead-id');
            var possibility = $(e.relatedTarget).data('lead-possibility');
            var probability = $(e.relatedTarget).data('lead-probability');

            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            $(e.currentTarget).find('input[name="leadId"]').val(leadId);


            $('#possibility').val(possibility);
            $('#probability').val(probability);
            //$(e.currentTarget).find('input[name="possibility"]').val(possibility);

            $.ajax({
                type: 'post',
                url: '{{route('getComments')}}',
                data: {_token: CSRF_TOKEN, 'leadId': leadId},
                success: function (data) {
                    $('#comment').html(data);
                    $("#comment").scrollTop($("#comment")[0].scrollHeight);
                }
            });

            $.ajax({
                type: 'post',
                url: '{{route('getCallingReport')}}',
                data: {_token: CSRF_TOKEN, 'leadId': leadId},
                success: function (data) {

                    document.getElementById("reporttest").innerHTML = data;

                }
            });
        });

        //check followup date count

       /* $('.changedate').on('change', function () {
            var currentdate = $('.changedate').val();
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            $.ajax({
                type: 'post',
                url: '{{route('followupCheck')}}',
                data: {_token: CSRF_TOKEN, 'currentdate': currentdate},
                success: function (data) {
                    if (data >= 10) {
                        document.getElementById('exceed').style.display = "inline";
                    } else {
                        document.getElementById('exceed').style.display = "none";
                    }
                }
            });
        });*/

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
            $('#myTable').DataTable({
                "processing": true,
                stateSave: true,
            });

        });




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







$("#otherCatches2").change(function(e) {
  
var chkArray = [];

var userId=$(this).val();
$('.checkboxvar:checked').each(function (i) {

    chkArray[i] = $(this).val();
    
});
//alert(iid)
//alert(chkArray)
var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
// $("#inp").val(JSON.stringify(chkArray));
// $( "#assign-form" ).submit();
jQuery('input:checkbox:checked').parents("tr").remove();
$(this).prop('selectedIndex',0);

$.ajax({
    type : 'post' ,
    url : '{{route('assignStore2')}}',
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



    </script>


@endsection
