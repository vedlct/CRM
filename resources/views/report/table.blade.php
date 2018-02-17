@extends('main')



@section('content')



    <!--High Possibility Modal -->
    <div class="modal fade" id="highPossibility" role="dialog">
        <div class="modal-dialog" style="max-width: 50%">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">High Possibility</h4>
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
            <form method="post" action="{{route('searchTableByDate')}}">
                {{csrf_field()}}
                <input type="text" placeholder="From" id="fromdate" name="fromDate">
                <input type="text" placeholder="To" id="todate" name="toDate">
                <button type="submit" class="btn btn-success">Search</button>

            </form>
            <div class="card-body">
        <h2>Report</h2>
         @if(isset($fromDate) && isset($toDate))
                    <p>Report From {{$fromDate}} to {{$toDate}}</p>
                @else
        <p>Weekly report</p>
         @endif
        <table class="table">
            <thead>
            <tr>
                <th>Name</th>
                <th>Total Call</th>
                <th>Contacted</th>
                <th>Assigned Lead</th>
                <th>High Possibility</th>
                <th>Test Lead</th>
                <th>Closing Lead</th>
                <th>Lead Mined</th>
            </tr>
            </thead>
            <tbody>
            @foreach($report as $r)
            <tr>
                <td>{{$r->userName}}</td>
                <td>{{$r->called}}</td>
                <td>{{$r->contacted}}</td>
                <td>{{$r->assignedLead}}</td>
                <td><a href="#" class="highpossibility" onclick="highpossibility(this)"
                            @if(isset($fromDate) && isset($toDate))
                            data-date-from="{{$fromDate}}"
                            data-date-to="{{$toDate}}"
                            @endif
                            data-user-id="{{$r->id}}"
                            data-user-name="{{$r->userName}}"


                    >
                        {{$r->highPosibilities}}
                    </a>
                </td>
                <td>{{$r->test}}</td>
                <td>{{$r->closing}}</td>
                <td>{{$r->leadMined}}</td>
            </tr>
                @endforeach
            </tbody>
        </table>
            </div></div>

@endsection

@section('foot-js')
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <script>
        $( function() {
            $( "#fromdate" ).datepicker();
            $( "#todate" ).datepicker();
        } );


        {{--$('.highpossibility').on('click',function(e){--}}
            {{--var userId=$(e.relatedTarget).data('user-id');--}}
            {{--alert(userId);--}}
            {{--$('.modal-body').load('{{route("insertTeam")}}',function(){--}}
                {{--$('#highPossibility').modal({show:true});--}}
            {{--});--}}
        {{--});--}}

        function highpossibility(x){

           var id = $(x).data('user-id');

                    @if(isset($fromDate) && isset($toDate))
            var from=$(x).data('date-from');
            var to=$(x).data('date-to');
                    @endif
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            var userName=$(x).data('user-name');

            $.ajax({
                type:'POST',
                url:'{{route('getHighPossibilityIndividual')}}',
                @if(isset($fromDate) && isset($toDate))
                data:{_token: CSRF_TOKEN,'userid':id,'fromdate':from,'todate':to},
                @else
                data:{_token: CSRF_TOKEN,'userid':id},
                @endif
                cache: false,
                success:function(data) {

                    console.log(data);
                    $('#highPossibility').modal({show:true});
                    $('#txtHint').html(data);
                    $('#name').html(userName);


                }
            });
//            modal.style.display = "block";

        }

    </script>




    @endsection