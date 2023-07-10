@extends('main')

@section('header')

    <link href="{{url('css/select2.min.css')}}" rel="stylesheet" />
@endsection

@section('content')

    {{--<div class="card" style="max-width: 100px;margin-top: 20px;">--}}<br><br>

    {{--</div>--}}

    @php($userType = Session::get('userType'))

    <div class="card" style="padding:10px;">
        <div class="card-body">
            <h2 class="card-title" align="center"><b>Verify Leads</b></h2>

            <div class="table-responsive m-t-40">
                <table id="myTable" class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th>Id</th>
                        <th>website</th>
                        <th>Number</th>
                        <th>Marketier</th>
                        <th>Status</th>                   
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

    <script src="{{url('js/select2.min.js')}}"></script>
    <script src="{{url('assets/plugins/datatables/jquery.dataTables.min.js')}}"></script>
    <script src="{{url('cdn.datatables.net/buttons/1.2.2/js/dataTables.buttons.min.js')}}"></script>
    <script src="{{url('cdn.datatables.net/buttons/1.2.2/js/buttons.flash.min.js')}}"></script>
    <script src="{{url('cdn.datatables.net/buttons/1.2.2/js/buttons.html5.min.js')}}"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <script>


        $(function() {
            $('#myTable').dataTable({
                aLengthMenu: [
                    [25, 50, 100],
                    [25, 50, 100]
                ],
                "iDisplayLength": 25,
                processing: true,
                serverSide: true,
                stateSave: true,
                Filter: true,
                type:"POST",
                "ajax":{
                    "url": "{!! route('verifyallLeads') !!}",
                    "type": "POST",
                    "data":{ _token: "{{csrf_token()}}"}
                },
                columns: [
                    { data: 'leadId', name: 'leads.leadId' },
                    { data: 'website', name: 'leads.website' },
                    { data: 'contactNumber', name: 'leads.contactNumber'},
                    {data: 'contact.firstName', name: 'contact.firstName', defaultContent: ''},
                    {data: 'status.statusName', name: 'status.statusName', defaultContent: ''},
                                
                ]
            });
        });



        

    </script>


@endsection
