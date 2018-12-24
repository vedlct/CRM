@extends('main')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Add new country</div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="POST" action="{{ route('country.store') }}">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('countryName') ? ' has-error' : '' }}">
                            <label for="countryName" class="col-md-4 control-label">Country Name</label>

                            <div class="col-md-6">
                                <input id="countryName" type="text" class="form-control" name="countryName" value="{{ old('countryName') }}" required autofocus>

                                @if ($errors->has('countryName'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('countryName') }}</strong>
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
