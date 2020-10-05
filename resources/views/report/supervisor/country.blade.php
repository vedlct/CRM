@extends('main')
@section('content')
    <!--High Possibility Modal -->
    <div class="modal fade" id="highPossibility" role="dialog">
        <div class="modal-dialog" style="max-width: 80%">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title"><label id="label"></label></h4>
                </div>
                <div class="modal-body">
                    <div id="name" style="text-align: center; font-weight:bold;"></div>
                    <div id="txtHint">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <div class="card" style="padding:10px;">

        <div class="card-body">
            <h2>Report</h2>

            <p>Country report</p>

            <table id="countryReport" class="table table-bordered table-striped ">
                <thead>
                <tr>
                    <th>Country</th>
                    @foreach($possibilities as $possibility)
                        <th>{{ $possibility->possibilityName }}</th>
                    @endforeach
                    <th>Total</th>
                </tr>
                </thead>
                <tbody>
                @foreach( $countries as $country)
                    @php
                        $total = 0;
                    @endphp
                    <tr>
                        <td>{{$country->countryName}}</td>
                        @foreach($possibilities as $possibility)
                            <td><a href="#" onclick="getHighLead(this)" data-country-id="{{$country->countryId}}"
                                   data-possibility-id="{{$possibility->possibilityId}}">
                                    @foreach($leads->where('countryId', $country->countryId)->where('possibilityId', $possibility->possibilityId) as $lead)
                                        {{ $lead->total }}
                                        @php
                                            $total += $lead->total;
                                        @endphp
                                    @endforeach
                                </a></td>
                        @endforeach
                        <td>{{ $total }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
@section('foot-js')
    <meta name="csrf-token" content="{{ csrf_token() }}"/>
    <script src="{{url('assets/plugins/datatables/jquery.dataTables.min.js')}}"></script>
    <script src="https://cdn.datatables.net/buttons/1.5.6/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.flash.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.html5.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.print.min.js"></script>

    <script>
        $(function () {
            $("#fromdate").datepicker();
            $("#todate").datepicker();
            $('#countryReport').DataTable();
        });


        function getHighLead(x) {
            var catid = $(x).data('country-id');
            var posid = $(x).data('possibility-id');

            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            $.ajax({
                type: 'POST',
                url: '{{route('getCountryLead')}}',
                data: {_token: CSRF_TOKEN, 'countryid': catid, 'possibilityid': posid},
                cache: false,
                success: function (data) {
                    // console.log(data);
                    $('#highPossibility').modal({show: true});
                    $('#label').html('High Possibility');
                    $('#txtHint').html(data);
                    $('#myTable').DataTable();

                }
            });
        }
    </script>


@endsection
