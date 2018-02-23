@extends('main')



@section('content')


    <div class="card" style="padding:10px;">
        <div class="card-body">
            @if(Request::url()==route('assignedLeads'))
                <h2 class="card-title" align="center"><b>My List</b></h2>
            @endif

            @if(Request::url()==route('contacted'))
                <h2 class="card-title" align="center"><b>Contacted</b></h2>
            @endif

            <div class="table-responsive m-t-40">
                <table id="myTable" class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th width="15%">Company Name</th>
                        <th width="8%">Category</th>
                        <th width="10%">website</th>
                        <th width="8%">Possibility</th>
                        <th width="5%">Country</th>
                        <th width="8%">Contact Person</th>
                        <th width="8%">Contact Number</th>
                        <th width="10%">Action</th>

                    </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
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
                            <div class="col-md-12" align="center">
                                <label><b> Mined By: </b></label>  <div class="mined" id="mined"></div>
                            </div>
                            <div class="col-md-4">
                                <label><b>Category:</b></label>
                                <select class="form-control"  name="category" id="category">
                                    <option value="">Please Select</option>
                                    @foreach($categories as $category)
                                        <option value="{{$category->categoryId}}">{{$category->categoryName}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4">
                                <input type="hidden" name="leadId">
                                <label><b>Company Name:</b></label>
                                <input type="text" class="form-control" name="companyName" value="">
                            </div>

                            <div class="col-md-4">
                                <label><b>Email:</b></label>
                                <input type="email" class="form-control" name="email" value="">
                            </div>
                            <div class="col-md-4">
                                <label><b>Contact Person:</b></label>
                                <input type="text" class="form-control" name="personName" value="">
                            </div>
                            <div class="col-md-4">
                                <label><b>Number:</b></label>
                                <input type="text" class="form-control" name="number" value="">
                            </div>
                            <div class="col-md-4">
                                <label><b>Website:</b></label>
                                <input type="text" class="form-control" name="website" value="">
                            </div>

                            <div class="col-md-4">
                                <label><b>Designation:</b></label>
                                <input type="text" class="form-control" name="designation" value="">
                            </div>

                            <div class="col-md-4">
                                <label><b>Country:</b></label>
                                <select class="form-control"  name="country" id="country">
                                    @foreach($country as $c)
                                        <option value="{{$c->countryId}}">{{$c->countryName}}</option>
                                    @endforeach
                                </select>
                                <br><br><br>
                            </div>

                            <div class="col-md-6">
                                <button class="btn btn-success" type="submit">Update</button>
                            </div>
                        </div>
                    </form>
                    <br><br>
                    <form method="post" action="{{route('leaveLead')}}">
                        <div class="row">
                            {{csrf_field()}}

                            <div class=" form-group col-md-6">
                                <input type="hidden" name="leadId">
                                <label><b>Status:</b></label>
                                <select class="form-control"  name="Status" id="Status" required>
                                    <option value="">Please Select</option>
                                    @foreach($status as $s)
                                        <option value="{{$s->statusId}}">{{$s->statusName}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class=" form-group col-md-6" style="margin-top: 3.2%">
                                <button class="btn btn-danger" type="submit" onclick="return confirm('Are you sure you want to leave this Lead?')">Leave</button>
                            </div>
                        </div>

                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div> </div>










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

                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label class=""><b>Follow Up Date : </b></label>
                                    <input class="form-control changedate" id="datepicker"  rows="3" name="followup" placeholder="pick Date">
                                </div>

                                <div class="form-group col-md-6">
                                    <label class=""><b>Time: </b> </label>
                                    <input class="form-control" name="time" placeholder="pick Time">
                                </div>
                                <div class="col-md-12" style="text-align: center; font-weight: bold;">
                                    <span id="exceed" style="color:red;display: none"><i>Already Exceed the limit 10</i></span>
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
                                <label class=""><b>Comment : </b></label>
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
    <meta name="csrf-token" content="{{ csrf_token() }}" />



    <script>

        //for Edit modal

        $('#edit_modal').on('show.bs.modal', function(e) {
//            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
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


            //populate the textbox
            $('#category').val(category);
            $('div.mined').text(minedBy);
            $('#country').val(country);
//            $(e.currentTarget).find('input[name="minedBy"]').val(minedBy);
            $(e.currentTarget).find('input[name="leadId"]').val(leadId);
            $(e.currentTarget).find('input[name="companyName"]').val(leadName);
            $(e.currentTarget).find('input[name="email"]').val(email);
            $(e.currentTarget).find('input[name="number"]').val(number);
            $(e.currentTarget).find('input[name="personName"]').val(personName);
            $(e.currentTarget).find('input[name="website"]').val(website);
            $(e.currentTarget).find('input[name="designation"]').val(designation);

            // $(e.currentTarget).find('#leave').attr('href', '/lead/leave/'+leadId);




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
                url : '{{route('editcontactmodalshow')}}',
                data : {_token:CSRF_TOKEN,'leadId':leadId} ,
                success : function(data){
                    // $('#txtHint').html(data);
                    console.log(data);
//                    $('#follow-show').val(data.followUpDate);
                    if(data !=null){
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
                        document.getElementById('exceed').style.display="inline";
                    }
                    else
                    {
                        document.getElementById('exceed').style.display="none";
                    }
                }
            });
        });


        $(function() {
            $('#myTable').DataTable({
                processing: true,
                serverSide: true,
                Filter: true,
                stateSave: true,
                type:"POST",
                "ajax":{
                    "url": "{!! route('getContacedData') !!}",
                    "type": "POST",
                    "data":{ _token: "{{csrf_token()}}"},
                },
                columns: [
                    { data: 'companyName', name: 'leads.companyName'},
                    { data: 'category.categoryName', name: 'category.categoryName'},
                    { data: 'website', name: 'leads.website'},
                    { data: 'possibility.possibilityName', name: 'possibility.possibilityName'},
                    { data: 'country.countryName', name: 'country.countryName'},
                    { data: 'personName', name: 'leads.personName'},
                    { data: 'call', name: 'leads.contactNumber',searchable: true},
                    {data: 'action', name: 'action', orderable: false, searchable: false},


                ]
            });
        });


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


@endsection