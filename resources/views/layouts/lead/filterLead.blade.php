@extends('main')

@section('content')

    {{--get user type from session--}}
    @php($userType = strtoupper(Auth::user()->userType->typeName))

    <div class="card" style="padding:10px;">
        <div class="card-body">
            <h2 class="card-title" align="center"><b>Filtered Lead</b></h2>
            <h4 class="card-subtitle" align="center">These leads are filtered by others.<span style="font-weight:450;"> Your filtered leads are not listed here.</span></h4>
            <!-- <p class="card-subtitle" align="center"  style="color:red;"><b>Caution:</b> if you click on Red button, it will be rejected and removed from this list.</h2> -->

            <div class="table-responsive m-t-40">
                <table id="myTable" class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th>Select</th>
                        <!-- <th>Id</th> -->
                        <!-- <th>Company Name</th> -->
                        <th>website</th>
                        <th>Number</th>
                        <!-- <th>KDM</th> -->
                        <th>Category</th>
                        <th>Country</th>
                        <th>Possibility</th>
                        <th >Volume</th>
                        <th >Process</th>
                        <!-- <th >Frequency</th> -->
                        <!-- <th >Cretaed Date</th> -->
                        <th >Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>

                <input type="checkbox" id="selectall" onClick="selectAll(this)" /><b>Select All</b>

                <div class="mt-2">
                    <input id = "makemy" type="submit" class="btn btn-outline-primary" value="Make My Lead"/>

                </div>

            </div>
        </div>
    </div>







    <!-- Edit Modal -->
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
                    <div class="card-body">
                        <b>Call Statistics per marketer</b>
                        <p>Here you will see who reached out to this company for how many times.</p>
                        <div id="counter"></div>
                    </div>

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
    <script src="{{url('js/select2.min.js')}}"></script>
    <script src="{{url('assets/plugins/datatables/jquery.dataTables.min.js')}}"></script>
    <script src="{{url('cdn.datatables.net/buttons/1.2.2/js/dataTables.buttons.min.js')}}"></script>
    <script src="{{url('cdn.datatables.net/buttons/1.2.2/js/buttons.flash.min.js')}}"></script>
    <script src="{{url('cdn.datatables.net/buttons/1.2.2/js/buttons.html5.min.js')}}"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}" />


    <script>

            $(document).ready(function() {
                $("#makemy").click(function(){
                    var chkArray = [];
                    //var userId=$(this).val();
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
                            url : '{{route('addmyContacted')}}',
                            data : {_token: CSRF_TOKEN,'leadId':chkArray} ,
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
            })

    </script>


<script>

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
                    { data: 'check', name: 'check', orderable: false, searchable: false},

                    // { data: 'leadId', name: 'leads.leadId' },
                    // { data: 'companyName', name: 'leads.companyName' },
                    { data: 'website', name: 'leads.website'},
                    { data: 'contactNumber', name: 'leads.contactNumber'},
                    // { data: 'personName', name: 'leads.personName'},
                    { data: 'category.categoryName', name: 'category.categoryName', defaultContent: ''},
                    { data: 'country.countryName', name: 'country.countryName', defaultContent: ''},
                    { data: 'possibility.possibilityName', name: 'possibility.possibilityName', defaultContent: ''},
                    {data: 'volume', name: 'volume', defaultContent: ''},
                    {data: 'process', name: 'process', defaultContent: ''},
                    // {data: 'frequency', name: 'frequency', defaultContent: ''},
                    // {data: 'created_at', name: 'created_at', defaultContent: ''},

                    {data: 'action', name: 'action', orderable: false, searchable: false}

                ]
            });
        });

 

        function selectAll(source) {
            checkboxes = document.getElementsByName('checkboxvar[]');
            for(var i in checkboxes)
                checkboxes[i].checked = source.checked;
        }





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
            //$(e.currentTarget).find('input[name="website"]').attr('readonly', true);

            @endif

        });


      $('#lead_comments').on('show.bs.modal', function(e) {

            var leadId = $(e.relatedTarget).data('lead-id');
            var leadName = $(e.relatedTarget).data('lead-name');
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

            $(e.currentTarget).find('input[name="companyName"]').val(leadName);

            // $.ajax({
            //     type : 'post' ,
            //     url : '{{route('getComments')}}',
            //     data : {_token: CSRF_TOKEN,'leadId':leadId} ,
            //     success : function(data){

            //         $("#comment").html(data);
            //         $("#comment").scrollTop($("#comment")[0].scrollHeight);
            //     }
            // });

            $.ajax({
                type: 'post',
                url: '{{ route('getComments') }}',
                data: {_token: CSRF_TOKEN, 'leadId': leadId},
                success: function(data) {
                    $('#comment').html(data.comments);
                    $("#comment").scrollTop($("#comment")[0].scrollHeight);

                    var counterHtml = '';

                    // Loop through the counter data
                    $.each(data.counter, function(index, counter) {
                        counterHtml += '<div><strong>' + counter.userId + '</strong> tried <strong>' + counter.userCounter + '</strong> times</div>';
                    });

                    // Set the counter HTML to the counter div
                    $('#counter').html(counterHtml);
                }
            });



        });


    </script>
@endsection
