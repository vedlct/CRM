@extends('main')


@section('content')

@php($userType = Session::get('userType'))

	<div class="box-body">
		<div class="card" style="padding: 2px;">
			<div class="card-body">
				<h2 align="center"><b>Communication</b></h2>

				@if($userType =='ADMIN' || $userType =='MANAGER' || $userType =='SUPERVISOR')
					<a href="#create_notice_modal" data-toggle="modal" class="btn btn-custom">Add Communiction</a>

				@endif

				@if($userType =='ADMIN' || $userType =='MANAGER' || $userType =='SUPERVISOR')
					<a href="#individual_message" data-toggle="modal" class="btn btn-info">Send Individual Message</a>

				@endif

				@if ($errors->has('msg'))
					<span class="help-block">
					<strong>{{ $errors->first('msg') }}</strong>
				</span>
				@endif

				</div>
		</div>
	</div>

			<div class="row">
			<div class="card-columns">
				@foreach ($notices as $notice)
					<div class="col-md-12">
					<div class="card">
						<div class="card-body">
						<h3 class="card-title">{{ $notice->title }}</h3>
						<p class="card-text">
							{!! nl2br(e($notice->msg)) !!}
							<br>
						</p>

						<footer class="blockquote-footer">From {{ $recentNotice->user->firstName }} {{ $recentNotice->user->lastName }} at <cite>{{ Carbon\Carbon::parse($recentNotice->created_at)->format('d M Y') }}</cite>
					
						@if ($notice->categoryName == 'Urgent Notice') <span style="color: red; float: right;">Urgent Notice</span>@endif

						</footer></br>


								@if($userType == 'ADMIN' || $userType == 'MANAGER' || $userType == 'SUPERVISOR')
									<a href="#edit_notice_modal" data-toggle="modal" class="btn btn-custom btn-sm"
										data-notice-id="{{$notice->noticeId}}"
										data-notice-title="{{$notice->title}}"
										data-notice-msg="{{$notice->msg}}"
										data-category-id="{{$notice->categoryId}}">
										<i class="fa fa-pencil-square-o" aria-hidden="true"></i>
									</a>
									<!-- <a href="#delete_notice_modal" data-toggle="modal" class="btn btn-danger btn-sm"
										data-notice-id="{{ $notice->noticeId }}"
										data-notice-title="{{$notice->title}}"
										data-notice-msg="{{ $notice->msg }}"
										data-category-id="{{ $notice->categoryId }}">
										<i class="fa fa-close" aria-hidden="true"></i>
									</a> -->
								@endif
							</div>
						</div>
					</div>
				@endforeach
			</div>
			</div>








	<!--Create Notice/Communication-->
	<div class="modal" id="create_notice_modal" style="">
		<div class="modal-dialog" style="max-width: 60%;">

			<form class="modal-content" method="post" action="{{ route('notice.store') }}">

				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
					<h4 class="modal-title" name="modal-title">Create Communication</h4>
				</div>

				{{ csrf_field() }}

					<div class="col-md-12">

					<br>

					<div class="form-group row{{ $errors->has('msg') ? ' has-error' : '' }}">

						<label for="title" class="col-md-2 control-label">Title</label>
						<div class="col-md-10">
						<input id="title" class="form-control form-control-warning" name="title" style="width:100%;" required autofocus value="{{ old('title') }}">

							
						</div>

						
						<label for="msg" class="col-md-2 control-label">Communication</label>
						<div class="col-md-10">
						<br>
							<textarea id="msg" class="form-control form-control-warning" name="msg" style="width:100%; height:300px" required>{{ old('msg') }}</textarea>

							@if ($errors->has('msg'))
								<span class="help-block">
										<strong>"<p>".implode("</p>\n<p>", {{ $errors->first('msg') }}).")</p>\n";</strong>
									</span>
							@endif
						</div>
					</div>


					<div class="form-group row{{ $errors->has('categoryId') ? ' has-error' : '' }}">
						<label for="categoryId" class="col-md-2 control-label">Category</label>

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
				</div><br>

				<!-- <div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				</div> -->

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

						<label for="title" class="col-md-2 control-label">Title</label>
						<div class="col-md-10">
						<input id="title" class="form-control form-control-warning" name="title" style="width:100%;" required autofocus value="{{ $notice->title }}">

							@if ($errors->has('title'))
								<span class="help-block">
                                        <strong>{{ $errors->first('title') }}</strong>
                                    </span>
							@endif
						</div>
						
						<label for="msg" class="col-md-2 control-label">Message</label>
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
						<label for="categoryId" class="col-md-2 control-label">Category</label>

						<div class="col-md-10">

							<select name="categoryId" id="categoryId" class="form-control form-control-warning">
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
				</div><br>

				<!-- <div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				</div> -->
			</form>
		</div>
	</div>




<!--Create Individual Message-->
<div class="modal" id="individual_message" style="">
    <div class="modal-dialog" style="max-width: 30%;">
		<form class="modal-content" method="post" action="{{ route('storeIndividualMessage') }}">
            <div class="modal-header">
                <h4 class="modal-title" name="modal-title">Individual Message</h4>
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
            </div>
            {{ csrf_field() }}
            <div class="modal-body">
                <div class="form-group">
                    <label for="user" class="control-label">Marketer</label>
                    <select name="userId" class="form-control">
						@foreach ($users as $user)
	                        <option value="{{$user->id}}">{{$user->userId}}</option>
						@endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="comm" class="control-label">Communication</label>
                    <textarea name="message" class="form-control" rows="3"></textarea>
                </div>
            </div>

            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">
                    Send
                </button>
            </div>

        </form>
    </div>
</div>







<!-- /.box-body -->
</div>
@endsection

@section('foot-js')
	<script src="{{url('assets/plugins/datatables/jquery.dataTables.min.js')}}"></script>
	<!-- <script src="{{url('cdn.datatables.net/buttons/1.2.2/js/dataTables.buttons.min.js')}}"></script>
	<script src="{{url('cdn.datatables.net/buttons/1.2.2/js/buttons.flash.min.js')}}"></script>
	<script src="{{url('cdn.datatables.net/buttons/1.2.2/js/buttons.html5.min.js')}}"></script> -->
	<!-- <script src="gen_validatorv4.js" type="text/javascript"></script> -->

    <script src="https://cdn.datatables.net/buttons/1.5.6/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.flash.min.js"></script>


    <script src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.html5.min.js"></script>



	<script>
        



        //for Edit modal

        $('#edit_notice_modal').on('show.bs.modal', function(e) {

            //get data-id attribute of the clicked element
            var noticeId = $(e.relatedTarget).data('notice-id');
			var noticeTitle = $(e.relatedTarget).data('notice-title');
            var noticeMsg = $(e.relatedTarget).data('notice-msg');
            var categoryId = $(e.relatedTarget).data('category-id');
            //alert(categoryId);
            //populate the textbox
            $(e.currentTarget).find('input[name="noticeId"]').val(noticeId);
			$(e.currentTarget).find('input[name="title"]').val(noticeTitle);
            $(e.currentTarget).find('textarea[name="msg"]').val(noticeMsg);
            $(e.currentTarget).find('#categoryId').val(categoryId);



        });




        //for Edit modal

        $('#create_notice_modal').on('show.bs.modal', function(e) {

            //get data-id attribute of the clicked element
            var noticeId = $(e.relatedTarget).data('notice-id');
            var noticeTitle = $(e.relatedTarget).data('notice-title');
            var noticeMsg = $(e.relatedTarget).data('notice-msg');
            var categoryId = $(e.relatedTarget).data('category-id');
            //alert(noticeId);
            //populate the textbox
            $(e.currentTarget).find('input[name="noticeId"]').val(noticeId);
            $(e.currentTarget).find('input[name="title"]').val(noticeTitle);
            $(e.currentTarget).find('textarea[name="msg"]').val(noticeMsg);
            $(e.currentTarget).find('input[name="categoryId"]').val(categoryId);

        });


			// var frmvalidator = new Validator("create_notice_modal");
			// frmvalidator.addValidation("msg","maxlen=20","Max length for msg is 20");



</script>


@endsection
