@extends('main')

@section('content')
  <div class="box-body">
    <div class="card" style="max-width: 300px;">
        <div class="card-body">
			<h2 style="display: inline-block; margin: 0px 200px;">List of category</h2>
			<a class="btn btn-primary" href="{{ route('category.create') }}">Add new category</a>
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
                    <form method="POST" action="{{ route('category.destroy', ['id' => $category->categoryId]) }}" onsubmit = "return confirm('Are you sure?')">
                        <input type="hidden" name="_method" value="DELETE">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <a href="{{ route('category.edit', ['id' => $category->categoryId]) }}" class="btn btn-info btn-sm">
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
@endsection