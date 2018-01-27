@extends('main')

@section('content')
  <div class="box-body">
    <div class="card" style="max-width: 45%;">
        <div class="card-body">
			<h2 align="center">List of countries</h2>
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal">
                Add new country
            </button>


            <div class="table-responsive m-t-40" >
            <table id="myTable" class="table table-striped table-condensed" style="font-size:14px;">
            <thead>
              <tr role="row">
                <th>Country Name</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
            @foreach ($countries as $country)
                <tr>
                  <td>{{ $country->countryName }}</td>
                  <td>
                    <form method="POST" action="{{ route('country.destroy', ['id' => $country->countryId]) }}" onsubmit = "return confirm('Are you sure?')">
                        <input type="hidden" name="_method" value="DELETE">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <a href="{{ route('country.edit', ['id' => $country->countryId]) }}" class="btn btn-info btn-sm">
							<i class="fa fa-pencil-square-o"></i>
                        </a>
                        <button type="submit" class="btn btn-danger btn-sm">
                          <i class="fa fa-trash"></i>
                        </button>
                    </form>
                  </td>
              </tr>
            @endforeach
            </tbody>
          </table>
        </div>
      </div>

		@section('foot-js')
			<script src="{{asset('assets/plugins/datatables/jquery.dataTables.min.js')}}"></script>
			<script src="{{asset('cdn.datatables.net/buttons/1.2.2/js/dataTables.buttons.min.js')}}"></script>
			<script src="{{asset('cdn.datatables.net/buttons/1.2.2/js/buttons.flash.min.js')}}"></script>
			<script src="{{asset('cdn.datatables.net/buttons/1.2.2/js/buttons.html5.min.js')}}"></script>

			<script>
				$(document).ready(function() {
					$('#myTable').DataTable();

				});
			</script>
		@endsection
    </div>
  </div>
  <!-- /.box-body -->
</div>




  <!-- The Modal -->
  <div class="modal fade" id="myModal">
      <div class="modal-dialog">
          <div class="modal-content">

              <!-- Modal Header -->
              <div class="modal-header">
                  <h4 class="modal-title">Modal Heading</h4>
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
              </div>

              <!-- Modal body -->
              <div class="modal-body">

                  <form class="form-horizontal" role="form" method="POST" action="{{ route('country.store') }}">
                      {{ csrf_field() }}

                      <div class="form-group{{ $errors->has('countryName') ? ' has-error' : '' }}">
                          <label for="countryName" class="col-md-4 control-label">Country Name</label>

                          <div class="col-md-6">
                              <input id="countryName" type="text" class="form-control" name="countryName" value="{{ old('countryName') }}" required autofocus>

                              @if ($errors->has('countryName'))
                                  <span class="help-block">
                                        <strong>{{ $errors->first('countryName') }}</strong>
                                    </span>
                              @endif
                          </div>
                      </div>
                      <div class="form-group">
                          <div class="col-md-6 col-md-offset-4">
                              <button type="submit" class="btn btn-primary">
                                  Create
                              </button>
                          </div>
                      </div>
                  </form>




              </div>

              <!-- Modal footer -->
              <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              </div>

          </div>
      </div>
  </div>





@endsection