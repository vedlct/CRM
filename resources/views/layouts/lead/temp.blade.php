

@extends('main')

@section('header')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.0/jquery-confirm.min.css">
@endsection

@section('content')


    <div class="card" style="padding: 2px;">
        <div class="card-body">
            <h2 class="card-title" align="center">Temp Leads</h2>

            <div class="table-responsive m-t-40" >
                <table id="myTable" class="table table-striped table-condensed" style="font-size:14px;">
                    <thead>
                    <tr>
                        <th>Company Name</th>
                        <th>Category</th>
                        <th>Website</th>
                        <th>Contact Person</th>
                        <th>Contact Number</th>
                        <th>Email</th>
                        <th>Country</th>
                        {{--<th>Comments</th>--}}
                        {{--<th>Mined By</th>--}}
                        <th>Created At</th>
                        <th>Set Possibility</th>
                        <th>Action</th>

                    </tr>
                    </thead>
                    <tbody>


                    @foreach($leads as $lead)
                        <tr>
                           <td>{{$lead->companyName}}</td>
                            <td>{{$lead->category->categoryName}}</td>
                            <td>{{$lead->website}}</td>
                            <td>{{$lead->personName}}</td>
                            <td>{{$lead->contactNumber}}</td>
                            <td>{{$lead->email}}</td>
                            <td>{{$lead->country->countryName}}</td>
                            {{--<td>{{$lead->comments}}</td>--}}
                            {{--<td>{{$lead->mined->firstName}}</td>--}}
                            <td>{{$lead->created_at}}</td>
                            <td>




                                    <select class="form-control" id="drop" data-lead-id="{{$lead->leadId}}" name="possibility" >
                                        <option value="">Select</option>
                                        @foreach($possibilities as $p)
                                            <option value="{{$p->possibilityId}}">{{$p->possibilityName}}</option>
                                        @endforeach
                                    </select>


                            </td>

                            <td>
                                <form method="post" action="{{ URL::to('lead/' . $lead->leadId) }}" onsubmit="return confirm('Do you really want to Delete?');">
                                    {{csrf_field()}}
                                    {{ method_field('DELETE') }}

                                    <!-- Trigger the modal with a button -->
                                        <a href="#my_modal" data-toggle="modal" class="btn btn-info btn-sm"
                                                data-lead-id="{{$lead->leadId}}"
                                                data-lead-name="{{$lead->companyName}}"
                                                data-lead-email="{{$lead->email}}"
                                                data-lead-number="{{$lead->contactNumber}}"
                                                data-lead-person="{{$lead->personName}}"
                                                data-lead-website="{{$lead->website}}">
                                            <i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>

                                    <button type="submit" class="btn btn-danger btn-sm">
                                        <i class="fa fa-trash"></i></button></form>





                            </td>
                        </tr>
                    @endforeach

                    </tbody>
                </table>
            </div>
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
                        <button class="btn btn-success" type="submit">Update</button></div>

                </div></div>




                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div></form>
            </div>
        </div>
    </div>

@endsection

@section('foot-js')

    <script src="{{asset('assets/plugins/datatables/jquery.dataTables.min.js')}}"></script>



    <script src="{{asset('cdn.datatables.net/buttons/1.2.2/js/dataTables.buttons.min.js')}}"></script>
    <script src="{{asset('cdn.datatables.net/buttons/1.2.2/js/buttons.flash.min.js')}}"></script>



    <script src="{{asset('cdn.datatables.net/buttons/1.2.2/js/buttons.html5.min.js')}}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.0/jquery-confirm.min.js"></script>

    <meta name="csrf-token" content="{{ csrf_token() }}" />



    <script>

        // function drop(selectObject) {
        //     var value = selectObject.id;
        //     alert(value);
        // }
        $("[id*=drop]").change(function(e) {
            var leadId = $(e.currentTarget).data('lead-id');
            var possibility=$(this).val();
            // alert($(this).val());
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            jQuery(this).parents("tr").remove();

            $.ajax({
                type : 'post' ,
                url : '{{route('changePossibility')}}',
                data : {_token: CSRF_TOKEN,'leadId':leadId,'possibility':possibility} ,
                success : function(data){
                    console.log(data);
                    if(data == 'true'){


                        $('#myTable').load(document.URL +  ' #myTable');
                        $.alert({
                            title: 'Success!',
                            content: 'successfully Changed!',
                        });
                        //  alert('successfully assigned');
                    }
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

            //populate the textbox
            $(e.currentTarget).find('input[name="leadId"]').val(leadId);
            $(e.currentTarget).find('input[name="companyName"]').val(leadName);
            $(e.currentTarget).find('input[name="email"]').val(email);
            $(e.currentTarget).find('input[name="number"]').val(number);
            $(e.currentTarget).find('input[name="personName"]').val(personName);
            $(e.currentTarget).find('input[name="website"]').val(website);

        });


        $(document).ready(function() {


            $('#myTable').DataTable(
                {    responsive: true,
                    "order": [[ 7, "desc" ]]
                }
            );

        });







    </script>


@endsection

