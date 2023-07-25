

@extends('main')


    @section('content')


        <div><a href="#myModal" data-toggle="modal" id="1" data-target="#edit-modal" class="btn btn-success">Edit 1</a></div><br>
        <div><a href="#myModal" data-toggle="modal" id="2" data-target="#edit-modal" class="btn btn-success">Edit 2</a></div><br>
        <div><a href="#myModal" data-toggle="modal" id="3" data-target="#edit-modal" class="btn btn-success">Edit 3</a></div><br>

        <div id="edit-modal" class="modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title" id="myModalLabel">Modal title</h4>
                    </div>
                    <div class="modal-body edit-content">
                        ...
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary">Save changes</button>
                    </div>
                </div>
            </div>
        </div>



    <div class="card" style="padding: 30px;">
        <div class="card-body">
            <h4 class="card-title">Data Table</h4>
            <h6 class="card-subtitle">Data table example</h6>
            <div class="table-responsive m-t-40">
                <table id="myTable" class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>MSG</th>
                        <th>Edit</th>
                       
                    </tr>
                    </thead>
                    <tbody>



                    @foreach($table as $data)
                        <tr>
                            <td>{{$data->id}}</td>
                            <td>{{$data->name}}</td>
                            <td>{{$data->msg}}</td>
                            <td><button class="btn btn-success">Edit</button>
                                <button class="btn btn-danger">Edit</button>
                            </td>
                        </tr>
                        @endforeach

                    </tbody>
                </table>
            </div>
        </div>
    </div>



    @endsection

@section('foot-js')

    <script src="assets/plugins/datatables/jquery.dataTables.min.js"></script>



    <script src="cdn.datatables.net/buttons/1.2.2/js/dataTables.buttons.min.js"></script>
    <script src="cdn.datatables.net/buttons/1.2.2/js/buttons.flash.min.js"></script>



    <script src="cdn.datatables.net/buttons/1.2.2/js/buttons.html5.min.js"></script>



    <script>


        $(document).ready(function() {
            $('#myTable').DataTable(
                {
//                    "order": [[ 0, "desc" ]]
                }
            );

        });


        $('#edit-modal').on('show.bs.modal', function(e) {

            var $modal = $(this),
                esseyId = e.relatedTarget.id;

            $modal.find('.edit-content').html(esseyId);

        })



    </script>


    @endsection