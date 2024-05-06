@extends('main')


@section('content')


    <div class="card" style="padding:10px;">
        <div class="card-body">
        <h2 align="center"><b>Free Trial Details</b></h2>
        <p class="card-subtitle" align="center">Received but not closed yet. Update rating, price, comments. Rating: 5 means star, 1 means very low</p>
            <div class="row mt-5">
            <div class="col-md-2 form-group">
                <label for="marketer">Test With</label>
                <select id="marketer" name="marketer" class="form-control select2">
                    <option value="">Select Marketer</option>
                    @foreach( $marketers as $marketer )
                        <option value="{{ $marketer->id }}">{{ @$marketer->firstName .' '. @$marketer->lastName }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2 form-group">
                    <label for="marketer">Lead Status</label>
                    <select id="leadstatus" name="leadstatus" class="form-control">
                        <option value="">Select Lead Status</option>
                        @foreach( $leadstatus as $leadstatus )
                            <option value="{{ $leadstatus->statusId }}">{{ @$leadstatus->statusName }}</option>
                        @endforeach
                    </select>
            </div>
            <div class="col-md-2 form-group">
                    <label for="dateFrom">Date From</label>
                    <input type="date" class="form-control" id="dateFrom" name="dateFrom">
            </div>
            <div class="col-md-2 form-group">
                    <label for="dateTo">Date From</label>
                    <input type="date" class="form-control" id="dateTo" name="dateTo">
            </div>
            <div class="col-md-1 form-group align-self-end">
                <button class="btn btn-success" onclick="filterRevenue()">Submit</button>
            </div>
            </div>
            <div class="table-responsive m-t-40">
                <table id="myTable" class="table table-bordered table-striped" style="text-align: center;">
                    <thead>
                    <tr>
                        <th width="8%">Lead Id</th>
                        <th width="10%">Company </th>
                        <th width="12%">Website</th>
                        <th width="8%">Test With</th>
                        <th width="10%">Volume</th>
                        <th width="10%">Test Price</th>
                        <th width="15%">Test/Price Comment</th>
                        <th width="8%">Rating</th>
                        <th width="10%">Price Date</th>
                        <th width="3%">View</th>
                        <th width="3%">Update</th>
                        <th width="3%">Rating</th>
                        <th width="2%">Del</th>

                    </tr>
                    </thead>
                    <tbody>


                    </tbody>
                </table>
            </div>
        </div>
    </div>



   <!-- Update Trial -->
   <div class="modal" id="update_trial" style="width: 60%;">
    <div class="modal-dialog" style="max-width: 60%;">
           <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" name="modal-title">Update Price </h4>
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                </div>
                <div class="modal-body">
                    <form  method="post" action="{{route('updateTrial')}}">
                        {{csrf_field()}}
                        <div class="row">

                            <div class="col-md-3">
                                <input type="hidden" name="trialId">
                                <label><b>Price</b></label>
                                <input type="text" class="form-control" name="trialPrice" value="">
                            </div>

                            <div class="col-md-3">
                                <label ><b>Currency</b></label>
                                <select class="form-control" name="currency"  id="currency">
                                    <option value="€">Euro</option>
                                    <option value="$">USD</option>
                                    <option value="£">GPB</option>
                                </select>
                            </div>
                        <br>
                        <br>
                            <div class="col-md-12">
                                <label><b>Comment about price</b></label>
                                <textarea class="form-control" id="trialComment" name="trialComment"></textarea>
                            </div>
                            <br>
                            
                            <div class="col-md-6">
                                <button class="btn btn-success" type="submit">Update</button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <div class="mineIdDate" id="mineIdDate" align="left"></div> &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>





   <!-- Update Rating -->
   <div class="modal" id="update_rating" style="width: 70%;">
    <div class="modal-dialog" style="max-width: 70%;">
           <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" name="modal-title">Update Rating </h4>
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                </div>
                <div class="modal-body">
                    <form  method="post" action="{{route('updateRating')}}">
                        {{csrf_field()}}
                        <div class="row">

                            <div class="col-md-5">
                                <input type="hidden" name="trialId">
                                <label ><b>Rating</b></label>
                                <select class="form-control" name="trialRating"  id="trialRating">
                                    <option value="5">Star Lead</option>
                                    <option value="4">Very Good Lead</option>
                                    <option value="3">Good</option>
                                    <option value="2">Okay</option>
                                    <option value="1">Bad</option>
                                </select>
                            </div>

                            <div class="col-md-7">
                                <label ><b>Brief</b></label>
                                <p> 5 - Star Lead. Very good company and we are very good at this type of work. Must close it </p>
                                <p> 4 - Very Good Lead. Keep following up. Must close it</p>
                                <p> 3 - Good One. Mid range lead. Try to close it </p>
                                <p> 2 - Okay. Small lead but we should close it </p>
                                <p> 1 - Bad or Very low. Do not necessarily chase it </p>
                            </div>
                            
                            <div class="col-md-6">
                                <button class="btn btn-success" type="submit">Update</button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <div class="mineIdDate" id="mineIdDate" align="left"></div> &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>




@endsection

@section('foot-js')

    <script src="{{url('assets/plugins/datatables/jquery.dataTables.min.js')}}"></script>

    <script src="{{url('cdn.datatables.net/buttons/1.2.2/js/dataTables.buttons.min.js')}}"></script>
    <script src="{{url('cdn.datatables.net/buttons/1.2.2/js/buttons.flash.min.js')}}"></script>


    <script src="{{url('cdn.datatables.net/buttons/1.2.2/js/buttons.html5.min.js')}}"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <style>
        .select2-container .select2-selection--single {
            height: 39px;
        }
        .select2-container--default .select2-selection--single .select2-selection__rendered {
            line-height: 38px;
        }
        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 37px;
        }

        .btn-blue {
            background: deepskyblue;
            border: 1px solid deepskyblue;
        }
    </style>


    <script>

            $(document).ready(function() {
                $('.select2').select2()

                table =   $('#myTable').DataTable({
                    processing: true,
                    serverSide: true,
                    stateSave: true,
                    searching: true,
                    "columnDefs": [
                        { "searchable": false, "targets": [5,6,7,8] }
                    ],
                    ajax: {
                        url: "{!! route('getTestButNotClosedList') !!}",
                        type: "POST",
                        data: function (d) {
                            d._token = "{{ csrf_token() }}";
                            d.marketer = $('#marketer').val();
                            d.dateFrom = $('#dateFrom').val();
                            d.dateTo = $('#dateTo').val();
                            d.leadstatus = $('#leadstatus').val();
                        },
                    },
                    columns: [
                        { data: 'leadId', name: 'leads.leadId' },
                        { data: 'companyName', name: 'leads.companyName' },
                        { data: 'website', name: 'leads.website' },
                        { data: 'firstName', name: 'users.firstName' },
                        { data: 'volume', name: 'leads.volume' },
                        {
                            data: null,
                            name: 'trialPriceAndCurrency',
                            render: function(data, type, full, meta) {
                                return full.currency + ' ' + full.trialPrice;
                            }
                        },
                        { data: 'trialComment', name: 'trialComment', orderable: false, searchable: false },
                        {
                            data: 'trialRating',
                            name: 'trialinfo.trialRating',
                            render: function(data, type, full, meta) {
                                let ratingText = '';
                                let stars = '';

                                switch (data) {
                                    case '1':
                                        ratingText = 'Bad';
                                        stars = '★☆☆☆☆'; // One star
                                        break;
                                    case '2':
                                        ratingText = 'Okay';
                                        stars = '★★☆☆☆'; // Two stars
                                        break;
                                    case '3':
                                        ratingText = 'Good';
                                        stars = '★★★☆☆'; // Three stars
                                        break;
                                    case '4':
                                        ratingText = 'Very Good';
                                        stars = '★★★★☆'; // Four stars
                                        break;
                                    case '5':
                                        ratingText = 'Star Lead';
                                        stars = '★★★★★'; // Five stars
                                        break;
                                    default:
                                        ratingText = '';
                                        stars = '';
                                        break;
                                }

                                return ratingText + ' (' + stars + ')';
                            }
                        },
                        
                        { data: 'price_created_at', name: 'price_created_at', orderable: true, searchable: false },
                        { data: 'leadView', name: 'leadView', orderable: false, searchable: false },
                        { data: 'updatePrice', name: 'updatePrice', orderable: false, searchable: false },
                        { data: 'setRating', name: 'setRating', orderable: false, searchable: false },
                        { data: 'trialRemove', name: 'trialRemove', orderable: false, searchable: false }
                    ]
             });
         });

            function filterRevenue() {
                table.ajax.reload()
            }


            $(document).on('click', '.lead-view-btn', function(e) {
                e.preventDefault();

                var leadId = $(this).data('lead-id');
                var newWindowUrl = '{{ url('/account') }}/' + leadId;

                window.open(newWindowUrl, '_blank');
            });



        $('#update_trial').on('show.bs.modal', function(e) {
            var trialId = $(e.relatedTarget).data('trial-id');
            var trialPrice = $(e.relatedTarget).data('trial-price');
            var currency = $(e.relatedTarget).data('currency');
            var trialComment=$(e.relatedTarget).data('trial-comment');

            $(e.currentTarget).find('input[name="trialId"]').val(trialId);
            $(e.currentTarget).find('input[name="trialPrice"]').val(trialPrice);
            $(e.currentTarget).find('select[name="currency"]').val(currency); 
            $('#trialComment').val(trialComment);

        });


        $('#update_rating').on('show.bs.modal', function(e) {
            var trialId = $(e.relatedTarget).data('trial-id');
            var trialRating = $(e.relatedTarget).data('trial-rating'); 

            $(e.currentTarget).find('input[name="trialId"]').val(trialId);
            $(e.currentTarget).find('select[name="trialRating"]').val(trialRating); 
        });



        $(document).on('click', '.remove-trial-btn', function() {
            var trialId = $(this).data('trial-id');
            var confirmation = confirm('Are you sure you want to remove this Trial?');

            if (confirmation) {
                $.ajax({
                    url: "{{ url('removeTrial') }}/" + trialId, // Corrected URL construction
                    type: "POST", 
                    data: {
                        _method: 'DELETE', // Send as DELETE request
                        _token: $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        console.log(response);
                        location.reload();
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText);
                    }
                });
            }
        });




</script>


@endsection