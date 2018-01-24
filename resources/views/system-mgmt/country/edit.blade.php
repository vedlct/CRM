@extends('main')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Update country</div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="POST" action="{{ route('country.update', ['id' => $country->countryId]) }}">
                        <input type="hidden" name="_method" value="PATCH">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <div class="form-group{{ $errors->has('countryName') ? ' has-error' : '' }}">
                            <label for="countryName" class="col-md-4 control-label">Country Name</label>

                            <div class="col-md-6">
                                <input id="countryName" type="text" class="form-control" name="countryName" value="{{ $country->countryName }}" required autofocus>

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
