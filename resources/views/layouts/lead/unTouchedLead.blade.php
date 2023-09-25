@extends('main')

@section('header')
    <link rel="stylesheet" href="{{url('css/jconfirm.css')}}">
    <link rel="stylesheet" href="{{ url('public/css/custom-style.css') }}">

@endsection

@section('content')

    @php($userType = strtoupper(Auth::user()->userType->typeName))

    <div class="card" style="padding:10px;">
        <div class="card-body">
            <h2  align="center"><b>Untocuhed Leads</b></h2>
            <!-- <p class="card-subtitle" align="center"  style="color:red;"><b>Caution:</b> if you click on Red button, it will be rejected and removed from this list.</h2> -->

            <div class="table-responsive m-t-40">
                <table id="myTable" class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th>Select</th>
                        <th>Lead Id</th>
                        <th>website</th>
                        <th>Number</th>
                        <th>Category</th>
                        <th>Country</th>
                        <th>Possibility</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>

            <input type="checkbox" id="selectall" onClick="selectAll(this)" /><b>Select All</b>


            <div class="form-group">

                <label ><b>Assign to:</b></label>
                <select class="form-control"  name="assignTo" id="otherCatches" style="width: 30%">
                    <option value="">select</option>
                    @foreach($users as $user)
                        <option value="{{$user->id}}">{{$user->firstName}} {{$user->lastName}}</option>

                    @endforeach

                </select>
            </div>


            <input type="hidden" class="form-control" id="inp" name="leadId">
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

    <script src="{{ url('public/js/custom-alert.js') }}"></script>

    
<script>

        $(function() {
            $('#myTable').DataTable({
                processing: true,
                serverSide: true,
                Filter: true,
                stateSave: true,
                type:"POST",
                "ajax":{
                    "url": "{!! route('getUnTouchedLead') !!}",
                    "type": "POST",
                    "data":{ _token: "{{csrf_token()}}"}
                },
                columns: [
                    { data: 'check', name: 'check', orderable: false, searchable: false},

                    { data: 'leadId', name: 'leads.leadId'},
                    { data: 'website', name: 'leads.website'},
                    { data: 'contactNumber', name: 'leads.contactNumber'},
                    { data: 'category.categoryName', name: 'category.categoryName', defaultContent: ''},
                    { data: 'country.countryName', name: 'country.countryName', defaultContent: ''},
                    { data: 'possibility.possibilityName', name: 'possibility.possibilityName', defaultContent: ''},
                    { data: 'status.statusName', name: 'status.statusName', defaultContent: ''},
                    { data: 'action', name: 'action', orderable: false, searchable: false}

                ]
            });
        });

        
        $(document).on('click', '.lead-view-btn', function(e) {
                e.preventDefault();

                var leadId = $(this).data('lead-id');
                var newWindowUrl = '{{ url('/account') }}/' + leadId;

                window.open(newWindowUrl, '_blank');
            });


        function selectAll(source) {
            checkboxes = document.getElementsByName('checkboxvar[]');
            for(var i in checkboxes)
                checkboxes[i].checked = source.checked;
        }



      $('#lead_comments').on('show.bs.modal', function(e) {

            var leadId = $(e.relatedTarget).data('lead-id');
            var leadName = $(e.relatedTarget).data('lead-name');
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

            $(e.currentTarget).find('input[name="companyName"]').val(leadName);


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






        $("#otherCatches").change(function() {

            var chkArray = [];
            var userId=$(this).val();
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
                url : '{{route('assignStore')}}',
                data : {_token: CSRF_TOKEN,'leadId':chkArray,'userId':userId} ,
                success : function(data){
                    console.log(data);
                    if(data == 'true'){
                        successAlert('Leads are assigned successfully');

                    }
                }
            });



            });



    </script>
@endsection
