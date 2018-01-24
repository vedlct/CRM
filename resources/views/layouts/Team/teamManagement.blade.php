

@extends('main')

@section('header')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.0/jquery-confirm.min.css">
@endsection
@section('content')





    <div class="card" style="padding:10px;">
        <div class="card-body">
            <h2 class="card-title" align="center">Assign Lead To User</h2>


            <input type="checkbox" id="selectall" onClick="selectAll(this)" />Select All
            <div class="table-responsive m-t-40">
                <table id="myTable" class="table table-bordered table-striped">
                    <thead>
                    <tr>

                        <th>Select</th>
                        <th>User Id</th>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Gender</th>
                        <th>Phone Number</th>
                        <th>Email</th>

                    </tr>
                    </thead>
                    <tbody>


                    @foreach($users as $user)
                        <tr>
                            <td><input type='checkbox' class="checkboxvar" name="checkboxvar[]" value="{{$user->id}}"></td>
                            <td>{{$user->userId}}</td>
                            <td>{{$user->firstName}}</td>
                            <td>{{$user->lastName}}</td>
                            <td>{{$user->gender}}</td>
                            <td>{{$user->phoneNumber}}</td>
                            <td>{{$user->userEmail}}</td>

                        </tr>
                    @endforeach

                    </tbody>
                </table>
            </div>


            <div class="form-group">


                {{--<div class="form-group col-md-5">--}}
                <label ><b>Select Team :</b></label>
                <select class="form-control"  name="assignTo" id="otherCatches" style="width: 30%">
                    <option value="">select</option>
                    @foreach($teams as $team)
                        <option value="{{$team->teamId}}">{{$team->teamName}}</option>

                    @endforeach


                </select>
            </div>

            <input type="hidden" class="form-control" id="inp" name="leadId">


        </div>


    </div>
    </div>




@endsection

@section('foot-js')


    <script src="{{asset('assets/plugins/datatables/jquery.dataTables.min.js')}}"></script>



    <script src="{{asset('cdn.datatables.net/buttons/1.2.2/js/dataTables.buttons.min.js')}}"></script>
    <script src="{{asset('cdn.datatables.net/buttons/1.2.2/js/buttons.flash.min.js')}}"></script>



    <script src="{{asset('cdn.datatables.net/buttons/1.2.2/js/buttons.html5.min.js')}}"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.0/jquery-confirm.min.js"></script>


    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <script>

        var datatable;


        $(document).ready(function() {
            datatable= $('#myTable').DataTable();

        });

        function selectAll(source) {
            checkboxes = document.getElementsByName('checkboxvar[]');
            for(var i in checkboxes)
                checkboxes[i].checked = source.checked;
        }




        $("#otherCatches").change(function() {

            var chkArray = [];
            var teamId=$(this).val();
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
                url : '{{route('teamAssign')}}',
                data : {_token: CSRF_TOKEN,'userId':chkArray,'teamId':teamId} ,
                success : function(data){
                    console.log(data);
                    if(data == 'true'){
                        $('#myTable').load(document.URL +  ' #myTable');
                        $('#alert').html(' <strong>Success!</strong> Assigned');
                        $('#alert').show();
                    }
                }
            });



        });






    </script>


@endsection