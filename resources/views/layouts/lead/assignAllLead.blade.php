

@extends('main')

@section('header')
    <link rel="stylesheet" href="{{url('css/jconfirm.css')}}">
    @endsection
@section('content')





    <div class="card" style="padding:10px;">
        <div class="card-body">
            <h2 class="card-title" align="center"><b>Assign Leads From Other Marketers</b></h2>
			<p class="card-text" align="center">Please make sure you are not assigning random leads from here</p>
            <div class="row">
                <div class="col-md-3">
                    <div class="form-group">

                        {{--<div class="form-group col-md-5">--}}
                            <h4>Filter By Marketier</h4>
                        {{-- <label ><b>Select Marketier:</b></label> --}}
                        <select class="form-control"  name="assignTo" id="otherCatches2">
                            <option value="">select</option>

                            @foreach($users as $user)
                                <option value="{{$user->id}}">{{$user->firstName}} {{$user->lastName}}</option>

                            @endforeach

                        </select>
                    </div>
                </div>
            </div>

            <div class="table-responsive m-t-40">
                <table id="myTable" class="table table-bordered table-striped">
                    <thead>
                    <tr>


                        <th>Select</th>
                        <th>Company Name</th>
                        <th>Phone</th>
                        <th>Date</th>
                        <th>Mined By</th>
                        {{--<th>Category</th>--}}
                        <th>Website</th>
                        {{--<th>Email</th>--}}
                        <th>Country</th>
                        <th>Category</th>
                        <th>Status</th>
                        <th>Possibility</th>
                        <th>Probability</th>
                        <th>Action</th>


                    </tr>
                    </thead>
                    <tbody>




                    </tbody>
                </table>
            </div>




            <input type="checkbox" id="selectall" onClick="selectAll(this)" /><b>Select All</b>

            <div class="form-group">

                {{--<div class="form-group col-md-5">--}}
                <label ><b>Assign to:</b></label>
                <select class="form-control"  name="assignTo" id="otherCatches" style="width: 30%">
                    <option value="">select</option>
                    @foreach($users as $user)
                        <option value="{{$user->id}}">{{$user->firstName}} {{$user->lastName}}</option>

                    @endforeach

                </select>
            </div>




            <input type="hidden" class="form-control" id="inp" name="leadId">


        </div>


        </div>
    </div>



      <!--Edit Modal -->
      <div class="modal" id="my_modal" style="">
        <div class="modal-dialog" style="max-width: 60%">

            <form class="modal-content" method="post" action="{{route('leadUpdate')}}">
                <div class="modal-header">
                   <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title" name="modal-title">Edit Lead</h4>
                </div>
                <div class="modal-body">


                    {{csrf_field()}}
                    <div class="row">

                        <div class="col-md-12" align="center">
                            <b > Mined By:   <div class="mined" id="mined"></div></b>
                            {{--<input type="text" class="form-control" name="minedBy" value="">--}}

                        </div>

                        <div class="col-md-4">
                            <label>Category:</label>
                            <select class="form-control"  name="category" id="category">
                                <option value="">Please Select</option>
                                @foreach($cats as $category)
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
                            <input type="text" class="form-control" name="personName" value=""> <br><br><br>
                        </div>


                        <div class="col-md-4">
                            <label>Number:</label>
                            <input type="text" class="form-control" name="number" value="">
                        </div>

                        <div class="col-md-4">
                            <label>Website:</label>
                            <input type="text" class="form-control" name="website" value=""> <br><br><br>
                        </div>


                        <div class="col-md-4">
                            <label><b>Designation:</b></label>
                            <input type="text" class="form-control" name="designation" value="">
                        </div>

                        <div class="col-md-4">
                            <label><b>Country:</b></label>
                            <select class="form-control"  name="country" id="country">
                                @foreach($countries as $c)
                                    <option value="{{$c->countryId}}">{{$c->countryName}}</option>
                                @endforeach
                            </select>
                            <br><br><br>
                        </div>

                        <div class="col-md-4">
                            <label><b>Status:</b></label>
                            <select class="form-control"  name="status" id="">
                                <option value="">select one</option>
                                <option value="5">Rejected</option>
                                @if($User_Type=="ADMIN")
                                <option value="6">Client</option>
                                @endif
                            </select>
                            <br><br><br>
                        </div>

                        <div class="col-md-8">
                            <label><b>Comment:</b></label>
                            <textarea class="form-control" id="comments" name="comments"></textarea>
                        </div>

                        <div class="col-md-8">
                            <button class="btn btn-success" type="submit">Update</button>
                        </div>

                    </div>
                </div>



                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div></form>
        </div>
    </div>


    <!-- Call Modal -->
    <div class="modal" id="call_modal" style="">
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

                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label class=""><b>Follow Up Date : </b> <span id="exceed" style="color:red;display: none"><i>Already Exceed the limit 10</i></span></label>
                                    <input class="form-control changedate" id="datepicker"  rows="3" name="followup" placeholder="pick Date">
                                </div>

                                <div class="form-group col-md-6">
                                    <label class=""><b>Time: </b> </label>
                                    <input class="form-control" name="time" placeholder="pick Time">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class=""><b>Possibility : </b></label>
                                <select class="form-control"  name="possibility" id="possibility">
                                    @foreach($possibilities as $p)
                                        <option value="{{$p->possibilityId}}">{{$p->possibilityName}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group col-md-5" style="">
                                <label ><b>Probability :</b></label>
                                <select class="form-control" id="probability2" name="probability">
                                    @foreach($probabilities as $probability)
                                        <option value="{{$probability->probabilityId}}">{{$probability->probabilityName}}</option>
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
                                <div  style="height: 460px; width: 100%; overflow-y: scroll; border: solid black 1px;" id="comment2">

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


     {{--ALL Chat/Comments--}}
     <div class="modal" id="lead_comments" >
        <div class="modal-dialog" style="max-width: 60%">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title" name="modal-title">All Conversation</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-4">
                    <b>Company Name:</b>
                    <input type="text" name="companyName" readonly>
                        </div>

                        <div class="col-md-6">
                        <div class="form-group">
                        <label class=""><b>Comment : </b></label>

                                <ul class="list-group" style="margin: 10px; "><br>
                                    <div  style="height: 460px; width: 100%; overflow-y: scroll; border: solid black 1px;" id="comment">

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

    <script src="{{url('js/jconfirm.js')}}"></script>


    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <script>

function selectAll(source) {
            checkboxes = document.getElementsByName('checkboxvar[]');
            for(var i in checkboxes)
                checkboxes[i].checked = source.checked;
        }



        $(document).ready(function(){





fill_datatable();
function fill_datatable(userId='')
    {
        $(function() {

            //var userId=$("#otherCatches2").val();
            //alert(userId)


            $('#myTable').DataTable({
                processing: true,
                serverSide: true,
                stateSave: true,
                type:"POST",
                "ajax":{
                    "url": "{!! route('getAllAssignLeadData') !!}",
                    "type": "POST",
                    "data":{ _token: "{{csrf_token()}}",'userId':userId}
                },


                columns: [
                    {data: 'action', name: 'action', orderable: false, searchable: false},
                    { data: 'companyName', name: 'leads.companyName' },
                    { data: 'contactNumber', name: 'leads.contactNumber' },
                    { data: 'created_at', name: 'leads.created_at' },
                    { data: 'mined.firstName', name: 'mined.firstName' },
                    { data: 'website', name: 'leads.website' },
//                    { data: 'email', name: 'leads.email' },
                    { data: 'country.countryName', name: 'country.countryName'},
                    { data: 'category.categoryName', name: 'category.categoryName' ,orderable: false,defaultContent: ""},
                    {data: 'status.statusName', name: 'status.statusName'},
                    { data: 'possibility.possibilityName', name: 'possibility.possibilityName' },
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
                    { data: 'check', name: 'check', orderable: false, searchable: false},
                ]
            });
        });

    }








        $("#otherCatches").change(function() {

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
                        $('#alert').html('Leads are assigned successfully');
                        $('#alert').show();

                    }
                }
            });



        });





        $("#otherCatches2").change(function() {



        var userId = $(this).val();
        //var filter_country = $('#filter_country').val();

        if(userId != '')
        {
            //alert(userId)
            $('#myTable').DataTable().destroy();
            fill_datatable(userId);
        }
        else
        {
            alert('Select Both filter option');
        }
        });




        $('#lead_comments').on('show.bs.modal', function(e) {

var leadId = $(e.relatedTarget).data('lead-id');
var leadName = $(e.relatedTarget).data('lead-name');
var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

$(e.currentTarget).find('input[name="companyName"]').val(leadName);

$.ajax({
    type : 'post' ,
    url : '{{route('getComments')}}',
    data : {_token: CSRF_TOKEN,'leadId':leadId} ,
    success : function(data){

        $("#comment").html(data);
        $("#comment").scrollTop($("#comment")[0].scrollHeight);
    }
});

});


$('#my_modal').on('show.bs.modal', function(e) {
//get data-id attribute of the clicked element
var leadId = $(e.relatedTarget).data('lead-id');
var leadName = $(e.relatedTarget).data('lead-name');
var email = $(e.relatedTarget).data('lead-email');
var number = $(e.relatedTarget).data('lead-number');
var personName = $(e.relatedTarget).data('lead-person');
var website = $(e.relatedTarget).data('lead-website');
var minedBy=$(e.relatedTarget).data('lead-mined');
var category=$(e.relatedTarget).data('lead-category');
var country=$(e.relatedTarget).data('lead-country');
var designation=$(e.relatedTarget).data('lead-designation');
var comments=$(e.relatedTarget).data('lead-comments');
var createdAt=$(e.relatedTarget).data('lead-created');

// alert(createdAt);
console.log(comments);

//populate the textbox
$('#country').val(country);
$('#category').val(category);
$('div.mined').text(minedBy+' _'+createdAt);
//            $(e.currentTarget).find('input[name="minedBy"]').val(minedBy);
$(e.currentTarget).find('input[name="leadId"]').val(leadId);
$(e.currentTarget).find('input[name="companyName"]').val(leadName);
$(e.currentTarget).find('input[name="email"]').val(email);
$(e.currentTarget).find('input[name="number"]').val(number);
$(e.currentTarget).find('input[name="personName"]').val(personName);
$(e.currentTarget).find('input[name="website"]').val(website);
$(e.currentTarget).find('input[name="designation"]').val(designation);
$('#comments').val(comments);

//            $(e.currentTarget).find('#reject').attr('href', '/lead/reject/'+leadId);
@if(Auth::user()->typeId == 4 || Auth::user()->typeId == 5 )

$(e.currentTarget).find('input[name="companyName"]').attr('readonly', true);
$(e.currentTarget).find('input[name="website"]').attr('readonly', true);


@endif

});




$('#call_modal').on('show.bs.modal', function(e) {

//get data-id attribute of the clicked element
var leadId = $(e.relatedTarget).data('lead-id');
var possibility=$(e.relatedTarget).data('lead-possibility');
var probability=$(e.relatedTarget).data('lead-probability');




var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
$(e.currentTarget).find('input[name="leadId"]').val(leadId);



$('#possibility').val(possibility);


$('#probability2').val(probability);
// $(e.currentTarget).find('input[name="possibility"]').val(possibility);

$.ajax({
    type : 'post' ,
    url : '{{route('getComments')}}',
    data : {_token: CSRF_TOKEN,'leadId':leadId} ,
    success : function(data){
        $('#comment2').html(data);
        $("#comment2").scrollTop($("#comment2")[0].scrollHeight);
    }
});

});









        });

    </script>


@endsection
