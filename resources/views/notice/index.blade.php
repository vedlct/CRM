@extends('main')

@section('content')
  <div class="box-body">
    <div class="card" style="padding: 2px;">
        <div class="card-body">
			<h2 align="center"><b>Notices</b></h2>
			<a class="btn btn-primary" href="{{ route('notice.create') }}">Add new notice</a>
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
				  <?php /*
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
				*/ ?>
					
                    <form method="POST" action="{{ route('notice.destroy', ['id' => $notice->noticeId]) }}" onsubmit = "return confirm('Are you sure?')">
                        <input type="hidden" name="_method" value="DELETE">
							<input type="hidden" name="_token" value="{{ csrf_token() }}">
							<!-- Trigger the Edit modal with a button -->
							<a href="#edit_modal" data-toggle="modal" class="btn btn-info btn-sm"
							   data-notice-id="{{$notice->noticeId}}"
							   data-notice-msg="{{$notice->msg}}"
							   data-notice-category="{{$notice->categoryId}}"">
								<i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>

								
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
    </div>
  </div>
  
  
  
  
  
			  
			  
			  
			  
			  
			  
			  
			  <!--edit notice-->
		<div class="modal" id="edit_modal" style="">
			<div class="modal-dialog" style="max-width: 40%;">
					
				<form class="modal-content" method="post" action="{{ route('notice.update', ['id' => 1])}}">
					<input type="hidden" name="_method" value="PUT">
						{{csrf_field()}} 
					<input id="noticeId" type="hidden" class="form-control" name="noticeId"  required autofocus>
						  
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
						<h4 class="modal-title" name="modal-title">Update Notice</h4>
					</div>

							

					<div class="col-md-12">
						<div class="form-group row{{ $errors->has('msg') ? ' has-error' : '' }}">
							<label for="msg" class="col-sm-4 control-label">Notice Name</label>

							<div class="col-sm-8">
                                <textarea id="msg" class="form-control form-control-warning" name="msg" style="width:100%; height:200px" required autofocus>{{ $notice->msg }}</textarea>

                                @if ($errors->has('msg'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('msg') }}</strong>
                                    </span>
                                @endif
							</div>
						</div>
					</div>

					<div class="col-md-12">
						<div class="form-group row{{ $errors->has('msg') ? ' has-error' : '' }}">
							<label for="msg" class="col-sm-4 control-label">Notice Name</label>

							<div class="col-sm-8">

                                <select name="categoryId" class="form-control form-control-warning">
                                    @foreach ($categories as $category)
                                       <option {{$notice->categoryId == $category->categoryId ? 'selected' : ''}} value="{{$category->categoryId}}">{{$category->categoryName}}</option>

                                    @endforeach
                                </select>

                                @if ($errors->has('categoryId'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('categoryId') }}</strong>
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
  
  
  
  
  <!-- /.box-body -->
</div>
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
				
				
				
				
		//for Edit modal

		$('#edit_modal').on('show.bs.modal', function(e) {

			//get data-id attribute of the clicked element
			var noticeId = $(e.relatedTarget).data('notice-id');
			var msg = $(e.relatedTarget).data('msg');
			var noticeCategory = $(e.relatedTarget).data('notice-category');
			
			//populate the textbox
			$(e.currentTarget).find('input[name="noticeId"]').val(noticeId);
			$(e.currentTarget).find('input[name="msg"]').val(msg);
			$(e.currentTarget).find('input[name="noticeCategory"]').val(noticeCategory);

		});
			</script>


		@endsection