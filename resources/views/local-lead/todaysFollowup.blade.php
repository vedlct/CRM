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
            <h3 align="center"><b>Todays Followup</b></h3>
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

                        <th width="8%">Possibility</th>
                        <th width="5%">Action</th>


                    </tr>
                    </thead>
                    <tbody>
                    @foreach($leads as $lead)
                        <tr>
                            <td>{{$lead->leadName}}</td>
                            <td>{{$lead->companyName}}</td>
                            <td>{{$lead->website}}</td>
                            <td>{{$lead->mobile}}</td>
                            <td>{{$lead->tnt}}</td>
                            <td>{{$lead->categoryName}}</td>
                            <td>{{$lead->areaName}}</td>
                            <td>{{$lead->address}}</td>
                            <td>{{$lead->possibilityName}}</td>
                            <td><button class="btn btn-info" onclick="showReportModal({{$lead->local_leadId}},{{$lead->local_followupId}})"><i class="fa fa-phone"></i></button></td>



                        </tr>
                    @endforeach
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
            $('#myTable').DataTable();

        });


        function showReportModal(x,y) {


            $.ajax({
                type: 'POST',
                url: "{!! route('local.getFollowupModal') !!}",
                cache: false,
                data: {_token: "{{csrf_token()}}",'leadId': x,'followupId':y},
                success: function (data) {
                    $("#editLeadModalBody").html(data);
                    $("#editLeadModal").modal();
                }
            });


        }

    </script>


@endsection