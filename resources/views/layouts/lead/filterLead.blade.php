@extends('main')

@section('content')

    {{--get user type from session--}}
    @php($userType = strtoupper(Auth::user()->userType->typeName))

    <div class="card" style="padding:10px;">
        <div class="card-body">
            <h2 class="card-title" align="center"><b>Filtered Lead</b></h2>

            <div class="table-responsive m-t-40">
                <table id="myTable" class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th>Company Name</th>
                        <th>website</th>
                        <th>Number</th>
                        <th>Category</th>
                        <th>Country</th>
                        <th>Possibility</th>
                        <th>Date</th>


                        {{--@if($userType=='USER' || $userType=='RA' || $userType=='MANAGER')--}}
                        <th>Contacted</th>
                        {{--@endif--}}
                    </tr>
                    </thead>
                    <tbody>



                    </tbody>
                </table>
            </div>
        </div>
    </div>







    <!--Edit Modal -->
    <div class="modal" id="my_modal" style="">
        <div class="modal-dialog" style="max-width: 60%">
            <div class="modal-content">
                <form class="" method="post" action="{{route('leadUpdate')}}">
                    <div class="modal-header">
                        <h4 class="modal-title" name="modal-title">Edit Temp Lead</h4>
                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    </div>
                    <div class="modal-body">

                        {{csrf_field()}}
                        <div class="row">

                            <div class="col-md-12" align="center">
                                <label><b > Mined By:</b></label>  <div class="mined" id="mined"></div>
                                {{--<input type="text" class="form-control" name="minedBy" value="">--}}

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
                                <input type="text" class="form-control" name="personName" value=""> <br><br><br>
                            </div>


                            <div class="col-md-4">
                                <label><b>Number:</b></label>
                                <input type="text" class="form-control" name="number" value="">
                            </div>

                            <div class="col-md-4">
                                <label><b>Website:</b></label>
                                <input type="text" class="form-control" name="website" value=""> <br><br><br>
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
    </div>












@endsection

@section('foot-js')
    <script src="{{url('assets/plugins/datatables/jquery.dataTables.min.js')}}"></script>
    <script src="{{url('cdn.datatables.net/buttons/1.2.2/js/dataTables.buttons.min.js')}}"></script>
    <script src="{{url('cdn.datatables.net/buttons/1.2.2/js/buttons.flash.min.js')}}"></script>
    <script src="{{url('cdn.datatables.net/buttons/1.2.2/js/buttons.html5.min.js')}}"></script>

    <script>
        //        $(document).ready(function() {
        //            $('#myTable').DataTable();
        //
        //        });

        //<th>Company Name</th>
        //<th>Person</th>
        //<th>Email</th>
        //<th>Number</th>
        //<th>Category</th>
        //<th>Country</th>
        $(function() {
            $('#myTable').DataTable({
                aLengthMenu: [
                    [25, 50, 100, 200, 1000, -1],
                    [25, 50, 100, 200, 1000]
                ],
                "iDisplayLength": 100,
                processing: true,
                serverSide: true,
                Filter: true,
                stateSave: true,
                type:"POST",
                "ajax":{
                    "url": "{!! route('filterLeadData') !!}",
                    "type": "POST",
                    "data":{ _token: "{{csrf_token()}}"}
                },
                {{--ajax: '{!! route('test') !!}',--}}
                columns: [
                    { data: 'companyName', name: 'leads.companyName' },
                    { data: 'website', name: 'leads.website'},
                    { data: 'contactNumber', name: 'leads.contactNumber'},
                    { data: 'category.categoryName', name: 'category.categoryName'},
                    { data: 'country.countryName', name: 'country.countryName'},
                    { data: 'possibility.possibilityName', name: 'possibility.possibilityName'},
                    { data: 'created_at', name: 'created_at'},
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
            var country=$(e.relatedTarget).data('lead-country');
            var designation=$(e.relatedTarget).data('lead-designation');
            var comments=$(e.relatedTarget).data('lead-comments');




            //populate the textbox
            $('#country').val(country);
            $('#category').val(category);
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
//            $(e.currentTarget).find('#reject').attr('href', '/lead/reject/'+leadId);

            @if(Auth::user()->typeId == 4 || Auth::user()->typeId == 5 )

            $(e.currentTarget).find('input[name="companyName"]').attr('readonly', true);
            $(e.currentTarget).find('input[name="website"]').attr('readonly', true);

            @endif

        });


    </script>
@endsection
