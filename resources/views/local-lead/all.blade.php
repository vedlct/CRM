@extends('main')

@section('content')

<div class="card">
    <div class="card-body">

        <a href="#create_temp_modal" data-toggle="modal" class="btn btn-info btn-md" style="border-radius: 50%; float: right;"><i class="fa fa-plus"></i></a>

        <div class="table-responsive m-t-40">
            <table id="myTable" class="table table-bordered table-striped">
                <thead>
                <tr>
                    <th width="20%">Company Name</th>
                    <th width="20%">website</th>
                    <th width="15%">Number</th>
                    <th width="15%">Tnt Number</th>
                    <th width="10%">Category</th>
                    <th width="10%">Area</th>
                    <th width="10%">Address</th>
                    <th width="5%">Status</th>
                    <th width="8%">Possibility</th>
                    <th width="10%">Action</th>


                </tr>
                </thead>
                <tbody>



                </tbody>
            </table>
        </div>


    </div>
</div>

     {{--Add Lead Modal--}}

<div class="modal" id="create_temp_modal" style="">
    <div class="modal-dialog" style="max-width: 60%;">

        <form class="modal-content" action="{{route('local.storeLead')}}" method="POST">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title" name="modal-title">Create Lead</h4>
            </div>

            <div class="container-fluid">
                <div class="row">
                    {{csrf_field()}}
                    <br>
                    <div class="form-group col-md-5">
                        <label class="control-label " ><b>Company Name</b></label>

                        {!! $errors->first('companyName', '<p class="help-block">:message</p>') !!}

                        <input type="text" class="form-control" id="" placeholder="Enter Company Name" name="companyName" required>
                    </div>


                    <div class="form-group col-md-5">
                        <label class="control-label" ><b>Website</b></label>
                        {!! $errors->first('website', '<p class="help-block">:message</p>') !!}
                        <input type="text" class="form-control" name="website" placeholder="Enter url" >

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
                        <label class="control-label" ><b>Mobile Number</b></label>
                        <span id="exceed" style="color:red;display: none"><i>This number already exist</i></span></label>
                        {!! $errors->first('personNumber', '<p class="help-block">:message</p>') !!}
                        <input type="text" class="form-control numbercheck" id="personNumber" name="mobile" placeholder="Enter Phone Number" required>
                    </div>

                    <div class="form-group col-md-5">
                        <label class="control-label" ><b>Tnt Number</b></label>

                        <input type="text" class="form-control numbercheck" id="personNumber" name="tnt" placeholder="Enter Phone Number" required>
                    </div>




                    <div class="form-group col-md-5" style="">
                        <label ><b>Category:</b></label>
                        <select class="form-control" id="" name="category" >
                            @foreach($categories as $cat)
                                <option value="{{$cat->categoryId}}">{{$cat->categoryName}}</option>

                            @endforeach
                        </select>
                    </div>





                    <div class="form-group col-md-5">

                        <label for="sel1"><b>Area:</b></label>
                        <select class="form-control" id="" name="areaId" required>
                            <option value="">Select Area</option>
                            @foreach($areas as $area)
                                <option value="{{$area->areaId}}">{{$area->areaName}}</option>

                            @endforeach
                        </select>
                    </div>

                    <div class="form-group col-md-5">

                        <label for="sel1"><b>Address:</b></label>
                        <textarea name="address" class="form-control"></textarea>
                    </div>

                    <div class="form-group col-md-5" style="">
                        <label ><b>Possibility:</b></label>
                        <select class="form-control" id="" name="possibility">
                            @foreach($possibilities as $possibility)
                                <option value="{{$possibility->possibilityId}}">{{$possibility->possibilityName}}</option>

                            @endforeach
                        </select>

                    </div>

                    <div class="form-group col-md-5">
                        <br><br>
                        <label><b>Contact: </b>&nbsp; </label><input type="checkbox" name="contact">
                    </div>




                    <div class="form-group col-md-10">
                        <label class="control-label " ><b>Comments</b></label>

                        {!! $errors->first('comment', '<p class="help-block">:message</p>') !!}


                        <textarea name="comment" rows="4"  class="form-control"></textarea>
                    </div>




                </div>



                <div id="allServices" >
                    <label ><b>Services:</b></label>
                    <div class="form-group col-md-6" style="" >
                        <select class="form-control" id="" name="services[]" required>
                            <option value="">Select service</option>
                            @foreach($services as $service)
                                <option value="{{$service->local_serviceId}}">{{$service->serviceName}}</option>
                            @endforeach
                        </select>
                    </div>

                </div>



                <button type="button" id="addButton" class="btn btn-info">add more</button>
                <button type="button" id="removeButton" class="btn btn-danger">remove</button>

                <button type="submit" class="btn btn-success btn-md" style="width: 30%; margin-left: 20px;">Insert</button>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>


        </form>
    </div>
</div>




{{-- End Add Lead Modal--}}



{{--Edit Lead Modal--}}


<div style="text-align: center;" class="modal" id="editLeadModal" >
    <div class="modal-dialog" style="max-width: 60%;">
        <div class="modal-content" >
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Edit Lead</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <!-- Modal body -->
            <div class="modal-body" id="">
                <div id="editLeadModalBody">


                </div>


            </div>
            <!-- Modal footer -->
            <div class="modal-footer">

                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            </div>

        </div>
    </div>
</div>





{{-- End Add Lead Modal--}}




@endsection
@section('bottom')




    {{--<script src="{{url('js/select2.min.js')}}"></script>--}}
    <script src="{{url('assets/plugins/datatables/jquery.dataTables.min.js')}}"></script>
    <script src="{{url('cdn.datatables.net/buttons/1.2.2/js/dataTables.buttons.min.js')}}"></script>
    <script src="{{url('cdn.datatables.net/buttons/1.2.2/js/buttons.flash.min.js')}}"></script>
    <script src="{{url('cdn.datatables.net/buttons/1.2.2/js/buttons.html5.min.js')}}"></script>

    <script>


        $(document).ready(function(){

            var arr=[];

            var i;


            @foreach($services as $service)
                arr.push('<option id="s'+i+'" value="{{$service->local_serviceId}}">{{$service->serviceName}}</option>');
            @endforeach


            var counter = 2;
            $("#addButton").click(function () {
                if(counter>10){
                    alert("Only 10 textboxes allow");
                    return false;
                }

                var newTextBoxDiv = $(document.createElement('div'))
                    .attr("id", 'TextBoxDiv' + counter).attr("class", 'row');

                newTextBoxDiv.after().html('<div class="form-group col-md-6" > ' +
                    '<select class="form-control" id="" name="services[]" required>' +
                    '<option value="">Select service</option>'+
                        arr+
                    '</select> ' +
                    '</div>'
                );
                newTextBoxDiv.appendTo("#allServices");
                counter++;

            });


            $("#removeButton").click(function () {
                if(counter==2){
                    alert("nothing to remove");
                    return false;
                }
                counter--;
                $("#TextBoxDiv" + counter).remove();
            });
            function serviceSelected(x){
                console.log(x);

            }
        });

    </script>

    <script>
        $(function() {
            $('#myTable').DataTable({
                processing: true,
                serverSide: true,
                stateSave: true,
                Filter: true,
                type:"POST",
                "ajax":{
                    "url": "{!! route('local.getLeadData') !!}",
                    "type": "POST",
                    "data":{ _token: "{{csrf_token()}}"}
                },
                {{--ajax: '{!! route('test') !!}',--}}
                columns: [
                    { data: 'companyName', name: 'companyName' },
                    { data: 'website', name: 'website' },
                    { data: 'mobile', name: 'mobile'},
                    { data: 'tnt', name: 'tnt'},
                    { data: 'categoryName', name: 'categoryName'},
                    { data: 'areaName', name: 'areaName'},
                    {data: 'address', name: 'address'},
                    { data: 'statusId', name: 'statusId'},
                    { data: 'possibilityName', name: 'possibilityName'},
                    { "data": function(data){

                            return '<a class="btn btn-default btn-sm" data-panel-id="'+data.local_leadId+'" onclick="editLead(this)"><i class="fa fa-edit"></i></a>'+
                            '<a class="btn btn-default btn-sm" data-panel-id="'+data.local_leadId+'" onclick="getLeadComment(this)"><i class="fa fa-comments"></i></a>'
                            ;},
                        "orderable": false, "searchable":false, "name":"selected_rows" },
                ]
            });

        });


        function editLead(x) {
            var leadId=$(x).data('panel-id');

            $.ajax({
            type: 'POST',
            url: "{!! route('local.getEditModal') !!}",
            cache: false,
            data: {_token: "{{csrf_token()}}",'leadId': leadId},
            success: function (data) {
            $("#editLeadModalBody").html(data);
            $("#editLeadModal").modal();
//            console.log(data);
            }
            });



        }
        function getLeadComment(x) {
//            alert(x);
           var leadId=$(x).data('panel-id');
            alert(leadId);

        }
    </script>


@endsection