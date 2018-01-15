

@extends('main')


    @section('content')


    <div class="card">
        <div class="card-body">
            <h4 class="card-title">Data Table</h4>
            <h6 class="card-subtitle">Data table example</h6>
            <div class="table-responsive m-t-40">
                <table id="myTable" class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>MSG</th>
                       
                    </tr>
                    </thead>
                    <tbody>


                    @foreach($table as $data)
                        <tr>
                            <td>{{$data->id}}</td>
                            <td>{{$data->msg}}</td>
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
                    "order": [[ 0, "desc" ]]
                }
            );

        });





    </script>


    @endsection