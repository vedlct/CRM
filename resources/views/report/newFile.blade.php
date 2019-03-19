@extends('main')

@section('content')
<br>
<div class="card">
    <div class="card-body">

        <h2 class="card-title" align="center"><b>New Files This Month</b></h2>
        <br>

        <table class="table table-striped table-bordered" id="myTable">
            <thead>
                <th>Company Name</th>
                <th>Files</th>
                <th>Created At</th>
            </thead>
            <tbody>
            @foreach($newFiles as $file)
                <tr>
                    <td>{{$file->companyName}}</td>
                    <td>{{$file->fileCount}}</td>
                    <td>{{$file->created_at}}</td>
                </tr>
             @endforeach
            </tbody>
        </table>
    </div>
</div>







@endsection
@section('foot-js')
    <script src="{{url('assets/plugins/datatables/jquery.dataTables.min.js')}}"></script>

    <script src="{{url('cdn.datatables.net/buttons/1.2.2/js/dataTables.buttons.min.js')}}"></script>
    <script src="{{url('cdn.datatables.net/buttons/1.2.2/js/buttons.flash.min.js')}}"></script>


    <script src="{{url('cdn.datatables.net/buttons/1.2.2/js/buttons.html5.min.js')}}"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}" />


    <script>
        $(document).ready(function() {
            $('#myTable').DataTable({
                "processing": true,
                stateSave: true,
            });

        });





    </script>



@endsection





