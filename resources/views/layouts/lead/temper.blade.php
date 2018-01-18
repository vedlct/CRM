

@extends('main')


@section('content')


    <div class="card" style="padding:10px;">
        <div class="card-body">
            <h4 class="card-title">Assign Lead To User</h4>

            <div class="table-responsive m-t-40">
                <table id="myTable" class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th>Company Name</th>
                        <th>Category</th>
                        <th>Website</th>
                        <th>Email</th>
                        <th>Country</th>
                        <th>Comments</th>
                        <th>Mined By</th>
                        <th>Created At</th>
                        <th>Set Possibility</th>
                        <th>Delete</th>

                    </tr>
                    </thead>
                    <tbody>


                    @foreach($leads as $lead)
                        <tr>
                            <td>{{$lead->companyName}}</td>
                            <td>{{$lead->category->categoryName}}</td>
                            <td>{{$lead->website}}</td>
                            <td>{{$lead->email}}</td>
                            <td>{{$lead->country->countryName}}</td>
                            <td>{{$lead->comments}}</td>
                            <td>{{$lead->mined->firstName}}</td>
                            <td>{{$lead->created_at}}</td>
                            <td>
                                <form method="post" action="{{route('changePossibility')}}">
                                    {{csrf_field()}}
                                    <input type="hidden" value="{{$lead->leadId}}" name="leadId">
                                    <select class="form-control" id="" name="possibility" onchange="this.form.submit()">
                                        <option value="">Select</option>
                                @foreach($possibilities as $p)

                                        <option value="{{$p->possibilityId}}">{{$p->possibilityName}}</option>
                                @endforeach
                                </select>
                                </form>

                            </td>

                            <td>
                                <form method="post" action="{{ URL::to('lead/' . $lead->leadId) }}" onsubmit="return confirm('Do you really want to Delete?');">
                                    {{csrf_field()}}
                                    {{ method_field('DELETE') }}

                                    <button type="submit" class="btn btn-danger btn-sm">

                                        <i class="fa fa-trash"></i></button></form></td>
                        </tr>
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



    <script>


        $(document).ready(function() {
            $('#myTable').DataTable(
                {
                    "order": [[ 7, "desc" ]]
                }
            );

        });





    </script>


@endsection