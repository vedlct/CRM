@extends('main')



@section('content')
    <div class="card" style="padding:10px;">
        <h2 align="center">Rejected Leads</h2>
        <div class="card-body">

            <table class="table table-bordered" id="posts">
                <thead>
                <th>Company Name</th>
                <th>Mined By</th>
                <th>Email</th>


                </thead>
            </table>

        </div></div>


@endsection


@section('foot-js')




    <script src="{{url('assets/plugins/datatables/jquery.dataTables.min.js')}}"></script>

    <script src="{{url('cdn.datatables.net/buttons/1.2.2/js/dataTables.buttons.min.js')}}"></script>
    <script src="{{url('cdn.datatables.net/buttons/1.2.2/js/buttons.flash.min.js')}}"></script>


    <script src="{{url('cdn.datatables.net/buttons/1.2.2/js/buttons.html5.min.js')}}"></script>


    <script>
        {{--$(document).ready(function () {--}}
            {{--$('#posts').DataTable({--}}
                {{--"processing": true,--}}
                {{--"serverSide": true,--}}
                {{--"pagingType": "full_numbers",--}}
                {{--"ajax":{--}}
                    {{--"url": "{{ route('rejectData')}}",--}}
                    {{--"dataType": "json",--}}
                    {{--"type": "POST",--}}
                    {{--"data":{ _token: "{{csrf_token()}}"}--}}
                {{--},--}}
                {{--"columns": [--}}
                    {{--{ "data": "name" },--}}
                    {{--{ "data": "email" },--}}
                    {{--{ "data": "minedBy" }--}}
                {{--]--}}

            {{--});--}}
        {{--});--}}

        $(function() {
            $('#posts').DataTable({
                processing: true,
                serverSide: true,
                type:"POST",
                "ajax":{
                    "url": "{!! route('rejectData') !!}",
                    "type": "POST",
                    "data":{ _token: "{{csrf_token()}}"}
                },
                {{--ajax: '{!! route('test') !!}',--}}
                columns: [
                    { data: 'companyName', name: 'leads.companyName' },
                    { data: 'mined.firstName', name: 'mined.firstName' },
                    { data: 'email', name: 'email' },

                ]
            });
        });
    </script>

@endsection