@extends('main')

@section('content')
  <div class="box-body">

    <div class="card" style="padding: 2px; max-width:50%; ">

        <div class="card-body">
			<h2 style="display: inline-block; margin: 0px 50px;">List of status</h2>
			<a href="#create_modal" data-toggle="modal" class="btn btn-info btn-sm"><i class="glyphicon glyphicon-plus"></i>Add Status</i></a>
            <div class="table-responsive m-t-40" >
            <table id="myTable" class="table table-striped table-condensed" style="font-size:14px;">
            <thead>
              <tr>
                <th>Status Name</th>
                <th>Action</th>
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
							

							<!-- Trigger the Edit modal with a button -->
							<a href="#edit_modal" data-toggle="modal" class="btn btn-info btn-sm"
							   data-status-id="{{$status->statusId}}"
							   data-status-name="{{$status->statusName}}"
							   data-status-type="{{$status->type}}"">
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
			  
			  
			  
			  
			  
			  
			  
			  
			  
			  
			  
			  
			  
			  
			  
			  
			  
			  
			  
			  
			  
			  <!--edit status-->
		<div class="modal" id="edit_modal" style="">
			<div class="modal-dialog" style="max-width: 40%;">
					
				<form class="modal-content" method="post" action="{{ route('status.update', ['id' => 1])}}">
					<input type="hidden" name="_method" value="PUT">
						{{csrf_field()}} 
					<input id="statusId" type="hidden" class="form-control" name="statusId"  required autofocus>
						  
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
						<h4 class="modal-title" name="modal-title">Update Status</h4>
					</div>

							

					<div class="col-md-12">
						<div class="form-group row{{ $errors->has('statusName') ? ' has-error' : '' }}">
							<label for="statusName" class="col-sm-4 control-label">Status Name</label>

							<div class="col-sm-8">
								<input id="statusName" type="text" class="form-control" name="statusName" value="{{ $status->statusName }}" required autofocus>

								@if ($errors->has('statusName'))
									<span class="help-block">
										<strong>{{ $errors->first('statusName') }}</strong>
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

		$('#edit_modal').on('show.bs.modal', function(e) {

			//get data-id attribute of the clicked element
			var statusId = $(e.relatedTarget).data('status-id');
			var statusName = $(e.relatedTarget).data('status-name');
			
			//populate the textbox
			$(e.currentTarget).find('input[name="statusId"]').val(statusId);
			$(e.currentTarget).find('input[name="statusName"]').val(statusName);

		});
	</script>
@endsection