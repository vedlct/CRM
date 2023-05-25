@extends('main')



@section('content')

    <div class="card" style="padding:30px;">
        <div class="card-body">
        <h2 class="card-title" align="center"><b>Search Keywords on Google</b></h2>
        <p class="card-subtitle" align="center">You will get a result of Google Search based on your keywords. This query will only get you the website inks.</p>


            <div class="card-body" >
                <div class="col-md-5" style="float:left;">
                <form method="GET" action="{{ route('searchResults') }}">
                {{ csrf_field() }}
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" name="searchTerm" placeholder="Enter search terms using comma">
                        <div class="input-group-append">
                            <button class="btn btn-primary" type="submit">Search and Show in Table</button><br>
                        </div>
                    </div>
                </form>
                </div>

                
            <!-- <div class="card-body" >
                <div class="col-md-5" style="float:right;">
                    <div class="gcse-search">
                    </div>
                </div>
            </div> -->
        </div>



                <!-- <div class="col-md-5" style="float:right;">
                <form method="POST" action="{{ route('exportAnalysisComments') }}">
                {{ csrf_field() }}
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" name="searchTerm" placeholder="Enter search terms using comma">
                        <div class="input-group-append">
                            <button class="btn btn-primary" type="submit">Export Query in an Excel</button><br>
                        </div>
                    </div>
                </form>
                </div> -->
        </div>



        <ul>
            @forelse ($results as $result)
                <li>
                    <a href="{{ $result['link'] }}">{{ $result['title'] }}</a>
                    <p>{{ $result['snippet'] }}</p>
                </li>
            @empty
                <li>No results found.</li>
            @endforelse
        </ul>



        <!-- <div class="card" style="padding-top:50px;">
        </div>


            <div class="table-responsive m-t-40">
                <table id="myTable" class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th width="5%"><input type="checkbox" id="select-all"></th>
                        <th width="20%">Title</th>
                        <th width="20%">Url</th>
                        <th width="60%">Description</th>

                    </tr>
                    </thead>
                    
                    <tbody>

                    @foreach($items as $result)
                        <tr>
                            <td ><input type="checkbox" class="row-checkbox" value="{{$analyze->leadId}}"></td>
                            <td >{{$result->getTitle}}</td>
                            <td><a href="{{ $result->getLink() }}">{{ $result->getLink() }}</a></td>
                            <td >{{$result->getSnippet}}</td>

                        </tr>

                    @endforeach

                    </tbody>
                </table>
            </div> -->

</div>


@endsection

@section('foot-js')

    <script src="{{url('assets/plugins/datatables/jquery.dataTables.min.js')}}"></script>

    <script src="{{url('cdn.datatables.net/buttons/1.2.2/js/dataTables.buttons.min.js')}}"></script>
    <script src="{{url('cdn.datatables.net/buttons/1.2.2/js/buttons.flash.min.js')}}"></script>


    <script src="{{url('cdn.datatables.net/buttons/1.2.2/js/buttons.html5.min.js')}}"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <!-- <script async src="https://cse.google.com/cse.js?cx=e30079461856a46ef"></script> -->

    <script>

        $(document).ready(function() {
            $('#myTable').DataTable({
                "processing": true,
                stateSave: true,
            });

        });


        




    </script>


@endsection