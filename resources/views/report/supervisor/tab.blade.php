@extends('main')
@section('content')
    <style>
        @media only screen and (max-width: 1024px) {
            #info {
                margin-top: 10%;
            }
        }
    </style>
    <div class="card" id="info">
        <div class="card-body">

        <div id="exTab2">
            <ul class="nav nav-tabs">
              <li class="nav-item">
                <a  class="nav-link" href="#category" id="firstClick" data-toggle="tab" onclick="category()">Category</a>
              </li>
              <li class="nav-item">
                <a href="#country" class="nav-link" data-toggle="tab" onclick="country()">Country</a>
              </li>
              <li class="nav-item">
                <a href="#status" class="nav-link" data-toggle="tab" onclick="status()">Status</a>
              </li>
            </ul>


            <div class="tab-content">

                <div class="tab-pane active" id="result">
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('foot-js')
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <script src="{{url('assets/plugins/datatables/jquery.dataTables.min.js')}}"></script>

    <script src="https://cdn.datatables.net/buttons/1.5.6/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.flash.min.js"></script>


    <script src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.html5.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.print.min.js"></script>



<script>
    $('#firstClick').click();
    function category() {
        $.ajax({
            type: 'POST',
            url: "{!! route('reportTabCategory') !!}",
            cache: false,
            data: {_token:"{{csrf_token()}}"},
            success: function (data) {
                $('#result').html(data);
            }

        });

    }

    function country() {
        $.ajax({
            type: 'POST',
            url: "{!! route('reportTabCountry') !!}",
            cache: false,
            data: {_token:"{{csrf_token()}}"},
            success: function (data) {
                $('#result').html(data);
            }

        });

    }

    function status() {
        $.ajax({
            type: 'POST',
            url: "{!! route('reportTabStatus') !!}",
            cache: false,
            data: {_token:"{{csrf_token()}}"},
            success: function (data) {
                $('#result').html(data);
            }

        });

    }

    function dateval(){

        var from=$("#fromDate").on("change").val();
        var to=$("#toDate").on("change").val();
        $.ajax({
            type: 'POST',
            url: "{!! route('searchTableByDate') !!}",
            cache: false,
            // data:{_token: CSRF_TOKEN, 'fromDate':from,'toDate':to},
            data:{_token:"{{csrf_token()}}", fromDate: from, toDate: to},
            success: function (data){
                $('#result').html(data);
            }
        });
    }

    function graphy() {
        $.ajax({
            type: 'POST',
            url: "{!! route('reportGraph') !!}",
            cache: false,
            data: {_token:"{{csrf_token()}}"},
            success: function (data) {
                $('#result').html(data);
            }

        });

    }

    function dategraph(){

        var from=$("#fromDate").on("change").val();
        var to=$("#toDate").on("change").val();
        $.ajax({
            type: 'POST',
            url: "{!! route('searchGraphByDate') !!}",
            cache: false,
            // data:{_token: CSRF_TOKEN, 'fromDate':from,'toDate':to},
            data:{_token:"{{csrf_token()}}", fromDate: from, toDate: to},
            success: function (data){
                $('#result').html(data);
            }
        });
    }
</script>


@endsection
