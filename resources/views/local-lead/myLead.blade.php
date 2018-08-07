@extends('main')
@section('content')

<div class="card">
    <div class="card-body">
        <h3 align="center"><b>My Leads</b></h3>
        <div class="table-responsive m-t-40">
            <table id="myTable" class="table table-bordered table-striped">
                <thead>
                <tr>
                    <th width="20%">Company Name</th>
                    <th width="20%">website</th>
                    <th width="15%">Number</th>
                    <th width="15%">Tnt Number</th>
                    <th width="10%">Category</th>
                    <th width="10%">Area</th>
                    <th width="10%">Address</th>
                    <th width="5%">Status</th>
                    <th width="8%">Possibility</th>
                    {{--<th width="10%">Edit</th>--}}


                </tr>
                </thead>
                <tbody>



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
            $('#myTable').DataTable({
                processing: true,
                serverSide: true,
                stateSave: true,
                Filter: true,
                type:"POST",
                "ajax":{
                    "url": "{!! route('local.getMyLead') !!}",
                    "type": "POST",
                    "data":{ _token: "{{csrf_token()}}"}
                },
                {{--ajax: '{!! route('test') !!}',--}}
                columns: [
                    { data: 'companyName', name: 'companyName' },
                    { data: 'website', name: 'website' },
                    { data: 'mobile', name: 'mobile'},
                    { data: 'tnt', name: 'tnt'},
                    { data: 'categoryName', name: 'categoryName'},
                    { data: 'areaName', name: 'areaName'},
                    {data: 'address', name: 'address'},
                    { data: 'statusId', name: 'statusId'},
                    { data: 'possibilityName', name: 'possibilityName'}
                ]
            });

        });

    </script>


@endsection