@extends('main')


@section('content')


    <div class="card" style="padding:10px;">
        <div class="card-body">
    <table class="table table-bordered" id="users-table">
        <thead>
        <tr>
            <th>companyName</th>
            <th>personName</th>
            <th>Email</th>
            <th>Number</th>
            <th>Created At</th>
            <th>Action</th>

        </tr>
        </thead>
        <tbody>

        </tbody>
    </table>

        </div></div>




@endsection



@section('foot-js')

    <script src="assets/plugins/datatables/jquery.dataTables.min.js"></script>



    <script src="cdn.datatables.net/buttons/1.2.2/js/dataTables.buttons.min.js"></script>
    <script src="cdn.datatables.net/buttons/1.2.2/js/buttons.flash.min.js"></script>



    <script src="cdn.datatables.net/buttons/1.2.2/js/buttons.html5.min.js"></script>


    <script>
        $(function() {
            $('#users-table').DataTable({
                processing: true,
                serverSide: true,
                type:"POST",
                "ajax":{
                    "url": "{!! route('test') !!}",
                    "type": "POST",
                    "data":{ _token: "{{csrf_token()}}"}
                },
                {{--ajax: '{!! route('test') !!}',--}}
                columns: [
                    { data: 'companyName', name: 'companyName' },
                    { data: 'personName', name: 'personName' },
                    { data: 'email', name: 'email' },
                    { data: 'contactNumber', name: 'contactNumber' },
                    { data: 'created_at', name: 'created_at' },
                    {data: 'action', name: 'action', orderable: false, searchable: false}
                ]
            });
        });
    </script>




@endsection