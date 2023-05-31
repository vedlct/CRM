@extends('main')
@section('content')

    <!-- The Modal -->
    <div class="modal" id="myModal">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">New Files</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <!-- Modal body -->
                <div class="modal-body" id="myModalBody">

                </div>

                <!-- Modal footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                </div>

            </div>
        </div>
    </div>

    <div class="modal" id="addModal">
        <div class="modal-dialog">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Add Files</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <!-- Modal body -->
                <div class="modal-body" id="addModalBody">

                </div>

                <!-- Modal footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                </div>

            </div>
        </div>
    </div>


<br>
<div class="card">
    <div class="card-body">
        <table class="table">
            <thead>
                <th>Company Name</th>
                <th>Revnue</th>
                <th>Action</th>
            </thead>
            <tbody>
                @foreach($leadsWithFiles as $lead)
                    <tr>
                        <td>{{$lead->companyName}}</td>
                        <td>{{$lead->total}}</td>
                        <td>
                            <!-- <button class="btn btn-info btn-sm" data-panel-id="{{$lead->leadId}}" onclick="fileEdit(this)"><i class="fa fa-edit" ></i></button> -->
                            <button class="btn btn-info btn-sm" data-panel-id="{{$lead->leadId}}" onclick="fileAdd(this)"><i class="fa fa-plus"></i></button>
                        </td>
                    </tr>
                @endforeach
            </tbody>

        </table>
    </div>
</div>



@endsection

@section('bottom')
    <script>
        function fileEdit(x) {
            var id=$(x).data('panel-id');

            // alert(id);
            $.ajax({
            type: 'POST',
            url: "{!! route('clientLeads.edit') !!}",
            cache: false,
            data: {_token: "{{csrf_token()}}",'id': id},
            success: function (data) {
            $("#myModalBody").html(data);
            $("#myModal").modal();
            // console.log(data);
            }
            });

        }

        function fileAdd(x) {
            var id=$(x).data('panel-id');


            $.ajax({
                type: 'POST',
                url: "{!! route('clientLeads.add') !!}",
                cache: false,
                data: {_token: "{{csrf_token()}}",'id': id},
                success: function (data) {
                    $("#addModalBody").html(data);
                    $("#addModal").modal();
                    // console.log(data);
                }
            });

        }
    </script>
@endsection

