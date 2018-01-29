@extends('main')

@section('content')
  <div class="box-body">

    <div class="card" style="padding: 2px; max-width:50%; ">

        <div class="card-body">
			<h2 style="display: inline-block; margin: 0px 50px;">List of category</h2>
			<a href="#create_modal" data-toggle="modal" class="btn btn-info btn-sm"><i class="glyphicon glyphicon-plus"></i>Add Category</i></a>
			
			
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
							

							<!-- Trigger the Edit modal with a button -->
							<a href="#edit_modal" data-toggle="modal" class="btn btn-info btn-sm"
							   data-category-id="{{$category->categoryId}}"
							   data-category-name="{{$category->categoryName}}"
							   data-category-type="{{$category->type}}"">
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
	  
	  
	  
	  
			  
			  
		<!--Create Category-->
		<div class="modal" id="create_modal" style="">
			<div class="modal-dialog" style="max-width: 40%;">
		  
				<form class="modal-content" method="post" action="{{ route('category.store') }}">
				
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
						<h4 class="modal-title" name="modal-title">Create Category</h4>
					</div>
				
						{{ csrf_field() }}

					<div class="col-md-12">
						<div class="form-group row{{ $errors->has('categoryName') ? ' has-error' : '' }}">
							<label for="categoryName" class="col-sm-4 control-label">Category Name</label>

							<div class="col-sm-8">
								<input id="categoryName" type="text" class="form-control" name="categoryName" value="{{ old('categoryName') }}" required autofocus>

								@if ($errors->has('categoryName'))
									<span class="help-block">
										<strong>{{ $errors->first('categoryName') }}</strong>
									</span>
								@endif
							</div>
						</div>

						<div class="form-group row{{ $errors->has('type') ? ' has-error' : '' }}">
							<label for="type" class="col-sm-4 control-label">Type</label>
							<div class="col-sm-8">

								<select name="type" class="form-control form-control-warning">
									<option value="1">Lead</option>
									<option value="2">Notice</option>
								</select>

								@if ($errors->has('type'))
									<span class="help-block">
										<strong>{{ $errors->first('type') }}</strong>
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
			  
			  
			  
			  
			  
			  
			  
			  
			  
			  
			  
			  
			  
			  
			  
			  
			  
			  
			  
			  
			  
			  <!--edit category-->
		<div class="modal" id="edit_modal" style="">
			<div class="modal-dialog" style="max-width: 40%;">
					
				<form class="modal-content" method="post" action="{{ route('category.update', ['id' => 1])}}">
					<input type="hidden" name="_method" value="PUT">
						{{csrf_field()}} 
					<input id="categoryId" type="hidden" class="form-control" name="categoryId"  required autofocus>
						  
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
						<h4 class="modal-title" name="modal-title">Update Category</h4>
					</div>
					

							<div class="col-md-12">
							<div class="form-group row{{ $errors->has('categoryName') ? ' has-error' : '' }}">
								<label for="categoryName" class="col-sm-4 control-label">Category Name</label>

								<div class="col-sm-8">
									<input id="categoryName" type="text" class="form-control" name="categoryName" value="{{ $category->categoryName }}" required autofocus>

									@if ($errors->has('categoryName'))
										<span class="help-block">
											<strong>{{ $errors->first('categoryName') }}</strong>
										</span>
									@endif
								</div>
							</div>

							<div class="form-group row{{ $errors->has('type') ? ' has-error' : '' }}">
								<label for="type" class="col-sm-4 control-label">Type</label>
								<div class="col-sm-8">

									<select name="type" class="form-control form-control-warning">
										<option value="1">Lead</option>
										<option value="2">Notice</option>
									</select>

									@if ($errors->has('type'))
										<span class="help-block">
											<strong>{{ $errors->first('type') }}</strong>
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
			var categoryId = $(e.relatedTarget).data('category-id');
			var categoryName = $(e.relatedTarget).data('category-name');
			var type = $(e.relatedTarget).data('category-type');
			
			//populate the textbox
			$(e.currentTarget).find('input[name="categoryId"]').val(categoryId);
			$(e.currentTarget).find('input[name="categoryName"]').val(categoryName);
			$(e.currentTarget).find('input[name="type"]').val(type);

		});
				
		//for Edit modal

		$('#edit_modal').on('show.bs.modal', function(e) {

			//get data-id attribute of the clicked element
			var categoryId = $(e.relatedTarget).data('category-id');
			var categoryName = $(e.relatedTarget).data('category-name');
			var type = $(e.relatedTarget).data('category-type');
			
			//populate the textbox
			$(e.currentTarget).find('input[name="categoryId"]').val(categoryId);
			$(e.currentTarget).find('input[name="categoryName"]').val(categoryName);
			$(e.currentTarget).find('input[name="type"]').val(type);

		});
	</script>
@endsection