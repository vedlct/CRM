@extends('main')



@section('content')

    <div class="card" style="padding:30px;">
        <div class="card-body">
        <h2 class="card-title" align="center"><b>Search Keywords on Google</b></h2>
        <p class="card-subtitle" align="center">Try to use long tail with country and city so that you get good leads </p>

        <div class="card-body" >

        <form method="POST" action="{{ route('googleSearch') }}">
            {{ csrf_field() }}
            <div class="col-md-2" style="float:left;">
                <input type="text" class="form-control" name="engineKey" placeholder="Engine Key" value="{{ Session::get('engineKey') }}">
            </div>
            <div class="col-md-2" style="float:left;">
                <input type="text" class="form-control" name="apiKey" placeholder="API Key" value="{{ Session::get('apiKey') }}">
            </div>
            <div class="col-md-6" style="float:right;">
                <input type="text" class="form-control" name="searchTerm" placeholder="Search on Google" style="width:70%; float:left;">

                <div class="input-group-append">
                    <button class="btn btn-primary" type="submit" style="float:right;">Search on Google</button>
                </div>
            </div>

            <div class="col-md-2" style="float: right;">
                        <select class="form-control" name="country">
                            <option value="">Select Country</option>
                            <option value=" Austria">Austria</option>
                            <option value=" Australia">Australia</option>
                            <option value=" Belgium">Belgium</option>
                            <option value=" Bulgaria">Bulgaria</option>
                            <option value=" Denmark">Denmark</option>
                            <option value=" Germany">Germany</option>
                            <option value=" Finland">Finland</option>
                            <option value=" Italy">Italy</option>
                            <option value=" Netherlands">Netherlands</option>
                            <option value=" Spain">Spain</option>
                            <option value=" Sweden">Sweden</option>
                            <option value=" United Kingdom">UK</option>
                        </select>
                    </div>

        </form>

        </div>

        <div class="card" style="padding-top:50px;">
        </div>


        @if (!empty($results))
            <div class="table-responsive m-t-40">
                <div>You have searched for: {{ $searchTerm }} </div><br><br>

                <table id="myTable" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>Link</th>
                            <th>Domain</th>
                            <th>Description</th>
                            <th>Availability</th>
                            <!-- <th>Action</th> -->

                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($results as $result)
                            <tr>
                                <td>{{ $result->title }}</td>
                                <td>{{ $result->link }}</td>
                                <td>{{ $result->domain }}</td>
                                <td>{{ $result->snippet  }}</td>
                                <td>
                                    @if ($result->availability == 'Yes')
                                        <p>This lead is existed</p>
                                    @else
                                        <p>MINE ME</p>
                                    @endif
                                </td>
                                <!-- <td>
                                        <button class="btn btn-success btn-sm add-night-shift-btn" data-title="{{ $result->title }}" data-url="{{ $result->link }}">
                                        <i class="fa fa-plus" aria-hidden="true"></i>
                                        </button>
                                </td> -->


                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <p>No results found.</p>
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
            $('#myTable').DataTable({
                "processing": true,
                stateSave: true,
            });

        });



        //  // Get all the "Add Night Shift" buttons
        //  const addNightShiftBtns = document.querySelectorAll('.add-night-shift-btn');

        // // Add click event listeners to each button
        // addNightShiftBtns.forEach(btn => {
        //     btn.addEventListener('click', () => {
        //     // Get the title and URL data attributes from the button
        //     const title = btn.getAttribute('data-title');
        //     const url = btn.getAttribute('data-url');
        //     // Redirect to the addNightShift page with the title and URL as query parameters
        //     window.location.href = "{{ route('addNightShift') }}?title=" + encodeURIComponent(title) + "&url=" + encodeURIComponent(url);
        // });
        // });



    </script>


@endsection