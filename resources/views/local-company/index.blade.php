@extends('main')
@section('content')
    <div class="card">
        <div class="card-body">
            <h4 align="center">Add Company</h4>
            <div class="row">
                <div class="form-group col-md-6">
                    <label>Company Name</label>
                    <input class="form-control" name="companyName" placeholder="name">
                </div>

                <div class="col-md-12">
                   <button class="btn btn-success">Insert</button>
                </div>

            </div>



        </div>

    </div>




@endsection