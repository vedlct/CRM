@extends('main')
@section('content')

    {{--Get User Modal--}}

    <div class="modal fade" id="myModal">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">User</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <!-- Modal body -->
                <div class="modal-body">
                    <div id="userModal">




                    </div>
                </div>

                <!-- Modal footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>

            </div>
        </div>
    </div>

    <!-- End The Modal -->






    <div class="card">
        <div class="card-body">

            <div class="table-responsive m-t-40">
                <table id="myTable" class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th width="5%"> <input type="checkbox" id="selectall" onClick="selectAll(this)" /></th>
                        <th width="20%">Company Name</th>
                        <th width="20%">website</th>
                        <th width="15%">Number</th>
                        <th width="15%">Tnt Number</th>
                        <th width="10%">Category</th>
                        <th width="10%">Area</th>
                        <th width="10%">Address</th>
                        {{--<th width="5%">Status</th>--}}
                        <th width="8%">Possibility</th>
                        <th width="5%">Assigned</th>

                    </tr>
                    </thead>
                    <tbody>
                    @foreach($leads as $lead)
                        <tr>
                            <td><input type="checkbox" class="checkboxvar" name="checkboxvar[]" value="{{$lead->local_leadId}}"></td>
                            <td>{{$lead->leadName}}</td>
                            <td>{{$lead->website}}</td>
                            <td>{{$lead->mobile}}</td>
                            <td>{{$lead->tnt}}</td>
                            <td>{{$lead->categoryName}}</td>
                            <td>{{$lead->areaName}}</td>
                            <td>{{$lead->address}}</td>
                            {{--<td>{{$lead->statusId}}</td>--}}
                            <td>{{$lead->possibilityName}}</td>
                            <td>
                                @php($temp=0)
                                @foreach($assign as $person)
                                    @if($person->local_leadId ==$lead->local_leadId )
                                        <a href="#" data-panel-id="{{$lead->local_leadId}}" onclick="showAssignedUsers(this)">{{$person->total}}</a>
                                        @php($temp++)
                                    @endif

                                @endforeach
                                @if($temp==0)  0 @endif

                            </td>
                        </tr>


                    @endforeach


                    </tbody>
                </table>
            </div>


        </div>

        <div class="row">

      

        <div class="form-group col-md-4" >
            <label>Select User</label>
            <select class="form-control" id="userId">
                <option value="">Select User</option>
                @foreach($users as $user)
                <option value="{{$user->id}}">{{$user->firstName}}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group col-md-10">
            <button onclick="assign()" class="btn btn-success ">Assign</button>
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
                "order": [[9, 'asc']],
            });

        });

        function showAssignedUsers(x) {
            var leadid=$(x).data('panel-id');

//            alert(leadid);
            $.ajax({
                type: 'POST',
                url: "{!! route('local.getAssignedUsers') !!}",
                cache: false,
                data: {_token: "{{csrf_token()}}",'leadid': leadid},
                success: function (data) {
//                    console.log(data);
                    $('#userModal').html(data);
                    $('#myModal').modal();
                }
            });

        }


        function selectAll(source) {
            checkboxes = document.getElementsByName('checkboxvar[]');
            for(var i in checkboxes)
                checkboxes[i].checked = source.checked;
        }


        function assign() {
            var chkArray = [];

            $('.checkboxvar:checked').each(function (i) {

                chkArray[i] = $(this).val();
            });

            var userId=$('#userId').val();

//            jQuery('input:checkbox:checked').parents("tr").remove();
//            $(this).prop('selectedIndex',0);


            if(userId != "" && chkArray !=[]){
                $.ajax({
                    type: 'POST',
                    url: "{!! route('local.insertAssign') !!}",
                    cache: false,
                    data: {_token: "{{csrf_token()}}",'userId': userId,'leadId':chkArray},
                    success: function (data) {
                        location.reload();
                    }
                });
            }


        }

    </script>


@endsection



