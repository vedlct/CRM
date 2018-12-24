@extends('main')

@section('content')
<br>
<div class="card">
    <div class="card-header">
        <div class="row">
            <div class="col-md-3">
                <select class="form-control" id="companyFilter" onchange="refreshTable()">
                    <option value="">Select Company</option>
                    @foreach($companies as $company)
                        <option value="{{$company->local_companyId}}">{{$company->companyName}}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <select class="form-control" id="areaFilter" onchange="refreshTable()">
                    <option value="">Select Area</option>
                    @foreach($areas as $area)
                        <option value="{{$area->areaId}}">{{$area->areaName}}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <select class="form-control" id="categoryFilter" onchange="refreshTable()">
                    <option value="">Select Category</option>
                    @foreach($categories as $category)
                        <option value="{{$category->categoryId}}">{{$category->categoryName}}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <select class="form-control" id="serviceFilter" onchange="refreshTable()">
                    <option value="">Select Service</option>
                    @foreach($services as $service)
                        <option value="{{$service->local_serviceId}}">{{$service->serviceName}}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>
    <div class="card-body">

        <a href="#create_temp_modal" data-toggle="modal" class="btn btn-info btn-md" style="border-radius: 50%; float: right;"><i class="fa fa-plus"></i></a>

        <div class="table-responsive m-t-40">
            <table id="myTable" class="table table-bordered table-striped">
                <thead>
                <tr>
                    <th width="15%">Lead Name</th>
                    <th width="15%">Company Name</th>
                    <th width="10%">website</th>
                    <th width="10%">Number</th>
                    <th width="10%">Tnt Number</th>
                    <th width="10%">Category</th>
                    <th width="10%">Area</th>
                    <th width="10%">Status</th>
                    <th width="5%">Possibility</th>
                    <th width="5%">Action</th>

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


                    <div class="form-group col-md-12" id="companyDiv">
                        <label class="control-label " ><b>Company Name</b></label>
                        <select class="form-control" name="local_companyId" required>
                            <option value="">Select Company</option>
                            @foreach($companies as $company)
                                <option value="{{$company->local_companyId}}">{{$company->companyName}}</option>
                            @endforeach
                        </select>
                        <br>
                        <button class="btn btn-info btn-sm pull-left" type="button" onclick="addCompany()">Add New Company</button>
                    </div>

                    <div class="form-group col-md-5">
                        <label class="control-label " ><b>Lead Name</b></label>

                        {!! $errors->first('leadName', '<p class="help-block">:message</p>') !!}

                        <input type="text" class="form-control" id="" placeholder="Enter Lead Name" name="leadName" required>
                    </div>




                    <div class="form-group col-md-5" style="">
                        <label ><b>Category:</b></label>
                        <select class="form-control" id="" name="category" >
                            @foreach($categories as $cat)
                                <option value="{{$cat->categoryId}}">{{$cat->categoryName}}</option>

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

                    <div class="form-group col-md-5">
                        <br><br>
                        <label><b>Contact: </b>&nbsp; </label><input type="checkbox" name="contact">
                    </div>
                    <div class="form-group col-md-5">

                        <label for="sel1"><b>Status:</b></label>
                        <select class="form-control" id="" name="statusId" required>
                            <option value="">Select Status</option>
                            @foreach($status as $s)
                                <option value="{{$s->local_statusId}}" >{{$s->statusName}}</option>
                            @endforeach
                        </select>
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

        function addCompany() {
            var options=[];
            @foreach($areas as $area)
                options.push('<option value="{{$area->areaId}}">{{$area->areaName}}</option>')
            @endforeach
            var body='<h4 align="center">Add Company</h4>'+
            '<div class="row"> ' +
            '<div class="form-group col-md-4"> ' +
            '<label>Company Name</label> '+
           '<input class="form-control" name="companyName" placeholder="name"> ' +
            '</div> ' +
            '<div class="form-group col-md-4"> ' +
            '<label>Website</label> ' +
            '<input class="form-control" name="website" placeholder="www"> ' +
            '</div> ' +
            '<div class="form-group col-md-4"> ' +
            '<label>Contact Person</label> ' +
            '<input class="form-control" name="contactPerson" placeholder="person name"> ' +
            '</div> ' +
            '<div class="form-group col-md-4"> ' +
            '<label>Email</label> ' +
            '<input class="form-control" name="email" placeholder="email"> ' +
            '</div> ' +
                '<div class="form-group col-md-4"> ' +
                '<label>Contact Number</label> ' +
                '<input class="form-control" name="mobile" placeholder="mobile"> ' +
                '</div> ' +
                '<div class="form-group col-md-4"> ' +
                '<label>Tnt Number</label> ' +
                '<input class="form-control" name="tnt" placeholder="tnt"> ' +
                '</div> ' +
                '<div class="form-group col-md-4"> ' +
                '<label>Area</label> ' +
                '<select class="form-control" name="areaId" required>' +
                    options+
                '</select>'+
                '</div>'+
                '<div class="form-group col-md-4">' +
                '<label>Address</label> ' +
                '<textarea class="form-control" name="address" placeholder="address..." rows="5"></textarea> ' +
                '</div>';

            $('#companyDiv').html(body);
        }


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
            dataTable=$('#myTable').DataTable({
                processing: true,
                serverSide: true,
                stateSave: true,
                Filter: true,
                type:"POST",
                "ajax":{
                    "url": "{!! route('local.getLeadData') !!}",
                    "type": "POST",
                    data:function (d){
                        d._token="{{csrf_token()}}";
                        d.companyFilter=$('#companyFilter').val();
                        d.areaFilter=$('#areaFilter').val();
                        d.categoryFilter=$('#categoryFilter').val();
                        d.serviceFilter=$('#serviceFilter').val();

                    }
                },
                columns: [
                    { data: 'leadName', name: 'leadName' },
                    { data: 'companyName', name: 'companyName' },
                    { data: 'website', name: 'website' },
                    { data: 'mobile', name: 'mobile'},
                    { data: 'tnt', name: 'tnt'},
                    { data: 'categoryName', name: 'categoryName'},
                    { data: 'areaName', name: 'areaName'},
                    {data: 'statusName', name: 'statusName'},
                    { data: 'possibilityName', name: 'possibilityName'},
                    { "data": function(data){

                            return '<a class="btn btn-default btn-sm" data-panel-id="'+data.local_leadId+'" onclick="editLead(this)"><i class="fa fa-edit"></i></a>'+
                            '<a class="btn btn-default btn-sm" data-panel-id="'+data.local_leadId+'" onclick="getLeadComment(this)"><i class="fa fa-comments"></i></a>'
                            ;},
                        "orderable": false, "searchable":false, "name":"selected_rows" },
                ]
            });

        });
        
        function refreshTable() {
            dataTable.ajax.reload();
        }


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
            }
            });



        }
        function getLeadComment(x) {
//            alert(x);
           var leadId=$(x).data('panel-id');
            $.ajax({
                type: 'POST',
                url: "{!! route('local.getFollowupModal') !!}",
                cache: false,
                data: {_token: "{{csrf_token()}}",'leadId': leadId},
                success: function (data) {
                    $("#editLeadModalBody").html(data);
                    $("#editLeadModal").modal();
                }
            });

        }
    </script>


@endsection