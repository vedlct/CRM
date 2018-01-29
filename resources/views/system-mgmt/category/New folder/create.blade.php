@extends('main')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Add new category</div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="POST" action="{{ route('category.store') }}">
                        {{ csrf_field() }}

                        <div class="form-group row{{ $errors->has('categoryName') ? ' has-error' : '' }}">
                            <label for="categoryName" class="col-sm-3 control-label">Category Name</label>

                            <div class="col-sm-9">
                                <input id="categoryName" type="text" class="form-control" name="categoryName" value="{{ old('categoryName') }}" required autofocus>

                                @if ($errors->has('categoryName'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('categoryName') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row{{ $errors->has('type') ? ' has-error' : '' }}">
                            <label for="type" class="col-sm-3 control-label">Type</label>
							<div class="col-sm-9">

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
                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    Create
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
