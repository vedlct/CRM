

@extends('main')


@section('content')


    <div class="card" style="padding:10px;">
        <div class="card-body">
            <h4 class="card-title">Filtered Lead</h4>

            <div class="table-responsive m-t-40">
                <table id="myTable" class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th>Company Name</th>
                        <th>Category</th>
                        <th>Country</th>
                        <th>Contact Person</th>
                        <th>AssignBy</th>
                        <th>AssignTo</th>

                    </tr>
                    </thead>
                    <tbody>

                    @foreach($leads as $lead)
                        <tr>
                            <td>{{$lead->companyName}}</td>
                            <td>{{$lead->category->categoryName}}</td>
                            <td>{{$lead->country->countryName}}</td>
                            <td>{{$lead->personName}}</td>
                            <td>{{$lead->assigned['userBy']['firstName']}}</td>
                            <td>{{$lead->assigned['userTo']['firstName']}}</td>


                        </tr>

                    @endforeach




                    </tbody>
                </table>
            </div>
        </div>
    </div>


    {{--<div id="edit-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">--}}
        {{--<div class="modal-dialog">--}}
            {{--<div class="modal-content">--}}
                {{--<div class="modal-header">--}}
                    {{--<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>--}}
                    {{--<h4 class="modal-title" id="myModalLabel">Company Name: <b id="modalTitle"></b></h4>--}}
                {{--</div>--}}
                {{--<div class="modal-body">--}}


                    {{--<form action="{{route('assignStore')}}" method="post">--}}
                        {{--{{csrf_field()}}--}}

                        {{--<div class="form-group">--}}
                            {{--<label>Name</label>--}}

                            {{--<div class="form-group">--}}
                                {{--<label for="sel1">Select Name:</label>--}}
                                {{--<select class="form-control"  name="assignTo">--}}
                                    {{--@foreach($users as $user)--}}
                                        {{--<option value="{{$user->id}}">{{$user->firstName}}</option>--}}

                                    {{--@endforeach--}}


                                {{--</select>--}}
                            {{--</div>--}}

                            {{--<input type="hidden" class="form-control" id="inp" name="leadId">--}}

                        {{--</div>--}}
                        {{--<button type="submit" class="btn btn-primary">Assign</button>--}}

                    {{--</form>--}}



                {{--</div>--}}
                {{--<div class="modal-footer">--}}
                    {{--<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>--}}

                {{--</div>--}}
            {{--</div>--}}
        {{--</div>--}}
    {{--</div>--}}


@endsection

@section('foot-js')

    <script src="{{asset('assets/plugins/datatables/jquery.dataTables.min.js')}}"></script>



    <script src="{{asset('cdn.datatables.net/buttons/1.2.2/js/dataTables.buttons.min.js')}}"></script>
    <script src="{{asset('cdn.datatables.net/buttons/1.2.2/js/buttons.flash.min.js')}}"></script>



    <script src="{{asset('cdn.datatables.net/buttons/1.2.2/js/buttons.html5.min.js')}}"></script>



    <script>


        $(document).ready(function() {
            $('#myTable').DataTable();

        });


//        $('#edit-modal').on('show.bs.modal', function(e) {
//
//            var $modal = $(this),
//                esseyId = e.relatedTarget.id;
//            esseyName = e.relatedTarget.name;
//
//            $modal.find('#modalTitle').html(esseyName);
//            $modal.find('#inp').val(esseyId);
//
//        })


    </script>


@endsection