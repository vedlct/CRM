@extends('main')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Update status</div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="POST" action="{{ route('status.update', ['id' => $status->statusId]) }}">
                        <input type="hidden" name="_method" value="PATCH">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <div class="form-group{{ $errors->has('statusName') ? ' has-error' : '' }}">
                            <label for="statusName" class="col-sm-3 control-label">Status Name</label>

                            <div class="col-sm-9">
                                <input id="statusName" type="text" class="form-control" name="statusName" value="{{ $status->statusName }}" required autofocus>

                                @if ($errors->has('statusName'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('statusName') }}</strong>
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
