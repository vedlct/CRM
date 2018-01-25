@extends('main')

@section('content')
		  <form method="POST" action="{{ route('follow-up.search') }}">
			 {{ csrf_field() }}
			 @component('layouts.search', ['title' => 'Search'])
			  @component('layouts.two-cols-date-search-row', ['items' => ['From Date', 'To Date'], 
			  'oldVals' => [isset($searchingVals) ? $searchingVals['fromdate'] : '', isset($searchingVals) ? $searchingVals['todate'] : '']])
			  @endcomponent
			@endcomponent
		  </form>
  <div class="box-body">
    <div class="card" style="padding: 2px;">
        <div class="card-body">
          <div style="font-size:24px; font-weidgh:bold; padding:0px; margin-left:auto; margin-right:auto;">List of Todays Follow-up</div>
            <div class="table-responsive m-t-40" >
            <table id="myTable" class="table table-striped table-condensed" style="font-size:14px;">
            <thead>
              <tr>
                <th>GM</th>
                <th>Company Name</th>
                <th>Category</th>
                <th>Country</th>
                <th>Contact Person</th>
                <th>Web Address</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
            @foreach ($followups as $followup)
                <tr>
					<td>{{ $followup->userId }}</td>
					<td>{{ $followup->companyName }}</td>
					<td>{{ $followup->categoryName }}</td>
					<td>{{ $followup->countryName}}</td>
					<td>{{ $followup->personName }}</td>
					<td>{{ $followup->website }}</td>

					{{--<td><a href="{{route('report',['id'=>$followup->leadId])}}" class="btn btn-info btn-sm"><i class="fa fa-phone" aria-hidden="true"></i></a></td>--}}
					<td>
						<!-- Trigger the modal with a button -->
						<a href="#my_modal" data-toggle="modal" class="btn btn-success btn-sm"
						   data-lead-id="{{$followup->leadId}}"
						   data-lead-possibility="{{$followup->possibilityId}}">
						<i class="fa fa-phone" aria-hidden="true"></i></a>

						<!-- Trigger the Edit modal with a button -->
						<a href="#edit_modal" data-toggle="modal" class="btn btn-info btn-sm"
						   data-lead-id="{{$followup->leadId}}"
						   data-lead-name="{{$followup->companyName}}"
						   data-lead-email="{{$followup->email}}"
						   data-lead-number="{{$followup->contactNumber}}"
						   data-lead-person="{{$followup->personName}}"
						   data-lead-website="{{$followup->website}}">
							<i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>

				</td>
			</tr>
            @endforeach
            </tbody>
          </table>
        </div>
      </div>
	  </div>

		@section('foot-js')
			<script src="{{asset('assets/plugins/datatables/jquery.dataTables.min.js')}}"></script>
			<script src="{{asset('cdn.datatables.net/buttons/1.2.2/js/dataTables.buttons.min.js')}}"></script>
			<script src="{{asset('cdn.datatables.net/buttons/1.2.2/js/buttons.flash.min.js')}}"></script>
			<script src="{{asset('cdn.datatables.net/buttons/1.2.2/js/buttons.html5.min.js')}}"></script>

			<script>
				$(document).ready(function() {
					$('#myTable').DataTable();

				});
				
				
        $( function() {
            $( "#fromdate" ).datepicker();
            $( "#todate" ).datepicker();
        } );
			</script>


		@endsection
    </div>
  </div>
  <!-- /.box-body -->
</div>
@endsection








































@section('foot-js')

    <script>

        $( function() {
            $( "#fromdate" ).datepicker();
            $( "#todate" ).datepicker();
        } );
    </script>
@endsection