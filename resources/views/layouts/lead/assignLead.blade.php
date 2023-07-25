

@extends('main')

@section('header')
    <link rel="stylesheet" href="{{url('css/jconfirm.css')}}">
    @endsection
@section('content')





    <div class="card" style="padding:10px;">
        <div class="card-body">
            <h2  align="center"><b>Assign Filtered Leads</b></h2>



            <div class="table-responsive m-t-40">
                <table id="myTable" class="table table-bordered table-striped">
                    <thead>
                    <tr>


                        <th>Select</th>
                        <th>Lead Id</th>
                        <th>Company Name</th>
                        <th>Country</th>
                        <th>Website</th>
                        <th>Phone</th>
                        <th>Mined By</th>
                        <th>Category</th>
                        <th>Possibility</th>
                        <th>Probability</th>
                        <th>Volume</th>
                        <th>Frequency</th>
                        <th>Process</th>
                        <th>Date</th>


                    </tr>
                    </thead>
                    <tbody>




                    </tbody>
                </table>
            </div>




            <input type="checkbox" id="selectall" onClick="selectAll(this)" /><b>Select All</b>
            <div class="row">



            <div class="col-md-10">

                {{--<div class="form-group col-md-5">--}}
                <label ><b>Assign to:</b></label>
                <select class="form-control"  name="assignTo" id="otherCatches" style="width: 30%">
                    <option value="">select</option>
                    @foreach($users as $user)
                        <option value="{{$user->id}}">{{$user->firstName}} {{$user->lastName}}</option>

                    @endforeach

                </select>
            </div>
            <div class="col-md-2">

            {{-- <input id = "makemy" type="submit" class="btn btn-outline-primary" value="Make My Lead"/> --}}

            <input type="hidden" class="form-control" id="inp" name="leadId">

        </div>
        </div>


        </div>
    </div>




@endsection

@section('foot-js')


    <script src="{{url('assets/plugins/datatables/jquery.dataTables.min.js')}}"></script>



    <script src="{{url('cdn.datatables.net/buttons/1.2.2/js/dataTables.buttons.min.js')}}"></script>
    <script src="{{url('cdn.datatables.net/buttons/1.2.2/js/buttons.flash.min.js')}}"></script>



    <script src="{{url('cdn.datatables.net/buttons/1.2.2/js/buttons.html5.min.js')}}"></script>

    <script src="{{url('js/jconfirm.js')}}"></script>


    <meta name="csrf-token" content="{{ csrf_token() }}" />


    <script>

$(document).ready(function() {
    $("#makemy").click(function(){
        var chkArray = [];
        //var userId=$(this).val();
        $('.checkboxvar:checked').each(function (i) {

            chkArray[i] = $(this).val();
            });

            //alert(chkArray)

            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            // $("#inp").val(JSON.stringify(chkArray));
            // $( "#assign-form" ).submit();
            jQuery('input:checkbox:checked').parents("tr").remove();
            $(this).prop('selectedIndex',0);

            $.ajax({
                type : 'post' ,
                url : '{{route('addmyContacted')}}',
                data : {_token: CSRF_TOKEN,'leadId':chkArray} ,
                success : function(data){
                    console.log(data);
                    if(data == 'true'){
                        // $('#myTable').load(document.URL +  ' #myTable');
//                        $.alert({
//                            title: 'Success!',
//                            content: 'successfully assigned!',
//                        });
                        $('#alert').html('Leads are assigned successfully');
                        $('#alert').show();

                    }
                }
            });
    });
})




    </script>








    <script>

//        var datatable;
//
//
//        $(document).ready(function() {
//             datatable= $('#myTable').DataTable(
//                {
//                    "order": [[ 7, "desc" ]]
//                }
//            );
//
//        });


//<th>Select</th>
//<th>Company Name</th>
//<th>Mined By</th>
//<th>Category</th>
//<th>Website</th>
//<th>Email</th>
//<th>Country</th>
//<th>Comments</th>
//<th>Created At</th>

        $(function() {
            $('#myTable').DataTable({
                processing: true,
                serverSide: true,
                stateSave: true,
                type:"POST",
                "ajax":{
                    "url": "{!! route('getAssignLeadData') !!}",
                    "type": "POST",
                    "data":{ _token: "{{csrf_token()}}"}
                },

                columns: [
                    {data: 'action', name: 'action', orderable: false, searchable: false},
                    { data: 'leadId', name: 'leads.leadId' },
                    { data: 'companyName', name: 'leads.companyName' },
                    { data: 'country.countryName', name: 'country.countryName'},
                    { data: 'website', name: 'leads.website' },
                    { data: 'contactNumber', name: 'leads.contactNumber' },
                    { data: 'mined.firstName', name: 'mined.firstName' },
                    { data: 'category.categoryName', name: 'category.categoryName' },
                    { data: 'possibility.possibilityName', name: 'possibility.possibilityName' },
                    { data: 'probability.probabilityName',
                        render: function(data) {
                            if(data != null) {
                                return data
                            }
                            else {
                                return 'null'
                            }

                        },
                    },
                    { data: 'volume', name: 'leads.volume' },
                    { data: 'frequency', name: 'leads.frequency' },
                    { data: 'process', name: 'leads.process' },
                    { data: 'created_at', name: 'leads.created_at' },

                ]
            });
        });



        function selectAll(source) {
            checkboxes = document.getElementsByName('checkboxvar[]');
            for(var i in checkboxes)
                checkboxes[i].checked = source.checked;
        }




        $("#otherCatches").change(function() {

            var chkArray = [];
            var userId=$(this).val();
            $('.checkboxvar:checked').each(function (i) {

                chkArray[i] = $(this).val();
            });
            //alert(chkArray)
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            // $("#inp").val(JSON.stringify(chkArray));
            // $( "#assign-form" ).submit();
            jQuery('input:checkbox:checked').parents("tr").remove();
            $(this).prop('selectedIndex',0);

            $.ajax({
                type : 'post' ,
                url : '{{route('assignStore')}}',
                data : {_token: CSRF_TOKEN,'leadId':chkArray,'userId':userId} ,
                success : function(data){
                    console.log(data);
                    if(data == 'true'){
                        // $('#myTable').load(document.URL +  ' #myTable');
//                        $.alert({
//                            title: 'Success!',
//                            content: 'successfully assigned!',
//                        });
                        $('#alert').html(' <strong>Success!</strong> Assigned');
                        $('#alert').show();

                    }
                }
            });



        });








    </script>


@endsection
