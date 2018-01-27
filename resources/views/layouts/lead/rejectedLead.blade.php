@extends('main')



@section('content')
    <div class="card" style="padding:10px;">
        <h2 align="center">Rejected Leads</h2>
        <div class="card-body">
    <table class="table table-bordered table-striped" id="users-table">
        <thead>
        <tr>
            <th>Id</th>
            <th>Name</th>
            <th>website</th>
            <th>Category</th>
        </tr>
        </thead>
    </table>
        </div></div>


@endsection


@section('foot-js')

    <script src="{{asset('assets/plugins/datatables/jquery.dataTables.min.js')}}"></script>

    <script src="{{asset('cdn.datatables.net/buttons/1.2.2/js/dataTables.buttons.min.js')}}"></script>
    <script src="{{asset('cdn.datatables.net/buttons/1.2.2/js/buttons.flash.min.js')}}"></script>


    <script src="{{asset('cdn.datatables.net/buttons/1.2.2/js/buttons.html5.min.js')}}"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}" />



    <script>

        $(function() {
            $('#users-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{!! route('rejectData') !!}',
                columns: [
                    { data: 'leadId', name: 'leadId' },
                    { data: 'companyName', name: 'companyName' },
                    { data: 'website', name: 'website' },
                    { data: 'category.categoryName', name: 'category.categoryName' }
                ]
            });
        });
    </script>

@endsection