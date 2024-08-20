@extends('main')

@section('content')

    {{--get user type from session--}}
    @php($userType = strtoupper(Auth::user()->userType->typeName))



    <div class="card" style="padding:10px;">
        <div class="card-body">
            <h2  align="center"><b>Filtered Lead</b></h2>

            <!-- Information Text -->
            <div class="alert alert-info" role="alert">
                <b>Please select the date range and filter. You will see the leads that are not filtered in the selected date range.</b>
            </div>

            <div class="row mb-4">
                <div class="col-md-4">
                    <label for="start_date">Start Date:</label>
                    <input type="date" id="start_date" class="form-control" />
                </div>
                <div class="col-md-4">
                    <label for="end_date">End Date:</label>
                    <input type="date" id="end_date" class="form-control" />
                </div>
                <div class="col-md-4">
                    <label for="">&nbsp;</label><br>
                    <button id="filter_leads" class="btn btn-primary">Filter Leads</button>
                </div>
            </div>



            <div class="table-responsive m-t-40">
                <table id="myTable" class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th>Select</th>
                        <th>website</th>
                        <th>Number</th>
                        <th>Category</th>
                        <th>Country</th>
                        <th>Possibility</th>
                        <th >Volume</th>
                        <th >Process</th>
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


    <script>

            $(document).ready(function() {
                $("#makemy").click(function(){
                    var chkArray = [];
                    //var userId=$(this).val();
                    $('.checkboxvar:checked').each(function (i) {

                        chkArray[i] = $(this).val();
                        });

                        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
                        jQuery('input:checkbox:checked').parents("tr").remove();
                        $(this).prop('selectedIndex',0);

                        $.ajax({
                            type : 'post' ,
                            url : '{{route('addmyContacted')}}',
                            data : {_token: CSRF_TOKEN,'leadId':chkArray} ,
                            success : function(data){
                                console.log(data);
                                if(data == 'true'){
                                    $('#alert').html('Leads are assigned successfully');
                                    $('#alert').show();

                                }
                            }
                        });
                });
            })

    </script>


<script>

        // $(function() {
        //     $('#myTable').DataTable({
        //         // aLengthMenu: [
        //         //     [25, 50, 100],
        //         //     [25, 50, 100]
        //         // ],
        //         // "iDisplayLength": 25,
        //         processing: true,
        //         serverSide: true,
        //         Filter: true,
        //         stateSave: true,
        //         type:"POST",
        //         "ajax":{
        //             "url": "{!! route('filterLeadData') !!}",
        //             "type": "POST",
        //             "data":{ _token: "{{csrf_token()}}"}
        //         },
        //         columns: [
        //             { data: 'check', name: 'check', orderable: false, searchable: false},

        //             { data: 'website', name: 'leads.website'},
        //             { data: 'contactNumber', name: 'leads.contactNumber'},
        //             { data: 'category.categoryName', name: 'category.categoryName', defaultContent: ''},
        //             { data: 'country.countryName', name: 'country.countryName', defaultContent: ''},
        //             { data: 'possibility.possibilityName', name: 'possibility.possibilityName', defaultContent: ''},
        //             { data: 'volume', name: 'volume', defaultContent: ''},
        //             { data: 'process', name: 'process', defaultContent: ''},
        //             { data: 'action', name: 'action', orderable: false, searchable: false}

        //         ]
        //     });

        //     // Filter Leads based on date range
        //     $('#filter_leads').click(function() {
        //         table.ajax.reload();
        //     });
            
        // });

        $(document).ready(function() {
            var table = $('#myTable').DataTable({
                processing: true,
                serverSide: true,
                stateSave: true,
                ajax: {
                    url: "{!! route('filterLeadData') !!}",
                    type: "POST",
                    data: function(d) {
                        d._token = "{{ csrf_token() }}";
                        d.start_date = $('#start_date').val();
                        d.end_date = $('#end_date').val();
                    }
                },
                columns: [
                    { data: 'check', name: 'check', orderable: false, searchable: false},
                    { data: 'website', name: 'leads.website'},
                    { data: 'contactNumber', name: 'leads.contactNumber'},
                    { data: 'category.categoryName', name: 'category.categoryName', defaultContent: ''},
                    { data: 'country.countryName', name: 'country.countryName', defaultContent: ''},
                    { data: 'possibility.possibilityName', name: 'possibility.possibilityName', defaultContent: ''},
                    { data: 'volume', name: 'volume', defaultContent: ''},
                    { data: 'process', name: 'process', defaultContent: ''},
                    { data: 'action', name: 'action', orderable: false, searchable: false}
                ]
            });

            // Filter Leads based on date range
            $('#filter_leads').click(function() {
                table.ajax.reload();
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


    </script>
@endsection
