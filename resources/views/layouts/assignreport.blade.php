@extends('main')

@section('header')






    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.16/css/dataTables.bootstrap.min.css">





@endsection


@section('content')
<div class="container">
    <div class="col-md-12">
    <table id="example" class="table table-striped table-bordered" cellspacing="0" width="100%">
        <thead>
        <tr>
            <th>Name</th>
            <th>Text</th>



        </tr>
        </thead>

        <tbody>

        @foreach($table as $t)
        <tr>

            <td>{{$t->id}}</td>
            <td>{{$t->msg}}</td>



        </tr>

    @endforeach

        </tbody>
    </table>
    </div>

</div>
    @endsection

@section('foot')

    <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.16/js/dataTables.bootstrap.min.js"></script>






    <script  type="text/javascript">

        $(document).ready(function() {

            $('#example').DataTable({
                "processing": true,
                "deferLoding": 57,
            });

        } );

    </script>

  @endsection