@extends('main')

@section('content')

    <div class="card" style="padding:30px;">
        <div class="card-body">
            <h2 class="card-title" align="center"><b>Crawl A Website</b></h2>
            <p class="card-subtitle" align="center">Crawl a site to get information. Every request will take 60 or less seconds to perform.  </p>

            <div class="card-body">
                <form method="POST" action="{{ route('crawlWebsites') }}">
                    {{ csrf_field() }}
                    <div class="col-md-8" style="float:left;">
                        <input class="form-control" name="domain" placeholder="Enter multiple URLs, one URL per line" style="width:80%; float:left;"></textarea>
                        <div class="input-group-append">
                            <button class="btn btn-primary" type="submit" style="float:right;">Crawl URLs</button>
                        </div>
                    </div>
                </form>
            </div>

            <div class="card" style="padding-top:50px;">
            </div>

            @if (!empty($domain))
                <div class="col-md-12">
                     <h3>Total number of images for the domain {{ $domain }} :: </h3><h1>{{ $totalImages }}</h1>
                </div>
            @endif

            @if (!empty($errors))
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors as $error)
                            <li>{!! $error !!}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </div>
    </div>
@endsection

@section('foot-js')
    <meta name="csrf-token" content="{{ csrf_token() }}" />
@endsection
