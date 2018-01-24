@extends('main')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Add new Usertype</div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="POST" action="{{ route('usertype.store') }}">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('typeName') ? ' has-error' : '' }}">
                            <label for="typeName" class="col-md-4 control-label">Type Name</label>

                            <div class="col-md-6">
                                <input id="typeName" type="text" class="form-control" name="typeName" value="{{ old('typeName') }}" required autofocus>

                                @if ($errors->has('typeName'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('typeName') }}</strong>
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
