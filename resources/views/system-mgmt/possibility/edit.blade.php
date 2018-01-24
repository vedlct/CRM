@extends('main')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Update possibility</div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="POST" action="{{ route('possibility.update', ['id' => $possibility->possibilityId]) }}">
                        <input type="hidden" name="_method" value="PATCH">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <div class="form-group{{ $errors->has('possibilityName') ? ' has-error' : '' }}">
                            <label for="possibilityName" class="col-sm-3 control-label">Possibility Name</label>

                            <div class="col-sm-9">
                                <input id="possibilityName" type="text" class="form-control" name="possibilityName" value="{{ $possibility->possibilityName }}" required autofocus>

                                @if ($errors->has('possibilityName'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('possibilityName') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    Update
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
