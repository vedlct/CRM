	<div class="card" style="padding: 2px; max-width:50%; ">

        <div class="card-body">
			<h2 style="display: inline-block; margin: 0px 50px;">List of possibility</h2>
			<a href="#create_modal" data-toggle="modal" class="btn btn-info btn-sm"><i class="glyphicon glyphicon-plus"></i>Add Possibility</i></a>
			
			
            <div class="table-responsive m-t-40" >
				<table id="myTable" class="table table-striped table-condensed" style="font-size:14px;">
				<thead>
				  <tr>
					<th>Possibility Name</th>
					<th>Type</th>
					<th>Action</th>
				  </tr>
				</thead>
				<tbody>
				@foreach ($possibilities as $possibility)
					<tr>
					  <td>{{ $possibility->possibilityName }}</td>
					  <td>
						<form method="POST" action="{{ route('possibility.destroy', ['id' => $possibility->possibilityId]) }}" onsubmit = "return confirm('Are you sure?')">
							<input type="hidden" name="_method" value="DELETE">
							<input type="hidden" name="_token" value="{{ csrf_token() }}">
						  <?php /*  <a href="{{ route('possibility.edit', ['id' => $possibility->possibilityId]) }}" class="btn btn-info btn-sm">
								<i class="fa fa-pencil-square-o"></i>
							</a>*/?>
							

							<!-- Trigger the Edit modal with a button -->
							<a href="#edit_modal" data-toggle="modal" class="btn btn-info btn-sm"
							   data-possibility-id="{{$possibility->possibilityId}}"
							   data-possibility-name="{{$possibility->possibilityName}}"
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
	  
	  
	  
	  
			  
			  
		<!--Create Possibility-->
		<div class="modal" id="create_modal" style="">
			<div class="modal-dialog" style="max-width: 40%;">
		  
				<form class="modal-content" method="post" action="{{ route('possibility.store') }}">
				
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
						<h4 class="modal-title" name="modal-title">Create Possibility</h4>
					</div>
				
						{{ csrf_field() }}

					<div class="col-md-12">
						<div class="form-group row{{ $errors->has('possibilityName') ? ' has-error' : '' }}">
							<label for="possibilityName" class="col-sm-4 control-label">Possibility Name</label>

							<div class="col-sm-8">
								<input id="possibilityName" type="text" class="form-control" name="possibilityName" value="{{ old('possibilityName') }}" required autofocus>

								@if ($errors->has('possibilityName'))
									<span class="help-block">
										<strong>{{ $errors->first('possibilityName') }}</strong>
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
			  
			  
			  
			  
			  
			  
			  
			  
			  
			  
			  
			  
			  
			  
			  
			  
			  
			  
			  
			  
			  
			  <!--edit possibility-->
		<div class="modal" id="edit_modal" style="">
			<div class="modal-dialog" style="max-width: 40%;">
					
				<form class="modal-content" method="post" action="{{ route('possibility.update', ['id' => 1])}}">
				<input type="hidden" name="_method" value="PUT">
						  
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
						<h4 class="modal-title" name="modal-title">Update Possibility</h4>
					</div>
					
						{{csrf_field()}} 
						<input id="possibilityId" type="hidden" class="form-control" name="possibilityId"  required autofocus>

							

							<div class="col-md-12">
							<div class="form-group row{{ $errors->has('possibilityName') ? ' has-error' : '' }}">
								<label for="possibilityName" class="col-sm-4 control-label">Possibility Name</label>

								<div class="col-sm-8">
									<input id="possibilityName" type="text" class="form-control" name="possibilityName" value="{{ $possibility->possibilityName }}" required autofocus>

									@if ($errors->has('possibilityName'))
										<span class="help-block">
											<strong>{{ $errors->first('possibilityName') }}</strong>
										</span>
									@endif
								</div>
							</div>
							
							<div class="col-md-12" align="center">
								<button class="btn btn-success" type="submit">Update</button></br>
							</div>




					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					</div></form>
				{{--<button>Leave</button>--}}
			</div>
		</div>