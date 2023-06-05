@extends('main')


@section('content')

    <div class="card" style="padding:30px;">
        <div class="card-body">
        <h2 class="card-title" align="center"><b>Scrap A Website</b></h2>
        <p class="card-subtitle" align="center">Scrap a site to get information </p>

        <div class="card-body" >

        <form method="POST" action="{{ route('crawlWebsites') }}">
            {{ csrf_field() }}
            <div class="col-md-3" style="float:left;">
                <input type="text" class="form-control" name="imageSize" placeholder="Image Size in KB">
            </div>
            <div class="col-md-6" style="float:right;">
                <input type="text" class="form-control" name="website" placeholder="Full Website Link" style="width:70%; float:left;">
                <div class="input-group-append">
                    <button class="btn btn-primary" type="submit" style="float:right;">Search on Google</button>
                </div>
            </div>
        </form>

        </div>

        <div class="card" style="padding-top:50px;">
        </div>


        @if (!empty($submitted))
        <div class="table-responsive m-t-40">
                <div>You have searched for: {{ $website}}</div><br><br>

                <table id="imageTable" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                        <th>Image URL</th>
                        <th>Thumbnail</th>
                        <!-- <th>Image Size (KB)</th> -->
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
            "iDisplayLength": 50,
            data: {!! json_encode($imageData) !!},
            columns: [
                { data: 'url' },
                { data: 'thumbnail' },
                // { data: 'size' }
            ]
        });
    });
</script>

    

@endsection