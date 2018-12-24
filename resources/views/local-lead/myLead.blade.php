@extends('main')
@section('content')

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

<div class="card">
    <div class="card-body">
        <h3 align="center"><b>My Leads</b></h3>
        <div class="table-responsive m-t-40">
            <table id="myTable" class="table table-bordered table-striped">
                <thead>
                <tr>
                    <th width="15%">Lead Name</th>
                    <th width="15%">Company Name</th>
                    <th width="15%">website</th>
                    <th width="10%">Number</th>
                    <th width="10%">Tnt Number</th>
                    <th width="10%">Category</th>
                    <th width="10%">Area</th>
                    <th width="10%">Address</th>
                    {{--<th width="5%">Status</th>--}}
                    <th width="8%">Possibility</th>
                    <th width="5%">Action</th>


                </tr>
                </thead>
                <tbody>



                </tbody>
            </table>
        </div>


    </div>
</div>



@endsection
@section('bottom')




    {{--<script src="{{url('js/select2.min.js')}}"></script>--}}
    <script src="{{url('assets/plugins/datatables/jquery.dataTables.min.js')}}"></script>
    <script src="{{url('cdn.datatables.net/buttons/1.2.2/js/dataTables.buttons.min.js')}}"></script>
    <script src="{{url('cdn.datatables.net/buttons/1.2.2/js/buttons.flash.min.js')}}"></script>
    <script src="{{url('cdn.datatables.net/buttons/1.2.2/js/buttons.html5.min.js')}}"></script>

    <script>
        $(function() {
            $('#myTable').DataTable({
                processing: true,
                serverSide: true,
                stateSave: true,
                Filter: true,
                type:"POST",
                "ajax":{
                    "url": "{!! route('local.getMyLead') !!}",
                    "type": "POST",
                    "data":{ _token: "{{csrf_token()}}"}
                },
                {{--ajax: '{!! route('test') !!}',--}}
                columns: [
                    { data: 'leadName', name: 'leadName' },
                    { data: 'companyName', name: 'companyName' },
                    { data: 'website', name: 'website' },
                    { data: 'mobile', name: 'mobile'},
                    { data: 'tnt', name: 'tnt'},
                    { data: 'categoryName', name: 'categoryName'},
                    { data: 'areaName', name: 'areaName'},
                    {data: 'address', name: 'address'},
//                    { data: 'statusId', name: 'statusId'},
                    { data: 'possibilityName', name: 'possibilityName'},
                    { "data": function(data){

                        return '<a class="btn btn-default btn-sm" data-panel-id="'+data.local_leadId+'" onclick="editLead(this)"><i class="fa fa-edit"></i></a>'+
                        '<button class="btn btn-info" onclick="showReportModal('+data.local_leadId+')"><i class="fa fa-phone"></i></button>'
                            ;},
                        "orderable": false, "searchable":false, "name":"selected_rows" },
                ]
            });

        });


        function showReportModal(x) {

            $.ajax({
                type: 'POST',
                url: "{!! route('local.getFollowupModal') !!}",
                cache: false,
                data: {_token: "{{csrf_token()}}",'leadId': x},
                success: function (data) {
                    $("#editLeadModalBody").html(data);
                    $("#editLeadModal").modal();
                }
            });


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

    </script>


@endsection