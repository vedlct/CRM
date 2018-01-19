

@extends('main')


@section('content')





    <div class="card" style="padding:10px;">
        <div class="card-body">
            <h4 class="card-title">Assign Lead To User</h4>

            <form action="{{route('assignStore')}}" method="post" id="assign-form">
                {{csrf_field()}}

                <div class="form-group">
                    <label>Name</label>

                    <div class="form-group">
                        <label for="sel1">Select Name:</label>
                        <select class="form-control"  name="assignTo" id="otherCatches">
                            <option value="">select</option>
                            @foreach($users as $user)
                                <option value="{{$user->id}}">{{$user->firstName}}</option>

                            @endforeach


                        </select>
                    </div>

                    <input type="text" class="form-control" id="inp" name="leadId">

                </div>

            </form>


            <button onclick="test()" >test</button>

            <div class="table-responsive m-t-40">
                <table id="myTable" class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th>Select</th>
                        <th>Company Name</th>
                        <th>Category</th>
                        <th>Website</th>
                        <th>Email</th>
                        <th>Country</th>
                        <th>Comments</th>
                        <th>Mined By</th>
                        <th>Created At</th>
                        <th>Delete</th>

                    </tr>
                    </thead>
                    <tbody>


                    @foreach($leads as $lead)
                        <tr>
                            <td><input type='checkbox' class="checkboxvar" name="checkboxvar[]" value="{{$lead->leadId}}"></td>
                            <td>{{$lead->companyName}}</td>
                            <td>{{$lead->category->categoryName}}</td>
                            <td>{{$lead->website}}</td>
                            <td>{{$lead->email}}</td>
                            <td>{{$lead->country->countryName}}</td>
                            <td>{{$lead->comments}}</td>
                            <td>{{$lead->mined->firstName}}</td>
                            <td>{{$lead->created_at}}</td>



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

        $('input[name="checkboxvar"]').click(function () {

            alert("Thanks for checking me");

        });

//        $('#edit-modal').on('show.bs.modal', function(e) {
//
//            var $modal = $(this),
//                esseyId = e.relatedTarget.id;
//                esseyName = e.relatedTarget.name;
//
//                var chkArray = [];
//
//            $('.checkboxvar:checked').each(function (i) {
//                   // chkArray.push($(this).val());
//                chkArray[i] = $(this).val();
//                });
//
//           alert(chkArray[0]);
//            $.each( chkArray, function( key, value ) {
//                alert( key + ": " + value );
//            });
//            $modal.find('#modalTitle').html(chkArray);
//            $modal.find('#inp').val(chkArray);
//
//        })

        $("#otherCatches").change(function() {
            alert($(this).val()); // how to get the value of the selected item if you need it
        });


        function test() {
            var chkArray = [];
            $('.checkboxvar:checked').each(function (i) {
                // chkArray.push($(this).val());
                chkArray[i] = $(this).val();
            });
            alert(chkArray);
        }

    </script>


@endsection