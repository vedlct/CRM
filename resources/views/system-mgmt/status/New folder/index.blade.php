@extends('main')

@section('content')
    <div class="card" style="padding: 2px;">
        <div class="card-body">
			<h2 style="display: inline-block; margin: 0px 200px;">List of statuses</h2>
			<a class="btn btn-primary" href="{{ route('status.create') }}">Add new status</a>
            <div class="table-responsive m-t-40" >
            <table id="myTable" class="table table-striped table-condensed" style="font-size:14px;">
            <thead>
              <tr role="row">
                <th>Possibility Name</th>
                <th t>Action</th>
              </tr>
            </thead>
            <tbody>
            @foreach ($statuses as $status)
                <tr>
                  <td>{{ $status->statusName }}</td>
                  <td>
                    <form method="POST" action="{{ route('status.destroy', ['id' => $status->statusId]) }}" onsubmit = "return confirm('Are you sure?')">
                        <input type="hidden" name="_method" value="DELETE">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <a href="{{ route('status.edit', ['id' => $status->statusId]) }}" class="btn btn-info btn-sm">
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
@endsection