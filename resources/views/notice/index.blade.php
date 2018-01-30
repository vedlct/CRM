@extends('main')

@section('content')
  <div class="box-body">
    <div class="card" style="padding: 2px;">
        <div class="card-body">
			<h2 align="center"><b>Notices</b></h2>

            @if(Auth::user()->typeId ==2)
			<a class="btn btn-primary" href="{{ route('notice.create') }}">Add new notice</a>
            @endif

            <div class="table-responsive m-t-40" >
            <table id="myTable" class="table table-striped table-condensed" style="font-size:14px;">
            <thead>
              <tr role="row">
                <th>Notice Name</th>
                <th>Category</th>
				<th>Action</th>
              </tr>
            </thead>
            <tbody>
            @foreach ($notices as $notice)
                <tr>
                  <td>{{ $notice->msg }} </br><small><font color="blue">Uploaded By: {{ $notice->userId }} &nbsp; &nbsp; &nbsp; Uploaded Time: {{ $notice->created_at }}</font></small></td>
                  <td>
					  @if ($notice->categoryName  == 'General')
					   <font color="blue">General</font> 
						@elseif ($notice->categoryName  == 'Importent')
						 <font color="pink">Important</font> 
						@elseif ($notice->categoryName  == 'Urgent')
						 <font color="red">Urgent</font> 
						@endif
					</td>
                  <td>
                    <form method="POST" action="{{ route('notice.destroy', ['id' => $notice->noticeId]) }}" onsubmit = "return confirm('Are you sure?')">
                        <input type="hidden" name="_method" value="DELETE">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <a href="{{ route('notice.edit', ['id' => $notice->noticeId]) }}" class="btn btn-info btn-sm">
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