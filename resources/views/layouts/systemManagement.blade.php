@extends('main')

@section('content')



    {{--Country Start--}}

    <div class="box-body">
        <div class="card" style="padding: 2px; max-width:50%; overflow: hidden; display: block; display: inline-block; float:left; margin-right: 10px;">
            <div class="card-body">
                <h2 style="display: inline-block; margin: 0px 50px;">List of Country</h2>
                <a href="#create_country_modal" data-toggle="modal" class="btn btn-info btn-sm"><i class="glyphicon glyphicon-plus"></i>Add Country</i></a>

                <div class="table-responsive m-t-40" >
                    <table id="countryTable" class="table table-striped table-condensed" style="font-size:14px;">
                        <thead>
                        <tr>
                            <th>Country Name</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($countries as $country)
                            <tr>
                                <td>{{ $country->countryName }}</td>
                                <td>
                                {{--<form method="POST" action="{{ route('country.destroy', ['id' => $country->countryId]) }}" onsubmit = "return confirm('Are you sure?')">--}}
                                {{--<input type="hidden" name="_method" value="DELETE">--}}
                                {{--<input type="hidden" name="_token" value="{{ csrf_token() }}">--}}
                                <!-- Trigger the Edit modal with a button -->
                                    <a href="#edit_country_modal" data-toggle="modal" class="btn btn-info btn-sm"
                                       data-country-id="{{$country->countryId}}"
                                       data-country-name="{{$country->countryName}}"
                                       data-country-type="{{$country->type}}"">
                                    <i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>

                                    {{--<button type="submit" class="btn btn-danger btn-sm">--}}
                                    {{--<i class="fa fa-trash"></i>--}}
                                    {{--</button>--}}
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>






        <!--Create Country-->
        <div class="modal" id="create_country_modal" style="">
            <div class="modal-dialog" style="max-width: 40%;">

                <form class="modal-content" method="post" action="{{ route('country.store') }}">

                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                        <h4 class="modal-title" name="modal-title">Create Country</h4>
                    </div>

                    {{ csrf_field() }}

                    <div class="col-md-12">
                        <div class="form-group row{{ $errors->has('countryName') ? ' has-error' : '' }}">
                            <label for="countryName" class="col-sm-4 control-label">Country Name</label>

                            <div class="col-sm-8">
                                <input id="countryName" type="text" class="form-control" name="countryName" value="{{ old('countryName') }}" required autofocus>

                                @if ($errors->has('countryName'))
                                    <span class="help-block">
										<strong>{{ $errors->first('countryName') }}</strong>
									</span>
                                @endif
                            </div>
                        </div>

                        <div class="col-md-12" align="center">
                            <button type="submit" class="btn btn-primary">
                                Create
                            </button>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>

                </form>
            </div>
        </div>



        <!--edit country-->
        <div class="modal" id="edit_country_modal" style="">
            <div class="modal-dialog" style="max-width: 40%;">

                <form class="modal-content" method="post" action="{{ route('country.update', ['id' => 1])}}">
                    <input type="hidden" name="_method" value="PUT">
                    {{csrf_field()}}
                    <input id="countryId" type="hidden" class="form-control" name="countryId"  required autofocus>

                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                        <h4 class="modal-title" name="modal-title">Update Country</h4>
                    </div>

                    <div class="col-md-12">
                        <div class="form-group row{{ $errors->has('countryName') ? ' has-error' : '' }}">
                            <label for="countryName" class="col-sm-4 control-label">Country Name</label>

                            <div class="col-sm-8">
                                <input id="countryName" type="text" class="form-control" name="countryName" value="{{ $country->countryName }}" required autofocus>

                                @if ($errors->has('countryName'))
                                    <span class="help-block">
										<strong>{{ $errors->first('countryName') }}</strong>
									</span>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12" align="center">
                        <button class="btn btn-success" type="submit">Update</button></br>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>



    </div><!-- /.box-body -->

    {{--Status--}}

    <div class="card" style="padding: 2px; max-width:50%; overflow: hidden; display: block; display: inline-block; float: left; ">

        <div class="card-body">
            <h2 style="display: inline-block; margin: 0px 50px;">List of status</h2>
            <div class="table-responsive m-t-40" >
                <table id="status" class="table table-striped table-condensed" style="font-size:14px;">
                    <thead>
                    <tr>
                        <th>Status Name</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($statuses as $status)
                        <tr>
                            <td>{{ $status->statusName }}</td>
                            <td>
                                <!-- Trigger the Edit modal with a button -->
                                <a href="#edit_status_modal" data-toggle="modal" class="btn btn-info btn-sm"
                                   data-status-id="{{$status->statusId}}"
                                   data-status-name="{{$status->statusName}}"
                                   data-status-type="{{$status->type}}"">
                                <i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>





    <!--edit status-->
    <div class="modal" id="edit_status_modal" style="">
        <div class="modal-dialog" style="max-width: 40%;">

            <form class="modal-content" method="post" action="{{ route('status.update', ['id' => 1])}}">
                <input type="hidden" name="_method" value="PUT">
                {{csrf_field()}}
                <input id="statusId" type="hidden" class="form-control" name="statusId"  required autofocus>

                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title" name="modal-title">Update Status</h4>
                </div>



                <div class="col-md-12">
                    <div class="form-group row{{ $errors->has('statusName') ? ' has-error' : '' }}">
                        <label for="statusName" class="col-sm-4 control-label">Status Name</label>

                        <div class="col-sm-8">
                            <input id="statusName" type="text" class="form-control" name="statusName" value="{{ $status->statusName }}" required autofocus>

                            @if ($errors->has('statusName'))
                                <span class="help-block">
										<strong>{{ $errors->first('statusName') }}</strong>
									</span>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="col-md-12" align="center">
                    <button class="btn btn-success" type="submit">Update</button></br>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>





    {{--Category start--}}
    <div>
        <div class="card" style="padding: 2px; max-width:50%; overflow: hidden; display: block; display: inline-block; margin-left:10px; float: left;">
            <div class="card-body">
                <h2 style="display: inline-block; margin: 0px 50px;">List of category</h2>
                <a href="#create_category_modal" data-toggle="modal" class="btn btn-info btn-sm"><i class="glyphicon glyphicon-plus"></i>Add Category</i></a>


                <div class="table-responsive m-t-40" >
                    <table id="myTable" class="table table-striped table-condensed" style="font-size:14px;">
                        <thead>
                        <tr>
                            <th>Category Name</th>
                            <th>Type</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($categories as $category)
                            <tr>
                                <td>{{ $category->categoryName }}</td>
                                <td>@if ($category->type == 1)Lead
                                    @elseif ($category->type == 2)Notices
                                    @endif</td>
                                <td>

                                    <!-- Trigger the Edit modal with a button -->
                                        <a href="#edit_category_modal" data-toggle="modal" class="btn btn-info btn-sm"
                                           data-category-id="{{$category->categoryId}}"
                                           data-category-name="{{$category->categoryName}}"
                                           data-category-type="{{$category->type}}"">
                                        <i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>



                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>






        <!--Create Category-->
        <div class="modal" id="create_category_modal" style="">
            <div class="modal-dialog" style="max-width: 40%;">

                <form class="modal-content" method="post" action="{{ route('category.store') }}">

                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                        <h4 class="modal-title" name="modal-title">Create Category</h4>
                    </div>

                    {{ csrf_field() }}

                    <div class="col-md-12">
                        <div class="form-group row{{ $errors->has('categoryName') ? ' has-error' : '' }}">
                            <label for="categoryName" class="col-sm-4 control-label">Category Name</label>

                            <div class="col-sm-8">
                                <input id="categoryName" type="text" class="form-control" name="categoryName" value="{{ old('categoryName') }}" required autofocus>

                                @if ($errors->has('categoryName'))
                                    <span class="help-block">
										<strong>{{ $errors->first('categoryName') }}</strong>
									</span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row{{ $errors->has('type') ? ' has-error' : '' }}">
                            <label for="type" class="col-sm-4 control-label">Type</label>
                            <div class="col-sm-8">

                                <select name="type" class="form-control form-control-warning">
                                    <option value="1">Lead</option>
                                    <option value="2">Notice</option>
                                </select>

                                @if ($errors->has('type'))
                                    <span class="help-block">
										<strong>{{ $errors->first('type') }}</strong>
									</span>
                                @endif
                            </div>
                        </div>

                        <div class="col-md-12" align="center">
                            <button type="submit" class="btn btn-primary">
                                Create
                            </button>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>

                </form>
            </div>
        </div>

        <!--edit category-->
        <div class="modal" id="edit_category_modal" style="">
            <div class="modal-dialog" style="max-width: 40%;">

                <form class="modal-content" method="post" action="{{ route('category.update', ['id' => 1])}}">
                    <input type="hidden" name="_method" value="PUT">
                    {{csrf_field()}}
                    <input id="categoryId" type="hidden" class="form-control" name="categoryId"  required autofocus>
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                        <h4 class="modal-title" name="modal-title">Update Category</h4>
                    </div>


                    <div class="col-md-12">
                        <div class="form-group row{{ $errors->has('categoryName') ? ' has-error' : '' }}">
                            <label for="categoryName" class="col-sm-4 control-label">Category Name</label>

                            <div class="col-sm-8">
                                <input id="categoryName" type="text" class="form-control" name="categoryName" value="{{ $category->categoryName }}" required autofocus>

                                @if ($errors->has('categoryName'))
                                    <span class="help-block">
											<strong>{{ $errors->first('categoryName') }}</strong>
										</span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group row{{ $errors->has('type') ? ' has-error' : '' }}">
                            <label for="type" class="col-sm-4 control-label">Type</label>
                            <div class="col-sm-8">

                                <select name="type" class="form-control form-control-warning">
                                    <option value="1">Lead</option>
                                    <option value="2">Notice</option>
                                </select>

                                @if ($errors->has('type'))
                                    <span class="help-block">
											<strong>{{ $errors->first('type') }}</strong>
										</span>
                                @endif
                            </div>
                        </div>

                        <div class="col-md-12" align="center">
                            <button class="btn btn-success" type="submit">Update</button></br>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        </div></form>
                {{--<button>Leave</button>--}}
            </div>
        </div>
    </div><!-- Category End -->

@endsection


@section('foot-js')
    <script src="{{url('assets/plugins/datatables/jquery.dataTables.min.js')}}"></script>
    <script src="{{url('cdn.datatables.net/buttons/1.2.2/js/dataTables.buttons.min.js')}}"></script>
    <script src="{{url('cdn.datatables.net/buttons/1.2.2/js/buttons.flash.min.js')}}"></script>
    <script src="{{url('cdn.datatables.net/buttons/1.2.2/js/buttons.html5.min.js')}}"></script>

    <script>
        $(document).ready(function() {
            $('#myTable').DataTable();
            $('#countryTable').DataTable();
            $('#statusTable').DataTable();

        });


        //for category Create modal

        $('#create_category_modal').on('show.bs.modal', function(e) {

            //get data-id attribute of the clicked element
            var categoryId = $(e.relatedTarget).data('category-id');
            var categoryName = $(e.relatedTarget).data('category-name');
            var type = $(e.relatedTarget).data('category-type');

            //populate the textbox
            $(e.currentTarget).find('input[name="categoryId"]').val(categoryId);
            $(e.currentTarget).find('input[name="categoryName"]').val(categoryName);
            $(e.currentTarget).find('input[name="type"]').val(type);

        });

        //for category Edit modal

        $('#edit_category_modal').on('show.bs.modal', function(e) {

            //get data-id attribute of the clicked element
            var categoryId = $(e.relatedTarget).data('category-id');
            var categoryName = $(e.relatedTarget).data('category-name');
            var type = $(e.relatedTarget).data('category-type');

            //populate the textbox
            $(e.currentTarget).find('input[name="categoryId"]').val(categoryId);
            $(e.currentTarget).find('input[name="categoryName"]').val(categoryName);
            $(e.currentTarget).find('input[name="type"]').val(type);

        });




        //for country Create modal

        $('#create_country_modal').on('show.bs.modal', function(e) {

            //get data-id attribute of the clicked element
            var countryId = $(e.relatedTarget).data('country-id');
            var countryName = $(e.relatedTarget).data('country-name');

            //populate the textbox
            $(e.currentTarget).find('input[name="countryId"]').val(countryId);
            $(e.currentTarget).find('input[name="countryName"]').val(countryName);

        });

        //for country Edit modal
        $('#edit_country_modal').on('show.bs.modal', function(e) {

            //get data-id attribute of the clicked element
            var countryId = $(e.relatedTarget).data('country-id');
            var countryName = $(e.relatedTarget).data('country-name');

            //populate the textbox
            $(e.currentTarget).find('input[name="countryId"]').val(countryId);
            $(e.currentTarget).find('input[name="countryName"]').val(countryName);

        });

        $('#edit_status_modal').on('show.bs.modal', function(e) {

            //get data-id attribute of the clicked element
            var statusId = $(e.relatedTarget).data('status-id');
            var statusName = $(e.relatedTarget).data('status-name');

            //populate the textbox
            $(e.currentTarget).find('input[name="statusId"]').val(statusId);
            $(e.currentTarget).find('input[name="statusName"]').val(statusName);

        });

    </script>
@endsection