
@extends('main')

@section('content')

    <div class="card" style="padding:10px;">
        <div class="card-body">
            <h2 class="card-title" align="center"><b>My Team Members Lead List</b></h2>

            <div class="table-responsive m-t-40" style="padding: 20px;">
                <table id="myTable" class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th>Company Name</th>
                        <th>Assign To</th>
                        <th>Email</th>
                        <th>Website</th>
                        <th>Created At</th>
                        <th>Remove</th>


                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($leads as $l)
                    @foreach ($users as $u)
                    @if ($u->id== $l->assignTo)

                        <tr>
                        <td>{{$l->companyName}}</td>
                            <td>{{$u->firstName}}</td>
                            <td>{{$l->email}}</td>
                            <td>{{$l->website}}</td>
                            <td>{{$l->created_at}}</td>
                            <td>
                                <form method="post" action="{{route('detached.reject')}}" onclick="return confirm('Are you sure you want to detached this Lead?');">
                                    {{csrf_field()}}
                                    <input type="hidden" value="{{$l->leadId}}" name="leadId">
                                    <input type="hidden" value="{{$u->id}}" name="userId">
                                    <button class="btn btn-info btn-sm" type="submit"><i class="fa fa-ban" aria-hidden="true"></i></button>
                                </form>


                            </td>
                    </tr>

                    @endif
                    @endforeach
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>




@endsection

@section('foot-js')

    <script src="{{asset('assets/plugins/datatables/jquery.dataTables.min.js')}}"></script>

    <script src="{{asset('cdn.datatables.net/buttons/1.2.2/js/dataTables.buttons.min.js')}}"></script>
    <script src="{{asset('cdn.datatables.net/buttons/1.2.2/js/buttons.flash.min.js')}}"></script>


    <script src="{{asset('cdn.datatables.net/buttons/1.2.2/js/buttons.html5.min.js')}}"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}" />



    <script>

        $(document).ready(function() {
            $('#myTable').DataTable({
                "processing": true
            });

        });


    </script>





@endsection