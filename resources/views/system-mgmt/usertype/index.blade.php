@extends('main')

@section('content')
  <div class="box-body">
    <div class="card" style="padding: 2px;">
        <div class="card-body">
			<h2 style="display: inline-block; margin: 0px 200px;">List of usertype</h2>
			<a class="btn btn-primary" href="{{ route('usertype.create') }}">Add new usertype</a>
            <div class="table-responsive m-t-40" >
            <table id="myTable" class="table table-striped table-condensed" style="font-size:14px;">
            <thead>
              <tr>
                <th>Type Name</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
            @foreach ($usertypes as $usertype)
                <tr>
                  <td>{{ $usertype->typeName }}</td>
                  <td>
                    <form method="POST" action="{{ route('usertype.destroy', ['id' => $usertype->typeId]) }}" onsubmit = "return confirm('Are you sure?')">
                        <input type="hidden" name="_method" value="DELETE">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <a href="{{ route('usertype.edit', ['id' => $usertype->typeId]) }}" class="btn btn-info btn-sm">
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
    </section>
    <!-- /.content -->
  </div>
@endsection