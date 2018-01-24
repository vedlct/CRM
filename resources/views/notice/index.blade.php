@extends('main')

@section('content')
    <!-- Main content -->
    <section class="content">
      <div class="box">
  <div class="box-header">
    <div class="row">
        <div class="col-sm-8">
          <h3 class="box-title">List of notices</h3>
        </div>
        <div class="col-sm-4">
          <a class="btn btn-primary" href="{{ route('notice.create') }}">Add new notice</a>
        </div>
    </div>
  </div>
  <!-- /.box-header -->
  <div class="box-body">
    <div class="card" style="padding: 2px;">
        <div class="card-body">
            <div class="table-responsive m-t-40" >
            <table id="myTable" class="table table-striped table-condensed" style="font-size:14px;">
            <thead>
              <tr role="row">
                <th width="70%" class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Notice: activate to sort column ascending">Notice Name</th>
                <th width="10%" class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Notice: activate to sort column ascending">Category</th>
				<th tabindex="0" aria-controls="example2" rowspan="1" colspan="2" aria-label="Action: activate to sort column ascending">Action</th>
              </tr>
            </thead>
            <tbody>
            @foreach ($notices as $notice)
                <tr role="row" class="odd">
                  <td>{{ $notice->msg }} </br><small><font color="blue">Uploaded By: {{ $notice->userId }} &nbsp; &nbsp; &nbsp; Uploaded Time: {{ $notice->created_at }}</font></small></td>
                  <td>{{ $notice->categoryName }}</td>
                  <td>
                    <form class="row" method="POST" action="{{ route('notice.destroy', ['id' => $notice->noticeId]) }}" onsubmit = "return confirm('Are you sure?')">
                        <input type="hidden" name="_method" value="DELETE">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <a href="{{ route('notice.edit', ['id' => $notice->noticeId]) }}" class="btn btn-warning col-sm-4 col-xs-5 btn-margin">
                        Update
                        </a>
                        <button type="submit" class="btn btn-danger col-sm-4 col-xs-5 btn-margin">
                          Delete
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
          <div class="dataTables_info" id="example2_info" role="status" aria-live="polite">Showing 1 to {{count($notices)}} of {{count($notices)}} entries</div>
        </div>
        <div class="col-sm-7">
          <div class="dataTables_paginate paging_simple_numbers" id="example2_paginate">
            {{ $notices->links() }}
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