

@extends('main')

@section('header')
    <link rel="stylesheet" href="{{url('css/jconfirm.css')}}">
@endsection

@section('content')


    <div class="card" style="padding: 2px;" id="card">
        <div class="card-body">
            <h2 class="card-title" align="center"><b>Temp Leads</b></h2>




            <div class="table-responsive m-t-40" >
                <table id="myTable" class="table table-striped table-condensed" style="font-size:14px;">
                    <thead>
                    <tr>
                        <th width="2%">Mined By</th>
                        <th  width="10%">Company Name</th>
                        <th  width="5%">Category</th>
                        <th  width="10%">Website</th>
                        <th  width="5%">Number</th>
                        <th  width="5%">Country</th>
                        <th  width="4%">Possibility</th>
                        <th  width="5%">Set Possibility</th>
                        <th  width="4%">Action</th>

                    </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>



    <!-- Modal -->
    <div class="modal" id="my_modal" style="">
        <div class="modal-dialog" style="max-width: 60%">

            <div class="modal-content" >
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title" name="modal-title">Edit Temp Lead</h4>
                </div>
                <div class="modal-body">
                    <form method="post" action="{{route('leadUpdate')}}" onsubmit="return chkValidate()">


                    {{csrf_field()}}
                    <div class="row ">
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
                    </form>
                    <br><br>
                    @if(Session::get('userType') !='RA')
                    <form method="post" action="{{route('rejectStore')}}">
                    {{csrf_field()}}
                        <div class="row">

                                <div class="col-md-6">
                                    <input type="text" placeholder="comment for reject" name="comment" class="form-control">
                                    <input type="hidden" name="leadId">
                                </div>
                                <div class="col-md-6">
                                    <button id="reject" class="btn btn-danger" type="submit">Reject</button>
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


@endsection

@section('foot-js')

    <script src="{{url('assets/plugins/datatables/jquery.dataTables.min.js')}}"></script>
    <script src="{{url('js/select2.min.js')}}"></script>


    <script src="{{url('cdn.datatables.net/buttons/1.2.2/js/dataTables.buttons.min.js')}}"></script>
    <script src="{{url('cdn.datatables.net/buttons/1.2.2/js/buttons.flash.min.js')}}"></script>



    <script src="{{url('cdn.datatables.net/buttons/1.2.2/js/buttons.html5.min.js')}}"></script>
    <script src="{{url('js/jconfirm.js')}}"></script>
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
//            $(e.currentTarget).find('#reject').attr('href', '/lead/reject/'+leadId);

        });




        $(function() {
            $('#myTable').DataTable({
                processing: true,
                serverSide: true,
                Filter: true,
                stateSave: true,
                type:"POST",
                "ajax":{
                    "url": "{!! route('tempData') !!}",
                    "type": "POST",
                    "data":{ _token: "{{csrf_token()}}"},
                },
                columns: [
                    { data: 'mined.firstName', name: 'mined.firstName' },
                    { data: 'companyName', name: 'leads.companyName'},
                    { data: 'category.categoryName', name: 'category.categoryName'},
                    { data: 'website', name: 'leads.website'},
                    { data: 'contactNumber', name: 'leads.contactNumber'},
                    { data: 'country.countryName', name: 'country.countryName'},
                    { data: 'possibility.possibilityName', name: 'possibility.possibilityName',defaultContent: ''},
                    // { data: 'possibility.possibilityName', name: 'possibility.possibilityName'},
                     {data: 'action', name: 'action', orderable: false, searchable: false},
                     {data: 'edit', name: 'edit', orderable: false, searchable: false}

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