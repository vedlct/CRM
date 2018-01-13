@extends('main')

@section('header')






    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.16/css/dataTables.material.min.css">
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/material-design-lite/1.1.0/material.min.css">





@endsection


@section('content')
<div class="container">

    <table id="example" class="mdl-data-table" cellspacing="0" width="100%">
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


    @endsection

@section('foot')

    <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.16/js/dataTables.material.min.js"></script>






    <script  type="text/javascript">

        $(document).ready(function() {

            $('#example').DataTable({
                "processing": true,
                "deferLoding": 57,
            });

        } );

    </script>

  @endsection