@extends('main')
@section('content')

    <div class="card">
        <div class="card-body">

            <div class="table-responsive m-t-40">
                <table id="myTable" class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th width="5%"> <input type="checkbox" id="selectall" onClick="selectAll(this)" /></th>
                        <th width="20%">Company Name</th>
                        <th width="20%">website</th>
                        <th width="15%">Number</th>
                        <th width="15%">Tnt Number</th>
                        <th width="10%">Category</th>
                        <th width="10%">Area</th>
                        <th width="10%">Address</th>
                        <th width="5%">Status</th>
                        <th width="8%">Possibility</th>
                        {{--<th width="10%">Action</th>--}}


                    </tr>
                    </thead>
                    <tbody>



                    </tbody>
                </table>
            </div>


        </div>
    </div>




<button onclick="assign()">Send</button>


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
                    "url": "{!! route('local.getAssignLead') !!}",
                    "type": "POST",
                    "data":{ _token: "{{csrf_token()}}"}
                },
                {{--ajax: '{!! route('test') !!}',--}}
                columns: [
                    { "data": function(data){

                        return '<input type="checkbox" class="checkboxvar" name="checkboxvar[]" value="'+data.local_leadId+'">'
                            ;},
                        "orderable": false, "searchable":false, "name":"selected_rows" },
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


        function selectAll(source) {
            checkboxes = document.getElementsByName('checkboxvar[]');
            for(var i in checkboxes)
                checkboxes[i].checked = source.checked;
        }


        function assign() {
            var chkArray = [];
//            var userId=$(this).val();
            $('.checkboxvar:checked').each(function (i) {

                chkArray[i] = $(this).val();
            });

//
//            jQuery('input:checkbox:checked').parents("tr").remove();
//            $(this).prop('selectedIndex',0);

            console.log(chkArray);




        }

    </script>


@endsection