@extends('main')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Add new notice</div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="POST" action="{{ route('notice.store') }}">
                        {{ csrf_field() }}

                        <div class="form-group row{{ $errors->has('msg') ? ' has-error' : '' }}">
                            <label for="msg" class="col-sm-3 control-label">Notice</label>

                            <div class="col-sm-9">
                                <textarea id="msg" class="form-control form-control-warning" name="msg" style="width:100%; height:200px" required autofocus>{{ old('msg') }}</textarea>
                                @if ($errors->has('msg'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('msg') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row{{ $errors->has('categoryId') ? ' has-error' : '' }}">
                            <label for="categoryId" class="col-sm-3 control-label">Category</label>
							<div class="col-sm-9">

								<select name="categoryId" class="form-control form-control-warning">
                                   @foreach ($categories as $category)
                                        <option value="{{$category->categoryId}}">{{$category->categoryName}}</option>
                                    @endforeach 
								</select>

                                @if ($errors->has('categoryId'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('categoryId') }}</strong>
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




