@extends('main')
@section('content')


    {{--Edit Company Modal--}}


    <div style="text-align: center;" class="modal" id="editCompanyModal" >
        <div class="modal-dialog" style="max-width: 60%;">
            <div class="modal-content" >
                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Edit Lead</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <!-- Modal body -->
                <div class="modal-body" id="">
                    <div id="editCompanyModalBody">


                    </div>


                </div>
                <!-- Modal footer -->
                <div class="modal-footer">

                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                </div>

            </div>
        </div>
    </div>





    {{-- End Add Company Modal--}}

    <div class="card">
        <div class="card-body">
            <h4 align="center">Add Company</h4>
            <form method="post" action="{{route('local.addCompany')}}">
                {{csrf_field()}}
            <div class="row">
                <div class="form-group col-md-4">
                    <label>Company Name</label>
                    <input class="form-control" name="companyName" placeholder="name">
                </div>

                <div class="form-group col-md-4">
                    <label>Website</label>
                    <input class="form-control" name="website" placeholder="www">
                </div>

                <div class="form-group col-md-4">
                    <label>Contact Person</label>
                    <input class="form-control" name="contactPerson" placeholder="person name">
                </div>

                <div class="form-group col-md-4">
                    <label>Email</label>
                    <input class="form-control" name="email" placeholder="email">
                </div>

                <div class="form-group col-md-4">
                    <label>Contact Number</label>
                    <input class="form-control" name="mobile" placeholder="mobile">
                </div>




                <div class="form-group col-md-4">
                    <label>Tnt Number</label>
                    <input class="form-control" name="tnt" placeholder="tnt">
                </div>


                <div class="form-group col-md-4">
                    <label>Area</label>
                    <select class="form-control" name="areaId" required>
                        <option value="">Select Area</option>
                        @foreach($areas as $area)
                            <option value="{{$area->areaId}}">{{$area->areaName}}</option>
                        @endforeach
                    </select>

                </div>

                <div class="form-group col-md-4">
                    <label>Address</label>
                    <textarea class="form-control" name="address" placeholder="address..." rows="5"></textarea>
                </div>



                <div class="col-md-12">
                   <button class="btn btn-success">Insert</button>
                </div>

            </div>
            </form>


            <div class="table-responsive m-t-40">
                <table id="myTable" class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th width="15%">Company Name</th>
                        <th width="15%">website</th>
                        <th width="10%">Contact Person</th>
                        <th width="10%">Email</th>
                        <th width="10%">Number</th>
                        <th width="10%">Tnt Number</th>
                        <th width="10%">Area</th>
                        <th width="15%">Address</th>
                        <th width="5%">Action</th>

                    </tr>
                    </thead>
                    <tbody>
                    @foreach($companies as $company)
                        <tr>
                            <td>{{$company->companyName}}</td>
                            <td>{{$company->website}}</td>
                            <td>{{$company->contactPerson}}</td>
                            <td>{{$company->email}}</td>
                            <td>{{$company->mobile}}</td>
                            <td>{{$company->tnt}}</td>
                            <td>{{$company->areaId}}</td>
                            <td>{{$company->address}}</td>
                            <td><button class="btn btn-default btn-sm" data-panel-id="{{$company->local_companyId}}" onclick="editCompany(this)"><i class="fa fa-edit"></i></button></td>


                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>


        </div>

    </div>




@endsection

@section('bottom')




    {{--<script src="{{url('js/select2.min.js')}}"></script>--}}
    <script src="{{url('assets/plugins/datatables/jquery.dataTables.min.js')}}"></script>
    <script src="{{url('cdn.datatables.net/buttons/1.2.2/js/dataTables.buttons.min.js')}}"></script>
    <script src="{{url('cdn.datatables.net/buttons/1.2.2/js/buttons.flash.min.js')}}"></script>
    <script src="{{url('cdn.datatables.net/buttons/1.2.2/js/buttons.html5.min.js')}}"></script>

    <script>
        $(function() {
            $('#myTable').DataTable()

        });

        function editCompany(x) {
            var companyId=$(x).data('panel-id');


            $.ajax({
                type: 'POST',
                url: "{!! route('local.getCompanyModal') !!}",
                cache: false,
                data: {_token: "{{csrf_token()}}",'companyId': companyId},
                success: function (data) {
//                    console.log(data);
                    $("#editCompanyModalBody").html(data);
                    $("#editCompanyModal").modal();
                }
            });


        }


    </script>

@endsection