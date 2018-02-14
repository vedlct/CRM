@extends('main')

@section('header')

    <link href="{{url('css/select2.min.css')}}" rel="stylesheet" />
@endsection

@section('content')

    {{--<div class="card" style="max-width: 100px;margin-top: 20px;">--}}<br><br>

    {{--</div>--}}



    <div class="card" style="padding:10px;">
        <div class="card-body">
            <a href="#create_temp_modal" data-toggle="modal" class="btn btn-info btn-md" style="border-radius: 50%; float: right;"><i class="fa fa-plus"></i></a>
            <h2 class="card-title" align="center"><b>All Leads</b></h2>

            <div class="table-responsive m-t-40">
                <table id="myTable" class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th>Company Name</th>
                        <th>website</th>
                        <th>Number</th>
                        <th>Category</th>
                        <th>Country</th>
                        <th>Contact</th>
                        <th>Status</th>
                        <th>Possibility</th>
                        <th>Edit</th>


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
                            <select class="select form-control" id="" name="country" style="width: 100%;">
                                @foreach($countries as $c)
                                    <option value="{{$c->countryId}}">{{$c->countryName}}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group col-md-5">
                            <label>Contact: &nbsp; </label><input type="checkbox" name="contact">
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

            <form class="modal-content" method="post" action="{{route('leadUpdate')}}">
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

                    </div>
                </div>



                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div></form>
        </div>
    </div>











@endsection




@section('bottom')




    <script src="{{url('js/select2.min.js')}}"></script>
    <script src="{{url('assets/plugins/datatables/jquery.dataTables.min.js')}}"></script>
    <script src="{{url('cdn.datatables.net/buttons/1.2.2/js/dataTables.buttons.min.js')}}"></script>
    <script src="{{url('cdn.datatables.net/buttons/1.2.2/js/buttons.flash.min.js')}}"></script>
    <script src="{{url('cdn.datatables.net/buttons/1.2.2/js/buttons.html5.min.js')}}"></script>

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



        $(function() {
            $('#myTable').DataTable({
                processing: true,
                serverSide: true,
                Filter: true,
                type:"POST",
                "ajax":{
                    "url": "{!! route('allLeads') !!}",
                    "type": "POST",
                    "data":{ _token: "{{csrf_token()}}"}
                },
                {{--ajax: '{!! route('test') !!}',--}}
                columns: [
                    { data: 'companyName', name: 'leads.companyName' },
                    { data: 'website', name: 'leads.website' },
                    { data: 'contactNumber', name: 'leads.contactNumber'},
                    { data: 'category.categoryName', name: 'category.categoryName'},
                    { data: 'country.countryName', name: 'country.countryName'},
                    {data: 'contact.firstName', name: 'contact.firstName', defaultContent: ''},
                    { data: 'status.statusName', name: 'status.statusName',defaultContent: ''},
                    { data: 'possibility.possibilityName', name: 'possibility.possibilityName',defaultContent: ''},
                    {data: 'action', name: 'action', orderable: false, searchable: false}


                ]
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


            //populate the textbox
            $('#category').val(category);
            $('div.mined').text(minedBy);
//            $(e.currentTarget).find('input[name="minedBy"]').val(minedBy);
            $(e.currentTarget).find('input[name="leadId"]').val(leadId);
            $(e.currentTarget).find('input[name="companyName"]').val(leadName);
            $(e.currentTarget).find('input[name="email"]').val(email);
            $(e.currentTarget).find('input[name="number"]').val(number);
            $(e.currentTarget).find('input[name="personName"]').val(personName);
            $(e.currentTarget).find('input[name="website"]').val(website);
            $(e.currentTarget).find('#reject').attr('href', '/lead/reject/'+leadId);

        });



    </script>


@endsection