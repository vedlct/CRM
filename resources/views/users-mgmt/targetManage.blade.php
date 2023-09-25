@extends('main')

@section('content')
    <div class="box-body">
        <div class="card" style="padding: 2px;">
            <!-- <div class="card-header" style="background-color: #6F8FAF;"> -->
            <!-- </div> -->
            <div class="card-body">
                <h3 class="font-weight-bold" align="center">Monthly Target of The Marketers</h3>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <lebel>Month</lebel>
                            <select class="form-control" id="month">
                                <option value="">Select Month</option>
                                <option value="01">January</option>
                                <option value="02">February</option>
                                <option value="03">March</option>
                                <option value="04">April</option>
                                <option value="05">May</option>
                                <option value="06">June</option>
                                <option value="07">July</option>
                                <option value="08">August</option>
                                <option value="09">September</option>
                                <option value="10">October</option>
                                <option value="11">November</option>
                                <option value="12">December</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <lebel>Year</lebel>
                            <select class="form-control" id="year">
                                <option value="">Select Year</option>
                                <option value="2015">2015</option>
                                <option value="2016">2016</option>
                                <option value="2017">2017</option>
                                <option value="2018">2018</option>
                                <option value="2019">2019</option>
                                <option value="2020">2020</option>
                                <option value="2021">2021</option>
                                <option value="2022">2022</option>
                                <option value="2023">2023</option>
                                <option value="2024">2024</option>
                                <option value="2025">2025</option>
                                <option value="2026">2026</option>
                                <option value="2027">2027</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="table-responsive m-t-40" >
                    <table id="UsersTarget" class="table table-striped table-condensed" style="font-size:14px;"></table>
                </div>
            </div>
        </div>
    </div>




<!-- Edit Modal -->
<div class="modal" id="edit_target_modal" style="">
    <div class="modal-dialog" style="max-width: 60%;">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" name="modal-title">Edit Target</h4>
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
            </div>
            <div class="modal-body">
                <div class="row">                 
                    <div class="col-md-4">
                         <label><b>Target Id</b></label>
                         <input type="text" class="form-control" name="targetId" value="" disabled>
                     </div>

                     <div class="col-md-4">
                         <label><b>User Name</b></label>
                         <input type="text" class="form-control" name="userId" value="" disabled>
                     </div>

                     <div class="col-md-4">
                         <label><b>Target Set at</b></label>
                         <input type="text" class="form-control" name="date" value="" disabled>
                     </div>

                 </div>

                 <br><hr>

                 <form method="post" action="{{ route('updateUserTarget', ['id' => 1]) }}">
                    {{ csrf_field() }}

                    <input type="hidden" name="targetId">

                    <div class="row">                        

                        <div class="col-md-4">
                            <label><b>Total Calls</b></label>
                            <input type="text" class="form-control" name="targetCall" value="">
                        </div>

                        <div class="col-md-4">
                            <label><b>Contacts</b></label>
                            <input type="text" class="form-control" name="targetContact" value="">
                        </div>

                        <div class="col-md-4">
                            <label><b>Conversations</b></label>
                            <input type="text" class="form-control" name="conversation" value="">
                        </div>

                    </div>
                    
                    <br>
                    
                    <div class="row">                        

                        <div class="col-md-4">
                            <label><b>Followup</b></label>
                            <input type="text" class="form-control" name="followup" value="">
                        </div>

                        <div class="col-md-4">
                            <label><b>Test</b></label>
                            <input type="text" class="form-control" name="targetTest" value="">
                        </div>

                        <div class="col-md-4">
                            <label><b>Revenue</b></label>
                            <input type="text" class="form-control" name="targetFile" value="">
                        </div>

                    </div>

                    <br>

                    <div class="row">                        

                        <div class="col-md-4">
                            <label><b>Closed Deals</b></label>
                            <input type="text" class="form-control" name="closelead" value="">
                        </div>

                        <div class="col-md-4">
                            <label><b>Lead Mining</b></label>
                            <input type="text" class="form-control" name="targetLeadmine" value="">
                        </div>

                        <div class="col-md-4">
                            <label><b>High Possibility</b></label>
                            <input type="text" class="form-control" name="targetHighPossibility" value="">
                        </div>

                    </div>

                    <br>

                    <div class="row">                        
                        <div class="col-md-12">
                            <button class="btn btn-success" type="submit">Update</button>
                        </div>

                    </div>

                    </div>
                </form>
            </div>
        </div>
    </div>
</div>






@endsection

@section('foot-js')
    <script src="{{url('assets/plugins/datatables/jquery.dataTables.min.js')}}"></script>
    <script>
        $("#datepicker").datepicker( {
            format: "mm-yyyy",
            viewMode: "months",
            minViewMode: "months"
        });

        function zerofill(i) {
            return (i < 10 ? '0' : '') + i;
        }

        $(document).ready( function () {
            var d = new Date();
            var month = zerofill(d.getMonth()+1);
            var year = d.getFullYear();

            $("#month").val(month).css("background-color", "#7c9").css('color', 'white');
            $("#year").val(year).css("background-color", "#7c9").css('color', 'white');

            $('#UsersTarget').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: '{{route('user-management.target.Get')}}',
                    type: 'POST',
                    data:function (d){
                        d._token="{{csrf_token()}}";
                        if ($('#month').val()!=""){
                            d.month=$('#month').val();
                        }
                        if ($('#year').val()!=""){
                            d.year=$('#year').val();
                        }
                    },
                },
                columns: [
                    { title:'Target Id', data: 'targetId', name: 'users.targetId',"orderable": false, "searchable":true },
                    { title:'User Name', data: 'username', name: 'users.userId',"orderable": false, "searchable":true },
                    { title:'Total Call', data: 'targetCall', name: 'targetCall', "orderable": true, "searchable":true },
                    { title:'New Contact', data: 'targetContact', name: 'targetContact', "orderable": true, "searchable":true },
                    { title:'Conversation', data: 'conversation', name: 'conversation', "orderable": true, "searchable":true },
                    { title:'Follow Up', data: 'followup', name: 'followup', "orderable": true, "searchable":true },
                    { title:'Test', data: 'targetTest', name: 'targetTest', "orderable": true, "searchable":true },
                    { title:'Deals CLosed', data: 'closelead', name: 'closelead', "orderable": true, "searchable":true },
                    { title:'Revenue', data: 'targetFile', name: 'targetFile',"orderable": true, "searchable":true },
                    { title:'Lead Mine', data: 'targetLeadmine', name: 'targetLeadmine', "orderable": true, "searchable":true },
                    { title:'High Possibility', data: 'targetHighPossibility', name: 'targetHighPossibility',"orderable": true, "searchable":true },
                    {
                        title: 'Actions',
                        data: 'targetId',
                        name: 'action',
                        orderable: false,
                        searchable: false,
                        render: function (data, type, full, meta) {
                            return '<button class="btn btn-danger edit-button" ' +
                                'data-id="' + data + '" ' +
                                'data-username="' + full.username + '" ' +
                                'data-date="' + full.date + '" ' +
                                'data-target-call="' + full.targetCall + '" ' +
                                'data-target-contact="' + full.targetContact + '" ' +
                                'data-conversation="' + full.conversation + '" ' +
                                'data-followup="' + full.followup + '" ' +
                                'data-target-test="' + full.targetTest + '" ' +
                                'data-closelead="' + full.closelead + '" ' +
                                'data-target-leadmine="' + full.targetLeadmine + '" ' +
                                'data-target-high-possibility="' + full.targetHighPossibility + '" ' +
                                'data-target-file="' + full.targetFile + '">Edit</button>';
                        }
                    }
                ]
            });
        });

        $('#month').change(function(){
            $('#UsersTarget').DataTable().draw(true);
            if ($('#month').val()!=""){
                $('#month').css("background-color", "#7c9").css('color', 'white');
            }else {
                $('#month').css("background-color", "#FFF").css('color', 'black');
            }
        });

        $('#year').change(function(){
            $('#UsersTarget').DataTable().draw(true);
            if ($('#year').val()!=""){
                $('#year').css("background-color", "#7c9").css('color', 'white');
            }else {
                $('#year').css("background-color", "#FFF").css('color', 'black');
            }
        });


        // Add this code after your DataTable initialization
        $(document).on('click', '.edit-button', function () {
            var targetId = $(this).data('id');
            var username = $(this).data('username');
            var date = $(this).data('date');
            var targetCall = $(this).data('target-call');
            var targetContact = $(this).data('target-contact');
            var conversation = $(this).data('conversation');
            var followup = $(this).data('followup');
            var targetTest = $(this).data('target-test');
            var closelead = $(this).data('closelead');
            var targetFile = $(this).data('target-file');
            var targetLeadmine = $(this).data('target-leadmine');
            var targetHighPossibility = $(this).data('target-high-possibility');

            // Populate the modal fields with data
            $('#edit_target_modal input[name="targetId"]').val(targetId);
            $('#edit_target_modal input[name="userId"]').val(username);
            $('#edit_target_modal input[name="date"]').val(date);
            $('#edit_target_modal input[name="targetCall"]').val(targetCall);
            $('#edit_target_modal input[name="targetContact"]').val(targetContact);
            $('#edit_target_modal input[name="conversation"]').val(conversation);
            $('#edit_target_modal input[name="followup"]').val(followup);
            $('#edit_target_modal input[name="targetTest"]').val(targetTest);
            $('#edit_target_modal input[name="closelead"]').val(closelead);
            $('#edit_target_modal input[name="targetFile"]').val(targetFile);
            $('#edit_target_modal input[name="targetLeadmine"]').val(targetLeadmine);
            $('#edit_target_modal input[name="targetHighPossibility"]').val(targetHighPossibility);

            // Show the modal
            $('#edit_target_modal').modal('show');
        });




    </script>


@endsection
