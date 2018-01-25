@extends('main')

@section('content')
  <div class="box-body">
    <div class="card" style="padding: 2px;">
        <div class="card-body">
			<h2 style="display: inline-block; margin: 0px 200px;">List of users</h2>
			<a class="btn btn-primary" href="{{ route('user-management.create') }}">Add new user</a>
            <div class="table-responsive m-t-40" >
            <table id="myTable" class="table table-striped table-condensed" style="font-size:14px;">
            <thead>
              <tr>
                <th>User Name</th>
                <th>Email</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Status</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
            @foreach ($users as $user)
                <tr>
                  <td>{{ $user->userId }}</td>
                  <td>{{ $user->userEmail }}</td>
                  <td>{{ $user->firstName }}</td>
                  <td>{{ $user->lastName }}</td>
                  <td >
					@if ($user->active == 1)Active
					@elseif ($user->active == 0)Inactive
					@endif
				</td>
                  <td>
                    <form method="POST" action="{{ route('user-management.destroy', ['id' => $user->id]) }}" onsubmit = "return confirm('Are you sure?')">
                        <input type="hidden" name="_method" value="DELETE">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <a href="{{ route('user-management.edit', ['id' => $user->id]) }}" class="btn btn-info btn-sm">
							<i class="fa fa-pencil-square-o"></i>
                        </a>
						@if ($user->userId != Auth::user()->userId)
                        <button type="submit" class="btn btn-danger btn-sm">
							<i class="fa fa-trash"></i>
                        </button>
						@endif
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
@endsection