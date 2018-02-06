

@extends('main')

@section('header')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.0/jquery-confirm.min.css">
@endsection

@section('content')


    <div class="card" style="padding: 2px;" id="card">
        <div class="card-body">
            <h2 class="card-title" align="center"><b>Temp Leads</b></h2>


            <a href="#create_temp_modal" data-toggle="modal" class="btn btn-info btn-md"><i class="fa fa-plus"></i></a>

            <div class="table-responsive m-t-40" >
                <table id="myTable" class="table table-striped table-condensed" style="font-size:14px;">
                    <thead>
                    <tr>
                        <th>Mined By</th>
                        <th>Company Name</th>
                        <th>Category</th>
                        <th>Website</th>
                        <th>Created At</th>
                        <th>Set Possibility</th>
                        <th>Action</th>

                    </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>


 {{--Create temp lead--}}

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

                        {!! $errors->first('companyName', '<p class="help-block">:message</p>') !!}

                        <input type="text" class="form-control" id="" placeholder="Enter Company Name" name="companyName" required>

                    </div>


                    <div class="form-group col-md-5">
                        <label class="control-label" ><b>Website</b></label>
                        {!! $errors->first('website', '<p class="help-block">:message</p>') !!}
                        <input type="text" class="form-control" name="website" placeholder="Enter url" required>

                    </div>

                    <div class="form-group col-md-5" style="">
                        <label class="control-label" ><b>Contact Person</b></label>
                        {!! $errors->first('personName', '<p class="help-block">:message</p>') !!}
                        <input type="text" class="form-control" id="" name="personName" placeholder="name" required>

                    </div>


                    <div class="form-group col-md-5">
                        <label class="control-label" ><b> Email:</b></label>
                        {!! $errors->first('email', '<p class="help-block">:message</p>') !!}
                        <input type="email" class="form-control" name="email" id="email" placeholder="Enter email" required>

                    </div>

                    <div class="form-group col-md-5">
                        <label class="control-label" ><b>Contact Number</b></label>
                        {!! $errors->first('personNumber', '<p class="help-block">:message</p>') !!}
                        <input type="text" class="form-control" id="personNumber" name="personNumber" placeholder="Enter Phone Number" required>
                    </div>

                    <div class="form-group col-md-5">
                        <label class="control-label " ><b>Designation</b></label>
                        {!! $errors->first('designation', '<p class="help-block">:message</p>') !!}
                        <input type="text" class="form-control" name="designation" placeholder="Enter Person Designation" required>

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
                        <select class="select form-control" id="" name="country">
                            @foreach($countries as $c)
                                <option value="{{$c->countryId}}">{{$c->countryName}}</option>
                            @endforeach
                        </select>
                    </div>






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




    <!-- Modal -->
    <div class="modal" id="my_modal" style="">
        <div class="modal-dialog" style="max-width: 60%">

            <form class="modal-content" method="post" action="{{route('leadUpdate')}}" onsubmit="return chkValidate()">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title" name="modal-title">Edit Temp Lead</h4>
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

                        <div class="col-md-8">
                            <button class="btn btn-success" type="submit">Update</button>
                        </div>

                        <div class="col-md-4">
                            <a id="reject" class="btn btn-danger" onclick="return confirm('Are you sure you want to reject this Lead?')">Reject</a>
                        </div>



                    </div>




                </div>




                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div></form>
        </div>
    </div>
    </div>

@endsection

@section('foot-js')

    <script src="{{url('assets/plugins/datatables/jquery.dataTables.min.js')}}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>


    <script src="{{url('cdn.datatables.net/buttons/1.2.2/js/dataTables.buttons.min.js')}}"></script>
    <script src="{{url('cdn.datatables.net/buttons/1.2.2/js/buttons.flash.min.js')}}"></script>



    <script src="{{url('cdn.datatables.net/buttons/1.2.2/js/buttons.html5.min.js')}}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.0/jquery-confirm.min.js"></script>

    <meta name="csrf-token" content="{{ csrf_token() }}" />



    <script>
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


        $('#my_modal').on('show.bs.modal', function(e) {
            //get data-id attribute of the clicked element
            var leadId = $(e.relatedTarget).data('lead-id');
            var leadName = $(e.relatedTarget).data('lead-name');
            var email = $(e.relatedTarget).data('lead-email');
            var number = $(e.relatedTarget).data('lead-number');
            var personName = $(e.relatedTarget).data('lead-person');
            var website = $(e.relatedTarget).data('lead-website');
            var category=$(e.relatedTarget).data('lead-category');
            var minedBy=$(e.relatedTarget).data('lead-mined');

            //populate the textbox
            $('#category').val(category);
            $('div.mined').text(minedBy);
            $(e.currentTarget).find('input[name="leadId"]').val(leadId);
            $(e.currentTarget).find('input[name="companyName"]').val(leadName);
            $(e.currentTarget).find('input[name="email"]').val(email);
            $(e.currentTarget).find('input[name="number"]').val(number);
            $(e.currentTarget).find('input[name="personName"]').val(personName);
            $(e.currentTarget).find('input[name="website"]').val(website);
            $(e.currentTarget).find('#reject').attr('href', '/lead/reject/'+leadId);

        });




        $(document).ready(function () {

            $('#myTable').DataTable({
                "processing": true,
                "serverSide": true,
                stateSave: true,
                "ajax":{
                    "url": "{{ route('tempData')}}",
                    "dataType": "json",
                    "type": "POST",
                    "data":{ _token: "{{csrf_token()}}"}
                },
                "columns": [
                    { "data": "minedBy" },
                    { "data": "name" },
                    { "data": "category" },
                    { "data": "website" },
                    { "data": "createdAt" },
                    { "data": "possibility" },
                    { "data": "edit" }
                ]

            });
            $('#myTable tbody').on('change', '[id=drop]', function (e){
                var leadId = $(e.currentTarget).data('lead-id');
                var possibility=$(this).val();
                // alert($(this).val());
                var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
                jQuery(this).parents("tr").remove();
                $.ajax({
                    type : 'post',
                    url : '{{route('changePossibility')}}',
                    data : {_token: CSRF_TOKEN,'leadId':leadId,'possibility':possibility},
                    success : function(data){
                        console.log(data);
                        if(data == 'true'){
                            $('#alert').html(' <strong>Success!</strong> Possibility Changed');
                            $('#alert').show();
                        }
                    }
                });
            });
        });


    </script>


@endsection