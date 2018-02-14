

@extends('main')

@section('header')
    <link rel="stylesheet" href="{{url('css/jconfirm.css')}}">
@endsection

@section('content')


    <div class="card" style="padding: 2px;">
        <div class="card-body">
            <h2 class="card-title" align="center">Team Name  [<b>{{$team->teamName}}</b>]</h2>

            <div class="table-responsive m-t-40" >
                <table id="myTable" class="table table-striped table-condensed" style="font-size:14px;">
                    <thead>
                    <tr>
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


        {{--$("[id*=drop]").change(function(e) {--}}
            {{--var leadId = $(e.currentTarget).data('lead-id');--}}
            {{--var possibility=$(this).val();--}}
            {{--// alert($(this).val());--}}
            {{--var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');--}}
            {{--jQuery(this).parents("tr").remove();--}}

            {{--$.ajax({--}}
                {{--type : 'post' ,--}}
                {{--url : '{{route('changePossibility')}}',--}}
                {{--data : {_token: CSRF_TOKEN,'leadId':leadId,'possibility':possibility} ,--}}
                {{--success : function(data){--}}
                    {{--console.log(data);--}}
                    {{--if(data == 'true'){--}}


                        {{--$('#myTable').load(document.URL +  ' #myTable');--}}
{{--//                        $.alert({--}}
{{--//                            title: 'Success!',--}}
{{--//                            content: 'successfully Changed!',--}}
{{--//                        });--}}
                        {{--$('#alert').html(' <strong>Success!</strong> Possibility Changed');--}}
                        {{--$('#alert').show();--}}
                    {{--}--}}
                {{--}--}}
            {{--});--}}

        {{--});--}}


//        $('#my_modal').on('show.bs.modal', function(e) {
//
//            //get data-id attribute of the clicked element
//            var leadId = $(e.relatedTarget).data('lead-id');
//            var leadName = $(e.relatedTarget).data('lead-name');
//            var email = $(e.relatedTarget).data('lead-email');
//            var number = $(e.relatedTarget).data('lead-number');
//            var personName = $(e.relatedTarget).data('lead-person');
//            var website = $(e.relatedTarget).data('lead-website');
//
//            //populate the textbox
//            $(e.currentTarget).find('input[name="leadId"]').val(leadId);
//            $(e.currentTarget).find('input[name="companyName"]').val(leadName);
//            $(e.currentTarget).find('input[name="email"]').val(email);
//            $(e.currentTarget).find('input[name="number"]').val(number);
//            $(e.currentTarget).find('input[name="personName"]').val(personName);
//            $(e.currentTarget).find('input[name="website"]').val(website);
//
//        });


        $(document).ready(function() {


            $('#myTable').DataTable(
//                {    responsive: true,
//                    "order": [[ 7, "desc" ]]
//                }
            );

        });







    </script>


@endsection

