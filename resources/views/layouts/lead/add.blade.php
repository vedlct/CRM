@extends('main')

@section('header')

    <link href="{{url('css/select2.min.css')}}" rel="stylesheet" />
@endsection

@section('content')

    {{--<div class="card" style="max-width: 100px;margin-top: 20px;">--}}<br><br>

    {{--</div>--}}

    @php($userType = Session::get('userType'))

    <div class="card" style="padding:10px;">
        <div class="card-body">
            <a href="#create_temp_modal" data-toggle="modal" class="btn btn-info btn-md" style="border-radius: 50%; float: right;"><i class="fa fa-plus"></i></a>
            @if($userType =='ADMIN')
            <a href="#admin_create_temp_modal" title="Client!" data-toggle="modal" class="btn btn-success btn-md" style="border-radius: 50%; float: right; margin-right: 10px;"><i class="fa fa-plus"></i></a>
            @endif
            <h2 class="card-title" align="center"><b>All Leads</b></h2>

            <div class="table-responsive m-t-40">
                <table id="myTable" class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th width="2%">Id</th>
                        <th width="3%">Company Name</th>
                        <th width="3%">website</th>
                        <th width="4%">Number</th>
                        <th width="3%">Category</th>
                        <th width="4%">Country</th>
                        <th width="4%">Marketier</th>
                        <th width="4%">Contact</th>
                        <th width="4%">Status</th>
                        <th width="4%">Poss</th>
                        <th width="4%">Prob</th>
                        <th width="4%">Volume</th>
                        <th width="4%">Process</th>
                        <th width="4%">Frequency</th>
                        <th width="8%">Date</th>
                        <th width="10%">Action</th>


                    </tr>
                    </thead>
                    <tbody>



                    </tbody>
                </table>
            </div>
        </div>
    </div>


    <!--ALL Chat/Comments-->
    
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




    {{--Add Lead Modal--}}

    <div class="modal" id="create_temp_modal" style="">
        <div class="modal-dialog" style="max-width: 60%;">

            <form class="modal-content" action="{{route('storeLead')}}" method="POST">

                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title" name="modal-title">Create Lead</h4>
                </div>

                <div class="container-fluid">
                    <div class="row">
                        {{csrf_field()}}
                        <div class="form-group col-md-5">
                            <label class="control-label " ><b>Company Name</b></label>
                            <span id="exceedcompany" style="color:red;display: none"><i>This Company Name already exist</i></span></label>
                            {!! $errors->first('companyName', '<p class="help-block">:message</p>') !!}

                            <input type="text" class="form-control companyNamecheck" id="" placeholder="Enter Company Name" name="companyName" required>

                        </div>


                        <div class="form-group col-md-5">
                            <label class="control-label" ><b>Website</b></label>
                            <span id="exceedwebsite" style="color:red;display: none"><i>This Website already exist</i></span></label>
                            {!! $errors->first('website', '<p class="help-block">:message</p>') !!}
                            <input type="text" class="form-control websitecheck" name="website" placeholder="Enter url" >

                        </div>

                        <div class="form-group col-md-5" style="">
                            <label class="control-label" ><b>Contact Person</b></label>
                            {!! $errors->first('personName', '<p class="help-block">:message</p>') !!}
                            <input type="text" class="form-control" id="" name="personName" placeholder="name" >

                        </div>


                        <div class="form-group col-md-5">
                            <label class="control-label" ><b> Email:</b></label>
                            {!! $errors->first('email', '<p class="help-block">:message</p>') !!}
                            <input type="email" class="form-control" name="email" id="email" placeholder="Enter email">

                        </div>

                        <div class="form-group col-md-5">
                            <label class="control-label" ><b>Contact Number</b></label>
                            <span id="exceed" style="color:red;display: none"><i>This number already exist</i></span></label>
                            {!! $errors->first('personNumber', '<p class="help-block">:message</p>') !!}
                            <input type="text" class="form-control numbercheck" id="personNumber" name="personNumber" placeholder="Enter Phone Number" required>
                        </div>

                        <div class="form-group col-md-5">
                            <label class="control-label " ><b>Designation</b></label>
                            {!! $errors->first('designation', '<p class="help-block">:message</p>') !!}
                            <input type="text" class="form-control" name="designation" placeholder="Enter Person Designation" >

                        </div>

                        <div class="form-group col-md-5" style="">
                            <label ><b>Category:</b></label>
                            <select class="form-control" id="" name="category" >
                                @foreach($categories as $cat2)
                                    <option value="{{$cat2->categoryId}}">{{$cat2->categoryName}}</option>

                                @endforeach
                            </select>
                        </div>

                        <div class="form-group col-md-5">

                            <label for="sel1"><b>Country:</b></label>
                            <select class="select form-control" id="" name="country" style="width: 100%;">
                                @foreach($countries as $c)
                                    <option value="{{$c->countryId}}">{{$c->countryName}}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group col-md-5" style="">
                            <label ><b>Possibility:</b></label>
                            <select class="form-control" id="" name="possibility">
                                @foreach($possibilities as $possibility)
                                    <option value="{{$possibility->possibilityId}}">{{$possibility->possibilityName}}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group col-md-5" style="">
                            <label ><b>Probability:</b></label>
                            <select class="form-control" id="probability" name="probability">
                                @foreach($probabilities as $probability)
                                    <option value="{{$probability->probabilityId}}">{{$probability->probabilityName}}</option>
                                @endforeach
                            </select>
                        </div>


{{--                        <div class="form-group col-md-5">--}}
{{--                            <br><br>--}}
{{--                            <label><b>Contact: </b>&nbsp; </label><input type="checkbox" name="contact">--}}
{{--                        </div>--}}

{{--                        <div class="form-group col-md-5">--}}
{{--                            <label><b>user </b>&nbsp; </label>--}}
{{--                            <select name="user" class="form-control">--}}
{{--                                <option>Select a User</option>--}}
{{--                                @foreach($user as $usr)--}}
{{--                                <option value="{{$usr->id}}">{{$usr->userId}}</option>--}}
{{--                                    @endforeach--}}
{{--                            </select>--}}
{{--                        </div>--}}



                        <div class="form-group col-md-10">
                            <label class="control-label " ><b>Comments</b></label>

                            {!! $errors->first('comment', '<p class="help-block">:message</p>') !!}

                            {{--<input type="text" class="form-control" id="" placeholder="Enter Comment" name="comment" required>--}}

                            <textarea name="comment" rows="4"  class="form-control">


                </textarea>
                        </div>


                        <button type="submit" class="btn btn-success btn-md" style="width: 30%; margin-left: 20px;">Insert</button>

                    </div></div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>

            </form>
        </div>
    </div>

    {{--Add Lead Modal For Admin--}}

    <div class="modal" id="admin_create_temp_modal" style="">
        <div class="modal-dialog" style="max-width: 60%;">

            <form class="modal-content" action="{{route('storeLeadAdmin')}}" method="POST">

                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title" name="modal-title">Create Lead</h4>
                </div>



                <div class="container-fluid">
                    <div class="row">
                        {{csrf_field()}}
                        <div class="form-group col-md-5">
                            <label class="control-label " ><b>Company Name</b></label>
                            <span id="exceedcompany" style="color:red;display: none"><i>This number already exist</i></span></label>
                            {!! $errors->first('companyName', '<p class="help-block">:message</p>') !!}

                            <input type="text" class="form-control companyNamecheck" id="" placeholder="Enter Company Name" name="companyName" required>

                        </div>


                        <div class="form-group col-md-5">
                            <label class="control-label" ><b>Website</b></label>
                            <span id="exceedwebsite" style="color:red;display: none"><i>This number already exist</i></span></label>
                            {!! $errors->first('website', '<p class="help-block">:message</p>') !!}
                            <input type="text" class="form-control websitecheck" name="website" placeholder="Enter url" >

                        </div>

                        <div class="form-group col-md-5" style="">
                            <label class="control-label" ><b>Contact Person</b></label>
                            {!! $errors->first('personName', '<p class="help-block">:message</p>') !!}
                            <input type="text" class="form-control" id="" name="personName" placeholder="name" >

                        </div>


                        <div class="form-group col-md-5">
                            <label class="control-label" ><b> Email:</b></label>
                            {!! $errors->first('email', '<p class="help-block">:message</p>') !!}
                            <input type="email" class="form-control" name="email" id="email" placeholder="Enter email">

                        </div>

                        <div class="form-group col-md-5">
                            <label class="control-label" ><b>Contact Number</b></label>
                            <span id="exceed" style="color:red;display: none"><i>This number already exist</i></span></label>
                            {!! $errors->first('personNumber', '<p class="help-block">:message</p>') !!}
                            <input type="text" class="form-control numbercheck" id="personNumber" name="personNumber" placeholder="Enter Phone Number" required>
                        </div>

                        <div class="form-group col-md-5">
                            <label class="control-label " ><b>Designation</b></label>
                            {!! $errors->first('designation', '<p class="help-block">:message</p>') !!}
                            <input type="text" class="form-control" name="designation" placeholder="Enter Person Designation" >

                        </div>



                        <div class="form-group col-md-5" style="">
                            <label ><b>Category:</b></label>
                            <select class="form-control" id="" name="category">
                                @foreach($categories as $cat)
                                    <option value="{{$cat->categoryId}}">{{$cat->categoryName}}</option>

                                @endforeach
                            </select>
                        </div>

                        <div class="form-group col-md-5">

                            <label for="sel1"><b>Country:</b></label>
                            <select class="select form-control" id="" name="country" style="width: 100%;">
                                @foreach($countries as $c)
                                    <option value="{{$c->countryId}}">{{$c->countryName}}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group col-md-5" style="">
                            <label ><b>Possibility:</b></label>
                            <select class="form-control" id="" name="possibility">
                                @foreach($possibilities as $possibility)
                                    <option value="{{$possibility->possibilityId}}">{{$possibility->possibilityName}}</option>

                                @endforeach
                            </select>

                        </div>

                        <div class="form-group col-md-5" style="">
                            <label ><b>Probability:</b></label>
                            <select class="form-control" id="probability" name="probability">
                                @foreach($probabilities as $probability)
                                    <option value="{{$probability->probabilityId}}">{{$probability->probabilityName}}</option>
                                @endforeach
                            </select>
                        </div>

                        {{--<div class="form-group col-md-5">--}}
                            {{--<br><br>--}}
                            {{--<label><b>Contact: </b>&nbsp; </label><input type="checkbox" name="contact">--}}
                        {{--</div>--}}

                        <div class="form-group col-md-10">
                            <label class="control-label " ><b>Comments</b></label>

                            {!! $errors->first('comment', '<p class="help-block">:message</p>') !!}

                            {{--<input type="text" class="form-control" id="" placeholder="Enter Comment" name="comment" required>--}}

                            <textarea name="comment" rows="4"  class="form-control"></textarea>
                        </div>

                        <button type="submit" class="btn btn-success btn-md" style="width: 30%; margin-left: 20px;">Insert</button>

                    </div></div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>

            </form>
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

                        <!-- <div class="col-md-9" float="left">
                            <b > Mined By:   <div class="mined" id="mined"></div></b>
                        </div>
                        <div class="col-md-3" float="right">
                            <b > Lead ID:   <div class="leadId" id="leadId"></div></b>
                            <br><br>
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
                                <label><b>Country:</b></label>
                                <select class="form-control"  name="country" id="country">
                                    @foreach($countries as $c)
                                        <option value="{{$c->countryId}}">{{$c->countryName}}</option>
                                    @endforeach
                                </select>
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



                            <div class="col-md-3">
                                <label><b>Contact Person:</b></label>
                                <input type="text" class="form-control" name="personName" value="">
                            </div>

                            <div class="col-md-3">
                                <label><b>Designation:</b></label>
                                <input type="text" class="form-control" name="designation" value="">
                            </div>

                            <div class="col-md-3">
                                <label><b>Email:</b></label>
                                <input type="email" class="form-control" name="email" value="">
                            </div>

                            <div class="col-md-3">
                                <label><b>LinkedIn Profile:</b></label>
                                <input type="text" class="form-control" name="linkedin" value="">
                                <br><br>
                            </div>



                            <div class="col-md-8">
                                <label><b>Comments:</b></label>
                                <textarea class="form-control" id="comments" name="comments"></textarea>
                            </div>

                            <div class="col-md-4">
                            <label><b>Change Status:</b></label>
                            <select class="form-control"  name="status" id="">
                                <option value="">select one</option>
                                <option value="5">Rejected</option>
                                @if($userType=="ADMIN" || "MANAGER")
                                <option value="6">Client</option>
                                @endif
                            </select>
                            <br><br>
                        </div>


                        <div class="col-md-8">
                            <button class="btn btn-success" type="submit">Update</button>
                        </div>

                    </div>
                </div>



                <div class="modal-footer">
                    <div class="mineIdDate" id="mineIdDate" align="left"></div> &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
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

@endsection

@section('bottom')

    <script src="{{url('js/select2.min.js')}}"></script>
    <script src="{{url('assets/plugins/datatables/jquery.dataTables.min.js')}}"></script>
    <script src="{{url('cdn.datatables.net/buttons/1.2.2/js/dataTables.buttons.min.js')}}"></script>
    <script src="{{url('cdn.datatables.net/buttons/1.2.2/js/buttons.flash.min.js')}}"></script>
    <script src="{{url('cdn.datatables.net/buttons/1.2.2/js/buttons.html5.min.js')}}"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <script>

        @if(Session::has('message'))
        $(window).on('load',function(){
            $('#create_temp_modal').modal('show');
        });
        @endif

        $(document).ready(function() {
            $('.select').select2();
        });

        function chkValidate() {


            var phone= document.getElementById('personNumber').value;
            var phoneReg = /^[\0-9\-\(\)\s]*$/;

            if (!phone.match(phoneReg)){
                alert(" please validate phone number");
                return false;
            }
            return true;

        }


        $('.numbercheck').bind('input propertychange',function(){
            var number = $('.numbercheck').val();
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            $.ajax({
                type:'post',
                url:'{{route('numberCheck')}}',
                data:{_token: CSRF_TOKEN,'number':number},
                success : function(data)
                {

                    if(data >0)
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
        $('.websitecheck').bind('input propertychange',function(){
            var website = $('.websitecheck').val();
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            $.ajax({
                type:'post',
                url:'{{route('websiteCheck')}}',
                data:{_token: CSRF_TOKEN,'website':website},
                success : function(data)
                {

                    if(data >0)
                    {
                        document.getElementById('exceedwebsite').style.display="inline";
                    }
                    else
                    {
                        document.getElementById('exceedwebsite').style.display="none";
                    }
                }
            });
        });
        $('.companyNamecheck').bind('input propertychange',function(){
            var companyName = $('.companyNamecheck').val();
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            $.ajax({
                type:'post',
                url:'{{route('comapanyNameCheck')}}',
                data:{_token: CSRF_TOKEN,'companyName':companyName},
                success : function(data)
                {

                    if(data >0)
                    {
                        document.getElementById('exceedcompany').style.display="inline";
                    }
                    else
                    {
                        document.getElementById('exceedcompany').style.display="none";
                    }
                }
            });
        });


        $(function() {
            $('#myTable').dataTable({
                aLengthMenu: [
                    [25, 50, 100, 200, 1000, -1],
                    [25, 50, 100, 200, 1000]
                ],
                "iDisplayLength": 100,
                processing: true,
                serverSide: true,
                stateSave: true,
                Filter: true,
                type:"POST",
                "ajax":{
                    "url": "{!! route('allLeads') !!}",
                    "type": "POST",
                    "data":{ _token: "{{csrf_token()}}"}
                },
                {{--ajax: '{!! route('test') !!}',--}}
                columns: [
                    { data: 'leadId', name: 'leads.leadId' },
                    { data: 'companyName', name: 'leads.companyName' },
                    { data: 'website', name: 'leads.website' },
                    { data: 'contactNumber', name: 'leads.contactNumber'},
                    { data: 'category.categoryName', name: 'category.categoryName'},
                    { data: 'country.countryName', name: 'country.countryName'},
                    {data: 'contact.firstName', name: 'contact.firstName', defaultContent: ''},
                    {data: 'personName', name: 'personName', defaultContent: ''},
                    { data: 'status.statusName', name: 'status.statusName',defaultContent: ''},
                    { data: 'possibility.possibilityName', name: 'possibility.possibilityName',defaultContent: ''},
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
                    { data: 'volume', name: 'leads.volume' },
                    { data: 'process', name: 'leads.process' },
                    { data: 'frequency', name: 'leads.frequency' },
                    { data: 'created_at', name: 'created_at',defaultContent: ''},
                    {data: 'action', name: 'action', orderable: false, searchable: false}


                ]
            });
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


        $('#my_modal').on('show.bs.modal', function(e) {
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
            var country=$(e.relatedTarget).data('lead-country');
            var designation=$(e.relatedTarget).data('lead-designation');
            var founded=$(e.relatedTarget).data('lead-founded');
            var employee=$(e.relatedTarget).data('lead-employee');
            var volume=$(e.relatedTarget).data('lead-volume');
            var frequency=$(e.relatedTarget).data('lead-frequency');
            var process=$(e.relatedTarget).data('lead-process');
            var comments=$(e.relatedTarget).data('lead-comments');
            var createdAt=$(e.relatedTarget).data('lead-created');



            console.log(comments);

            //populate the textbox
            $('#country').val(country);
            $('#category').val(category);
            // $('div.mined').text('Lead was mined by '+minedBy+' at '+createdAt);
            // $('div.leadId').text('Lead Id: '+leadId);
            $('div.mineIdDate').text(leadId+' was mined by '+minedBy+' at '+createdAt);
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
            $('#comments').val(comments);

//            $(e.currentTarget).find('#reject').attr('href', '/lead/reject/'+leadId);
            @if(Auth::user()->typeId == 4 || Auth::user()->typeId == 5 )

            $(e.currentTarget).find('input[name="companyName"]').attr('readonly', true);
            //$(e.currentTarget).find('input[name="website"]').attr('readonly', true);


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



    </script>


@endsection
