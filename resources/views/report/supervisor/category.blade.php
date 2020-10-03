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
        {{--<label><b>Search</b></label>
        <form method="post" action="{{route('searchTableByDate')}}">
            {{csrf_field()}}
            <input type="text" placeholder=" From" id="fromdate" name="fromDate" style="border-radius: 50px;" >
            <input type="text" placeholder=" To" id="todate" name="toDate" style="border-radius: 50px;" >
            <button type="submit" class="btn btn-success">Search</button>
        </form>--}}


        {{-- <div class="card-header">
             <label><b>Search</b></label>
             <input type="text" placeholder=" From" id="fromDate" name="fromDate" style="border-radius: 50px;">
             <input type="text" placeholder=" To" id="toDate" name="toDate" style="border-radius: 50px;">
             <a href="" data-toggle="tab" class="btn btn-success" onclick="dateval()">Search</a>
         </div>--}}


        <div class="card-body">
            <h2>Report</h2>
            @if(isset($fromDate) && isset($toDate))
                <p>Report From {{$fromDate}} to {{$toDate}}</p>
            @else
                <p>Category Ways report</p>
            @endif

            @if(Auth::user()->typeId !=4)

                <table class="table table-bordered table-striped ">
                    <thead>
                    <tr>
                        <th>Category</th>
                        <th>Low</th>
                        <th>Medium</th>
                        <th>High</th>
                        <th>Star</th>
                        <th>Total</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach( $categories as $category)
                        @php
                            $total = 0;
                        @endphp
                        <tr>
                            <td>{{$category->categoryName}}</td>
                           {{-- @foreach($leads->where('categoryId', $category->categoryId) as $lead)
                                <td>
                                    @switch($lead->possibilityId)
                                        @case(1)

                                        {{ count($lead) }}
                                        @break

                                        @case(2)
                                        {{ count($lead)}}
                                        @break

                                        @case(3)
                                        {{ count($lead) }}
                                        @break

                                        @case(4)
                                         {{ count($lead) }}
                                        @break

                                        @default
                                        0
                                    @endswitch
                                </td>
--}}{{--                                @php--}}{{--
--}}{{--                                $total += $lead->total--}}{{--
--}}{{--                                @endphp--}}{{--
                            @endforeach--}}
                             @foreach($leads->where('categoryId', $category->categoryId) as $lead)
                                 <td><a href="#" onclick="getHighLead(this)" data-category="{{$lead->categoryId}}">{{$lead->total}}</a></td>
                                 @php
                                     $total += $lead->total;
                                 @endphp
                             @endforeach
                            <td>{{ $total }}</td>
                        </tr>

                    @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>
@endsection
@section('foot-js')
    <script>
        /* $(function () {
             $("#fromdate").datepicker();
             $("#todate").datepicker();
         });*/


        function getHighLead(x) {
            var category = $(x).data('category');
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            $.ajax({
                type: 'POST',
                url: '{{route('getHighLead')}}',
                data: {_token: CSRF_TOKEN, 'category': category},
                cache: false,
                success: function (data) {
                    console.log(data);
                    $('#highPossibility').modal({show: true});
                    $('#label').html('High');
                    $('#txtHint').html(data);
                    @if(Auth::user()->typeId ==10)
                    $('#myTable').DataTable({
                        dom: 'Bfrtip',
                        buttons: [
                            'excel'
                        ]
                    });
                    @else
                    $('#myTable').DataTable();
                    @endif
                }
            });
        }
    </script>


@endsection
