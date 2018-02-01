@extends('main')

@section('content')
  <div class="box-body">


  
   
	  
			  
			  
		<!--Create Status-->
		<div class="modal" id="create_modal" style="">
			<div class="modal-dialog" style="max-width: 40%;">
		  
				<form class="modal-content" method="post" action="{{ route('status.store') }}">
				
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
						<h4 class="modal-title" name="modal-title">Create Status</h4>
					</div>
				
						{{ csrf_field() }}

					<div class="col-md-12">
						<div class="form-group row{{ $errors->has('statusName') ? ' has-error' : '' }}">
							<label for="statusName" class="col-sm-4 control-label">Status Name</label>

							<div class="col-sm-8">
								<input id="statusName" type="text" class="form-control" name="statusName" value="{{ old('statusName') }}" required autofocus>

								@if ($errors->has('statusName'))
									<span class="help-block">
										<strong>{{ $errors->first('statusName') }}</strong>
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
			  
			  
			  
			  
			  
			  
			  
			  
			  
			  
			  
			  
			  
			  
			  
			  
			  
			  
			  
			  

	 
	 
	 
	 
	 
	 
	 
	 
	</div><!-- /.box-body -->
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
			
		//for Create modal

		$('#create_modal').on('show.bs.modal', function(e) {

			//get data-id attribute of the clicked element
			var statusId = $(e.relatedTarget).data('status-id');
			var statusName = $(e.relatedTarget).data('status-name');
			
			//populate the textbox
			$(e.currentTarget).find('input[name="statusId"]').val(statusId);
			$(e.currentTarget).find('input[name="statusName"]').val(statusName);

		});
				
		//for Edit modal


	</script>
@endsection