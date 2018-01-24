@extends('main')

@section('content')
    <section class="content">
      <div class="box">
          <h3 class="box-title">List of Todays Follow-up</h3>
  <!-- /.box-header -->
  <div class="box-body">
      <form method="POST" action="{{ route('follow-up.search') }}">
         {{ csrf_field() }}
         @component('layouts.search', ['title' => 'Search'])
          @component('layouts.two-cols-date-search-row', ['items' => ['From Date', 'To Date'], 
          'oldVals' => [isset($searchingVals) ? $searchingVals['fromdate'] : '', isset($searchingVals) ? $searchingVals['todate'] : '']])
          @endcomponent
        @endcomponent
      </form>
		
  <!-- /.box-header -->
  <div class="box-body">
    <div class="card" style="padding: 2px;">
        <div class="card-body">
            <div class="table-responsive m-t-40" >
            <table id="myTable" class="table table-striped table-condensed" style="font-size:14px;">
            <thead>
              <tr role="row">
                <th width="" class="sorting_asc" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Name: activate to sort column descending" aria-sort="ascending">GM</th>
                <th width="" class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Email: activate to sort column ascending">Company Name</th>
                <th width="" class="sorting hidden-xs" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Email: activate to sort column ascending">Category</th>
                <th width="" class="sorting hidden-xs" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Email: activate to sort column ascending">Country</th>
                <th width="" class="sorting hidden-xs" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Email: activate to sort column ascending">Contact Person</th>
                <th width="" class="sorting hidden-xs" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Email: activate to sort column ascending">Web Address</th>
                <th tabindex="0" aria-controls="example2" rowspan="1" colspan="2" aria-label="Action: activate to sort column ascending">Action</th>
              </tr>
            </thead>
            <tbody>
            @foreach ($followups as $followup)
                <tr role="row" class="odd">
                  <td class="sorting_1">{{ $followup->userId }}</td>
                  <td class="sorting_1">{{ $followup->companyName }}</td>
                  <td class="sorting_1">{{ $followup->categoryName }}</td>
                  <td class="sorting_1">{{ $followup->countryName}}</td>
                  <td class="sorting_1">{{ $followup->personName }}</td>
                  <td class="sorting_1">{{ $followup->website }}</td>
                  <td> <form method="post" action="{{ URL::to('follow-up/' . $followup->followId) }}" onsubmit="return confirm('Do you really want to Delete?');">
							{{csrf_field()}}
							{{ method_field('DELETE') }}

							<button type="submit" class="btn btn-danger btn-sm">
								<i class="fa fa-trash"></i>
							</button>
						</form>
                  </td>
              </tr>
            @endforeach
            </tbody>
          </table>
        </div>
      </div>
      <div class="row">
        <div class="col-sm-5">
          <div class="dataTables_info" id="example2_info" role="status" aria-live="polite">Showing 1 to {{count($followups)}} of {{count($followups)}} entries</div>
        </div>
        <div class="col-sm-7">
          <div class="dataTables_paginate paging_simple_numbers" id="example2_paginate">
            {{ $followups->links() }}
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- /.box-body -->
</div>
    </section>
    <!-- /.content -->
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