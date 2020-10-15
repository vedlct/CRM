

@extends('main')

@section('header')
    <link rel="stylesheet" href="{{url('css/jconfirm.css')}}">
    @endsection
@section('content')





    <div class="card" style="padding:10px;">
        <div class="card-body">
            <h2 class="card-title" align="center"><b>Assign Lead To User</b></h2>



            <div class="table-responsive m-t-40">
                <table id="myTable" class="table table-bordered table-striped">
                    <thead>
                    <tr>


                        <th>Select</th>
                        <th>Company Name</th>
                        <th>Date</th>
                        <th>Mined By</th>
                        {{--<th>Category</th>--}}
                        <th>Website</th>
                        {{--<th>Email</th>--}}
                        <th>Country</th>
                        <th>Category</th>
                        <th>Possibility</th>
                        <th>Probability</th>


                    </tr>
                    </thead>
                    <tbody>




                    </tbody>
                </table>
            </div>




            <input type="checkbox" id="selectall" onClick="selectAll(this)" /><b>Select All</b>

            <div class="form-group">

                {{--<div class="form-group col-md-5">--}}
                <label ><b>Select Name:</b></label>
                <select class="form-control"  name="assignTo" id="otherCatches" style="width: 30%">
                    <option value="">select</option>
                    @foreach($users as $user)
                        <option value="{{$user->id}}">{{$user->firstName}} {{$user->lastName}}</option>

                    @endforeach


                </select>
            </div>

            <input type="hidden" class="form-control" id="inp" name="leadId">


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
                    { data: 'companyName', name: 'leads.companyName' },
                    { data: 'created_at', name: 'leads.created_at' },
                    { data: 'mined.firstName', name: 'mined.firstName' },
                    { data: 'website', name: 'leads.website' },
//                    { data: 'email', name: 'leads.email' },
                    { data: 'country.countryName', name: 'country.countryName'},
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
