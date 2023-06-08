@extends('main')


@section('content')

    <div class="card" style="padding:30px;">
        <div class="card-body">
        <h2 class="card-title" align="center"><b>Crawl A Website</b></h2>
        <p class="card-subtitle" align="center">Crawl a site to get information </p>

        <div class="card-body" >

        <form method="POST" action="{{ route('crawlWebsites') }}">
            {{ csrf_field() }}
            <div class="col-md-8" style="float:left;">
                <textarea class="form-control" name="websites" placeholder="Enter multiple URLs, one URL per line" style="width:80%; float:left;"></textarea>
                <div class="input-group-append">
                    <button class="btn btn-primary" type="submit" style="float:right;">Crawl URLs</button>
                </div>
            </div>
            <div class="col-md-2" style="float:right;">
                <label>Image Size (KB): </label>
                <input type="text" class="form-control" name="imageSize" value="100" disabled>
            </div>
        </form>

        </div>

        <div class="card" style="padding-top:50px;">
        </div>


        @if (!empty($submitted))
            <div class="table-responsive m-t-40">
                <div>You have searched for:</div>
                <ul>
                    @foreach($websitesArray as $website)
                        <li>{{ $website }}</li>
                    @endforeach
                </ul>
                <br>

                <table id="imageTable" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Image URL</th>
                            <th>Thumbnail</th>
                        </tr>
                    </thead>
                </table>
            </div>
        @endif



@endsection

@section('foot-js')

    <script src="{{url('assets/plugins/datatables/jquery.dataTables.min.js')}}"></script>

    <script src="{{url('cdn.datatables.net/buttons/1.2.2/js/dataTables.buttons.min.js')}}"></script>
    <script src="{{url('cdn.datatables.net/buttons/1.2.2/js/buttons.flash.min.js')}}"></script>


    <script src="{{url('cdn.datatables.net/buttons/1.2.2/js/buttons.html5.min.js')}}"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}" />


<script>
            $(document).ready(function() {
                $('#imageTable').DataTable({
                    "processing": true,
                    stateSave: true,
                    data: {!! json_encode($imageData) !!},
                    columns: [
                        { data: 'url' },
                        { data: 'thumbnail' },
                    ]
                });
            });

</script>

    

@endsection