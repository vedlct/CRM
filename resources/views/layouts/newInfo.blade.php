@extends('main')


@section('header')


@endsection


@section('content')





  <div class="row">
    <div class="col-lg-6">
        <div class="card" style="margin-left: 10px;">

            <div class="card-header">
                <h3 class="h4">Add User</h3>
            </div>
            <div class="card-body">

                <form class="form-horizontal">
                    <div class="form-group row">
                        <label class="col-sm-3 form-control-label">User Name</label>
                        <div class="col-sm-9">
                            <input id="inputHorizontalSuccess" type="email" placeholder="Email Address" class="form-control form-control-success"><small class="form-text">Example help text that remains unchanged.</small>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-3 form-control-label">Password</label>
                        <div class="col-sm-9">
                            <input id="inputHorizontalWarning" type="password" placeholder="Pasword" class="form-control form-control-warning"><small class="form-text">Example help text that remains unchanged.</small>
                        </div>
                    </div>


                    <div class="form-group row">
                        <label class="col-sm-3 form-control-label">Designation</label>
                        <div class="col-sm-9">

                            <select name="designation" class="form-control form-control-warning">
                                <option value="">Admin</option>
                                <option value="">Supervisor</option>
                                <option value="">Manager</option>
                                <option value="">User</option>

                            </select>

                        </div>
                    </div>



                    <div class="form-group row">
                        <label class="col-sm-3 form-control-label">Status</label>
                        <div class="col-sm-9">

                            <select name="status" class="form-control form-control-warning">
                                <option value="">Active</option>
                                <option value="">Inactive</option>
                            </select>
                        </div>
                    </div>




                    <div class="form-group row">
                        <div class="col-sm-9 offset-sm-3">
                            <input type="submit" value="Create" class="btn btn-primary">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>



<div class="col-lg-4">
    <div class="card">

        <div class="card-header">
            <h3 class="h4">Add Category</h3>
        </div>
        <div class="card-body">

            <form class="form-horizontal">
                <div class="form-group row">
                    <label class="col-sm-3 form-control-label">Name</label>
                    <div class="col-sm-9">
                        <input id="inputHorizontalSuccess" type="text" placeholder="name" class="form-control form-control-success"><small class="form-text">Example help text that remains unchanged.</small>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-3 form-control-label">Category</label>
                    <div class="col-sm-9">

                        <select name="category" class="form-control form-control-warning">
                            <option value="">Category</option>
                            <option value="">Lead Status</option>
                            <option value="">Possibility</option>
                        </select>
                    </div>
                </div>


                <div class="form-group row">
                    <label class="col-sm-3 form-control-label">Status</label>
                    <div class="col-sm-9">
                        <select name="status" class="form-control form-control-warning">
                            <option value="">Active</option>
                            <option value="">Inactive</option>

                        </select>
                    </div>
                </div>







                <div class="form-group row">
                    <div class="col-sm-9 offset-sm-3">
                        <input type="submit" value="Create" class="btn btn-primary">
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>


  </div>




  <!-- Nav tabs -->

  <ul class="nav nav-tabs" role="tablist">
      <li class="nav-item">
          <a class="nav-link active" href="#profile" role="tab" data-toggle="tab">profile</a>
      </li>
      <li class="nav-item">
          <a class="nav-link" href="#buzz" role="tab" data-toggle="tab">buzz</a>
      </li>
      <li class="nav-item">
          <a class="nav-link" href="#references" role="tab" data-toggle="tab">references</a>
      </li>
  </ul>



  <!-- Tab panes -->
  <div class="tab-content">
      <div role="tabpanel" class="tab-pane fade in active" id="profile">
          
          <table class="table  table-hover">
              <thead>
              <tr>
                  <th>Firstname</th>
                  <th>Lastname</th>
                  <th>Email</th>
              </tr>
              </thead>
              <tbody>
              <tr>
                  <td>John</td>
                  <td>Doe</td>
                  <td>john@example.com</td>
              </tr>
              <tr>
                  <td>Mary</td>
                  <td>Moe</td>
                  <td>mary@example.com</td>
              </tr>
              <tr>
                  <td>July</td>
                  <td>Dooley</td>
                  <td>july@example.com</td>
              </tr>
              </tbody>
          </table>
      </div>
      <div role="tabpanel" class="tab-pane fade" id="buzz">
          Inside Buzz
      </div>
      <div role="tabpanel" class="tab-pane fade" id="references">
          Inside Reference

      </div>
  </div>





@endsection