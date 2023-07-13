@extends('main')


@section('content')

	@php($userType = Session::get('userType'))

		<h2 align="center" style="padding: 20px; font-weight: bold">Frequently Asked Questions</h2>


		@if($userType =='ADMIN' || $userType =='MANAGER' || $userType =='SUPERVISOR')
				<a href="#create_faq_modal" data-toggle="modal" class="btn btn-info btn-sm">Add FAQ</a>
		@endif

		@if ($errors->has('msg'))
			<span class="help-block">
				<strong>{{ $errors->first('msg') }}</strong>
			</span>
		@endif

		<br><hr>
		<div class="card">

			<div class="accordion" id="faqAccordion">
				@foreach ($notices as $notice)
					<div class="card">
						<div class="card-header" id="notice{{$notice->noticeId}}">
							<h2 class="mb-0">
							<button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapse{{$notice->noticeId}}" aria-expanded="true" aria-controls="collapse{{$notice->noticeId}}">
                        		<span style="color: black !important; text-decoration: none !important; background-color: transparent !important; border: none; padding: 0; outline: none; cursor: pointer; font-size: 20px; font-weight: 400;">{{ $notice->title }}</span>
                    		</button>
							</h2>
						</div>
						<div id="collapse{{$notice->noticeId}}" class="collapse" aria-labelledby="notice{{$notice->noticeId}}" data-parent="#faqAccordion">
							<div class="card-body">
							<span style="color: #333333 !important; background-color: transparent !important; border: none; padding: 10px; outline: none; cursor: pointer; font-size: 18px; font-weight: 300;">{!! nl2br(e($notice->msg)) !!}</span>
							<br><br>
								@if($userType == 'ADMIN' || $userType == 'MANAGER' || $userType == 'SUPERVISOR')
									<a href="#edit_faq_modal" data-toggle="modal" class="btn btn-info btn-sm"
										data-notice-id="{{$notice->noticeId}}"
										data-notice-title="{{$notice->title}}"
										data-notice-msg="{{$notice->msg}}"
										data-category-id="{{$notice->categoryId}}">
										<i class="fa fa-pencil-square-o" aria-hidden="true"></i>
									</a>
								@endif
							</div>
						</div>
					</div>
				@endforeach
			</div>
		</div>








	<!--Create FAQ-->
	<div class="modal" id="create_faq_modal" style="">
		<div class="modal-dialog" style="max-width: 60%;">

			<form class="modal-content" method="post" action="{{ route('faqCreate') }}">

				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
					<h4 class="modal-title" name="modal-title">Create FAQ</h4>
				</div>

				{{ csrf_field() }}

					<div class="col-md-12">

					<br>

					<div class="form-group row{{ $errors->has('msg') ? ' has-error' : '' }}">

						<label for="title" class="col-md-2 control-label">Question</label>
						<div class="col-md-10">
						<input id="title" class="form-control form-control-warning" name="title" style="width:100%;" required autofocus value="{{ old('title') }}">

							
						</div>

						
						<label for="msg" class="col-md-2 control-label">Answer</label>
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
				</div>

				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				</div>

			</form>
		</div>
	</div>







	<!--edit FAQ-->
	<div class="modal" id="edit_faq_modal" style="">
		<div class="modal-dialog" style="max-width: 60%;">

			<form class="modal-content" method="post" action="{{ route('faq.update', ['id' => $notice->noticeId]) }}">
				<!-- @method('PUT') -->

				<input type="hidden" name="_method" value="PUT">
				{{csrf_field()}}
				<input id="noticeId" type="hidden" class="form-control" name="noticeId"  required autofocus>

				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
					<h4 class="modal-title" name="modal-title">Update FAQ</h4>
				</div>


				<div class="col-md-12">
					<div class="form-group row{{ $errors->has('msg') ? ' has-error' : '' }}">

						<label for="title" class="col-md-2 control-label">Question</label>
						<div class="col-md-10">
						<input id="title" class="form-control form-control-warning" name="title" style="width:100%;" required autofocus value="{{ $notice->title }}">

							@if ($errors->has('title'))
								<span class="help-block">
                                        <strong>{{ $errors->first('title') }}</strong>
                                    </span>
							@endif
						</div>
						
						<label for="msg" class="col-md-2 control-label">Answer</label>
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
	<script src="{{url('assets/plugins/datatables/jquery.dataTables.min.js')}}"></script>
	<script src="{{url('cdn.datatables.net/buttons/1.2.2/js/dataTables.buttons.min.js')}}"></script>
	<script src="{{url('cdn.datatables.net/buttons/1.2.2/js/buttons.flash.min.js')}}"></script>
	<script src="{{url('cdn.datatables.net/buttons/1.2.2/js/buttons.html5.min.js')}}"></script>
	<!-- <script src="gen_validatorv4.js" type="text/javascript"></script> -->




	<script>
        



        //for Edit modal

        $('#edit_faq_modal').on('show.bs.modal', function(e) {

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

        $('#create_faq_modal').on('show.bs.modal', function(e) {

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




</script>


@endsection
