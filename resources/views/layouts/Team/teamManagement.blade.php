

@extends('main')

@section('header')
    <link rel="stylesheet" href="{{url('css/jconfirm.css')}}">
@endsection
@section('content')





    <div class="card" style="padding:5%;">
        {{--<div style="max-width: 50px; ">--}}
        {{--<a href="{{route('addTeam')}}" class="btn btn-info btn-sm">Add Team</a>--}}
        {{--</div>--}}

        <div class="card-body">
            <h2 class="card-title" align="center"><b>Assign team To User</b></h2>


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
                        <th>Type</th>

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
                            <td>{{$user->userType->typeName}}</td>
                        </tr>
                    @endforeach

                    </tbody>
                </table>
            </div>


            <div class="form-group">


                {{--<div class="form-group col-md-5">--}}
                <label style="color:green;"><b>Select Team :</b></label>
                <select class="form-control"  name="assignTo" id="otherCatches" style="width: 30%">
                    <option value="">select</option>
                    @foreach($teams as $team)
                        <option value="{{$team->teamId}}">{{$team->teamName}}</option>

                    @endforeach


                </select>
            </div>

            <input type="hidden" class="form-control" id="inp" name="teamId">


        </div>


    </div>




    <div class="card" style="padding:5%;">
        <div class="card-body">
            <h2 class="card-title" align="center"><b>Assigned Team Members</b></h2>

            <div class="table-responsive m-t-40">
                <table id="myTable2" class="table table-bordered table-striped">
                    <thead>
                    <tr>

                        <th>User Id</th>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Phone Number</th>
                        <th>Email</th>
                        <th>Type</th>
                        <th>Team Name</th>
                        <th>Remove</th>

                    </tr>
                    </thead>
                    <tbody>

                    @foreach($userAssigneds as $user)
                        <tr>
                            <td>{{$user->userId}}</td>
                            <td>{{$user->firstName}}</td>
                            <td>{{$user->lastName}}</td>
                            <td>{{$user->phoneNumber}}</td>
                            <td>{{$user->userEmail}}</td>
                            <td>{{$user->userType->typeName}}</td>
                            <td> {{$user->teamName}}</td>
                            <td><form method="post" action="{{route('removeUser')}}">
                                    {{@csrf_field()}}
                                    <input type="hidden" value="{{$user->id}}" name="id">
                                <button style="border-radius: 50%;" type="submit" class="btn btn-danger btn-sm"><i class="fa fa-ban" aria-hidden="true"></i></button>
                                </form></td>


                        </tr>

                    @endforeach

                    </tbody>
                </table>
            </div>
        </div>
    </div>

    </div>
    {{--@foreach($userAssigneds as $user)--}}
        {{--{{$user->teamName}}--}}

    {{--@endforeach--}}

@endsection

@section('foot-js')


    <script src="{{url('assets/plugins/datatables/jquery.dataTables.min.js')}}"></script>



    <script src="{{url('cdn.datatables.net/buttons/1.2.2/js/dataTables.buttons.min.js')}}"></script>
    <script src="{{url('cdn.datatables.net/buttons/1.2.2/js/buttons.flash.min.js')}}"></script>



    <script src="{{url('cdn.datatables.net/buttons/1.2.2/js/buttons.html5.min.js')}}"></script>

    <script src="{{url('js/jconfirm.js')}}"></script>





    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <script>

        var datatable;


        $(document).ready(function() {
            datatable= $('#myTable').DataTable();
            datatable= $('#myTable2').DataTable();

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
                        alert(' Successfully! Assigned');
                        location.reload();
                        $('#myTable').load(document.URL +  ' #myTable');
                        $('#alert').html(' <strong>Success!</strong> Assigned');
                        $('#alert').show();
                    }
                }
            });



        });






    </script>


@endsection