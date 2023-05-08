@extends('main')
@section('content')

 
        <div class="card-body">
            <h2>Individual Lead Count</h2>

            @if(Auth::user()->typeId !=4)
                <div class="table-responsive">
                <table class="table table-striped table-bordered valueReport">
                    <thead>
                    <tr>
                        <th>Name</th>
                        <th>Total Leads</th>
                        <th>Assigned Lead</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach( $users as $user)
                        <tr>

                            <td>
                                @php($value=0)
                                @foreach($totalOwnedLeads as $tol)
                                    @if($tol->contactedUserId == $user->userid)
                                        <a href="#" class="highpossibility" onclick="ownedleads(this)"
                                           @if(isset($fromDate) && isset($toDate))
                                           data-date-from="{{$fromDate}}"
                                           data-date-to="{{$toDate}}"
                                           @endif
                                           data-user-id="{{$user->userid}}"
                                           data-user-name="{{$user->userName}}">{{$value=$tol->userOwnedLeads}}</a>
                                        @break
                                    @endif
                                @endforeach
                                @if($value==0)
                                    <a href="#" >0</a>
                                @endif
                            </td>

                            <td>
                                @php($value=0)
                                @foreach($assignedLead as $al)
                                    @if($al->assignTo == $user->userid)
                                        <a href="#" class="highpossibility" onclick="leadassigned(this)"
                                           @if(isset($fromDate) && isset($toDate))
                                           data-date-from="{{$fromDate}}"
                                           data-date-to="{{$toDate}}"
                                           @endif
                                           data-user-id="{{$user->userid}}"
                                           data-user-name="{{$user->userName}}">{{$value=$al->userAssignedLead}}</a>
                                        @break
                                    @endif
                                @endforeach
                                @if($value==0)
                                    <a href="#" >0</a>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                    </tbody>

                </table>
                </div>
            @endif


 
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
        $( function() {
            $(".valueReport").DataTable();
        });


            function ownedleads(x){
            var id = $(x).data('user-id');
                    @if(isset($fromDate) && isset($toDate))
            var from=$(x).data('date-from');
            var to=$(x).data('date-to');
                    @endif
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            var userName=$(x).data('user-name');
            $.ajax({
                type:'POST',
                url:'{{route('getPossessedLeads')}}',
                @if(isset($fromDate) && isset($toDate))
                data:{_token: CSRF_TOKEN,'userid':id,'fromdate':from,'todate':to},
                @else
                data:{_token: CSRF_TOKEN,'userid':id},
                @endif
                cache: false,
                success:function(data) {
//                    console.log(data);
                    $('#highPossibility').modal({show:true});
                    $('#label').html('Possessed Leads');
                    $('#txtHint').html(data);
                    $('#name').html(userName);
                    @if(Auth::user()->typeId ==10)
                    $('#myTable').DataTable({
                        dom:'Bfrtip',
                        buttons:[
                            'excel'
                        ]
                    });
                    @else
                    $('#myTable').DataTable();
                    @endif
                }
            });
        }


       function leadassigned(x){
            var id = $(x).data('user-id');
                    @if(isset($fromDate) && isset($toDate))
            var from=$(x).data('date-from');
            var to=$(x).data('date-to');
                    @endif
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            var userName=$(x).data('user-name');
            $.ajax({
                type:'POST',
                url:'{{route('getAssignedLeadIndividual')}}',
                @if(isset($fromDate) && isset($toDate))
                data:{_token: CSRF_TOKEN,'userid':id,'fromdate':from,'todate':to},
                @else
                data:{_token: CSRF_TOKEN,'userid':id},
                @endif
                cache: false,
                success:function(data) {
//                    console.log(data);
                    $('#highPossibility').modal({show:true});
                    $('#label').html('Lead Assigned');
                    $('#txtHint').html(data);
                    $('#name').html(userName);
                    @if(Auth::user()->typeId ==10)
                    $('#myTable').DataTable({
                        dom:'Bfrtip',
                        buttons:[
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
