@extends('main')

@section('content')
    <!-- Main content -->
    <section class="content">
      <div class="box">
  <div class="box-header">
    <div class="row">
        <div class="col-sm-8">
          <h3 class="box-title">List of categories</h3>
        </div>
        <div class="col-sm-4">
          <a class="btn btn-primary" href="{{ route('category.create') }}">Add new category</a>
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
                <th width="30%" class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="category: activate to sort column ascending">Category Name</th>
                <th width="30%" class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="category: activate to sort column ascending">Type</th>
                <th tabindex="0" aria-controls="example2" rowspan="1" colspan="2" aria-label="Action: activate to sort column ascending">Action</th>
              </tr>
            </thead>
            <tbody>
            @foreach ($categories as $category)
                <tr role="row" class="odd">
                  <td>{{ $category->categoryName }}</td>
                  <td>@if ($category->type == 1)Lead
						@elseif ($category->type == 2)Notices
						@endif</td>
                  <td>
                    <form class="row" method="POST" action="{{ route('category.destroy', ['id' => $category->categoryId]) }}" onsubmit = "return confirm('Are you sure?')">
                        <input type="hidden" name="_method" value="DELETE">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <a href="{{ route('category.edit', ['id' => $category->categoryId]) }}" class="btn btn-warning col-sm-4 col-xs-5 btn-margin">
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
            <tfoot>
              <tr>
                <th width="20%" rowspan="1" colspan="1">Country Name</th>
                <th rowspan="1" colspan="2">Action</th>
              </tr>
            </tfoot>
          </table>
        </div>
      </div>
      <div class="row">
        <div class="col-sm-5">
          <div class="dataTables_info" id="example2_info" role="status" aria-live="polite">Showing 1 to {{count($categories)}} of {{count($categories)}} entries</div>
        </div>
        <div class="col-sm-7">
          <div class="dataTables_paginate paging_simple_numbers" id="example2_paginate">
            {{ $categories->links() }}
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