@extends('main')

@section('content')

    {{--get user type from session--}}
    @php($userType = strtoupper(Auth::user()->userType->typeName))

    <div class="card" style="padding:10px;">
        <div class="card-body">
            <h2 class="card-title" align="center"><b>Filtered Lead</b></h2>

            <div class="table-responsive m-t-40">
                <table id="myTable" class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th>Company Name</th>
                        <th>Category</th>
                        <th>Country</th>
                        <th>Contact Person</th>
                        <th>Mined By</th>

                        @if($userType=='USER' || $userType=='RA' || $userType=='MANAGER')
                        <th>Contacted</th>
                            @endif
                    </tr>
                    </thead>
                    <tbody>

                    @foreach($leads as $lead)
                        <tr>
                            <td>{{$lead->companyName}}</td>
                            <td>{{$lead->category->categoryName}}</td>
                            <td>{{$lead->country->countryName}}</td>
                            <td>{{$lead->personName}}</td>
                            <td>{{$lead->mined->firstName}}</td>

                            @if($userType=='USER' || $userType=='RA' || $userType=='MANAGER')
                                <th>
                                <form method="post" action="{{route('addContacted')}}">
                                    {{@csrf_field()}}
                                    <input type="hidden" value="{{$lead->leadId}}" name="leadId">
                                    <button class="btn btn-info btn-sm"><i class="fa fa-bookmark" aria-hidden="true"></i></button>
                                </form>
                                </th>
                                    @endif
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

    <script>
        $(document).ready(function() {
            $('#myTable').DataTable();

        });
    </script>


@endsection