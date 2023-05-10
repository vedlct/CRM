@extends('main')
@section('content')

<style>
   .pagination > li > a, .pagination > li > span {
    font-size: 20px;
    padding: 20px;
    }
</style>


<div class="card" style="padding:10px;">
        <div class="card-body">
        <h2>All Activities</h2>
        <p>50 results per page</p>
             
                <table id="myTable" class="table table-bordered mb-5">
                    <thead>
                    <tr>
                        <th width="5%">Activity Id</th>
                        <th width="10%">Name</th>
                        <th width="15%">Company Name</th>
                        <th width="10%">Lead Status</th>
                        <th width="40%">Activities</th>
                        <th width="20%">Date</th>
                    </tr>
                    </thead>
                    <tbody>

                    @foreach($activities as $activity)
                        <tr>
                            <td width="5%">{{$activity->activityId}}</td>
                            <td width="10%">{{$activity->userId}}</td>
                            <td width="15%">{{$activity->companyName}}</td>
                            <td width="10%">{{$activity->statusName}}</td>
                            <td width="40%">{{$activity->activity}}</td>
                            <td width="20%">{{ Carbon\Carbon::parse($activity->created_at)->format('d M Y, H:i') }}</td>
                            
                        </tr>

                    @endforeach

                    </tbody>
                </table>
               {{-- Pagination --}}
                <div class="d-flex justify-content-center">
                {!! $activities->appends(['sort' => 'activityId'])->links() !!}
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

</script>


@endsection
