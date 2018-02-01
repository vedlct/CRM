@extends('main')

@section('content')
  <div class="box-body">
    <div class="card" style="padding: 2px;">
        <div class="card-body">
			<h2 align="center"><b>Notices</b></h2>

            @if(Auth::user()->typeId ==1 || Auth::user()->typeId ==2 || Auth::user()->typeId ==3)
				<a href="#create_notice_modal" data-toggle="modal" class="btn btn-info btn-sm">Add Notice</a>

            @endif

            <div class="table-responsive m-t-40" >
            <table id="myTable" class="table table-striped table-condensed" style="font-size:14px;">
            <thead>
              <tr role="row">
                <th>Notice Name</th>
                <th>Notice</th>
				  @if(Auth::user()->typeId ==1 || Auth::user()->typeId ==2 || Auth::user()->typeId ==3)
				<th>Action</th>
					  @endif
              </tr>
            </thead>
            <tbody>
            @foreach ($notices as $notice)
                <tr>
                  <td>{{ $notice->msg }} </br><small><font color="blue">Uploaded By: {{ $notice->userId }} &nbsp; &nbsp; &nbsp; Uploaded Time: {{ $notice->created_at }}</font></small></td>
                  <td>
					  @if ($notice->categoryName  == 'General')
					   <font color="blue">General</font> 
						@elseif ($notice->categoryName  == 'Important')
						 <font color="pink">Important</font> 
						@elseif ($notice->categoryName  == 'Urgent')
						 <font color="red">Urgent</font> 
						@endif
					</td>
					@if(Auth::user()->typeId ==1 || Auth::user()->typeId ==2 || Auth::user()->typeId ==3)
                  <td>
					

							<!-- Trigger the Edit modal with a button -->
							<a href="#edit_notice_modal" data-toggle="modal" class="btn btn-info btn-sm"
							   data-notice-id="{{$notice->noticeId}}"
							   data-notice-msg="{{$notice->msg}}"">
								<i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>

								
						
                  </td>
						@endif
              </tr>
            @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
  
  
  
  
  
			  
			  
			  
			  
			  
		<!--Create Notice-->
		<div class="modal" id="create_notice_modal" style="">
			<div class="modal-dialog" style="max-width: 60%;">
		  
				<form class="modal-content" method="post" action="{{ route('notice.store') }}">
				
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
						<h4 class="modal-title" name="modal-title">Create Notice</h4>
					</div>
				
						{{ csrf_field() }}

					<div class="col-md-12">
						<div class="form-group row{{ $errors->has('msg') ? ' has-error' : '' }}">
							<label for="msg" class="col-md-2 control-label">Message</label>

							<div class="col-md-10">
								 <textarea id="msg" class="form-control form-control-warning" name="msg" style="width:100%; height:200px" required autofocus>{{ old('msg') }}</textarea>

								@if ($errors->has('msg'))
									<span class="help-block">
										<strong>{{ $errors->first('msg') }}</strong>
									</span>
								@endif
							</div>
						</div>

						
						<div class="form-group row{{ $errors->has('categoryId') ? ' has-error' : '' }}">
							<label for="categoryId" class="col-md-2 control-label">Notice</label>

							<div class="col-md-10">

                                <select name="categoryId" class="form-control form-control-warning">
                                    @foreach ($categories as $category)
                                       <option {{$notice->categoryId == $category->categoryId ? 'selected' : ''}} value="{{$category->categoryId}}">{{$category->categoryName}}</option>
                                    @endforeach
                                </select>
								
								@if ($errors->has('category'))
									<span class="help-block">
										<strong>{{ $errors->first('category') }}</strong>
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
			  
			  
			  
			  
			  
			  
			  
			  
			  
			  
			  
			  
			  
			  
			  
			  
			  
			  
			  
			  
			  <!--edit notice-->
		<div class="modal" id="edit_notice_modal" style="">
			<div class="modal-dialog" style="max-width: 60%;">
					
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
							<label for="msg" class="col-md-2 control-label">Notice Name</label>

							<div class="col-md-10">
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
						<div class="form-group row{{ $errors->has('categoryId') ? ' has-error' : '' }}">
							<label for="categoryId" class="col-md-2 control-label">Notice</label>

							<div class="col-md-10">

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

		$('#edit_notice_modal').on('show.bs.modal', function(e) {

			//get data-id attribute of the clicked element
			var noticeId = $(e.relatedTarget).data('notice-id');
			var noticeMsg = $(e.relatedTarget).data('notice-msg');
			var categoryId = $(e.relatedTarget).data('category-id');
			//alert(noticeId);
			//populate the textbox
			$(e.currentTarget).find('input[name="noticeId"]').val(noticeId);
			$(e.currentTarget).find('textarea[name="msg"]').val(noticeMsg);
			$(e.currentTarget).find('input[name="categoryId"]').val(categoryId);

		});
				
				
				
				
		//for Edit modal

		$('#create_notice_modal').on('show.bs.modal', function(e) {

			//get data-id attribute of the clicked element
			var noticeId = $(e.relatedTarget).data('notice-id');
			var noticeMsg = $(e.relatedTarget).data('notice-msg');
			var categoryId = $(e.relatedTarget).data('category-id');
			//alert(noticeId);
			//populate the textbox
			$(e.currentTarget).find('input[name="noticeId"]').val(noticeId);
			$(e.currentTarget).find('textarea[name="msg"]').val(noticeMsg);
			$(e.currentTarget).find('input[name="categoryId"]').val(categoryId);

		});
			</script>


		@endsection