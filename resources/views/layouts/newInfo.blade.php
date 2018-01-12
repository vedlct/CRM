@extends('main')


@section('header')



    <script>
  $( function() {
    $( "#tabs" ).tabs();
  } );
  </script>


@endsection


@section('content')


    <!-- Page Header-->
    <header class="page-header">
        <div class="container-fluid">
            <h2 class="no-margin-bottom">Add Info</h2>
        </div>
    </header>

<br><br>
  <div class="row">
    <div class="col-lg-6">
        <div class="card" style="margin-left: 10px;">
            <div class="card-close">
                <div class="dropdown">
                    <button type="button" id="closeCard" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="dropdown-toggle"><i class="fa fa-ellipsis-v"></i></button>
                    <div aria-labelledby="closeCard" class="dropdown-menu has-shadow"><a href="#" class="dropdown-item remove"> <i class="fa fa-times"></i>Close</a><a href="#" class="dropdown-item edit"> <i class="fa fa-gear"></i>Edit</a></div>
                </div>
            </div>
            <div class="card-header d-flex align-items-center">
                <h3 class="h4">New User</h3>
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
        <div class="card-close">
            <div class="dropdown">
                <button type="button" id="closeCard" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="dropdown-toggle"><i class="fa fa-ellipsis-v"></i></button>
                <div aria-labelledby="closeCard" class="dropdown-menu has-shadow"><a href="#" class="dropdown-item remove"> <i class="fa fa-times"></i>Close</a><a href="#" class="dropdown-item edit"> <i class="fa fa-gear"></i>Edit</a></div>
            </div>
        </div>
        <div class="card-header d-flex align-items-center">
            <h3 class="h4">New Category</h3>
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


<div style="padding: 20px">
  <div id="tabs">
  <ul>
    <li><a href="#tabs-1">Users</a></li>
    <li><a href="#tabs-2">Categories</a></li>
    <li><a href="#tabs-3">Aenean lacinia</a></li>
  </ul>
  <div id="tabs-1">

      <table class="table table-hover" style="background-color:white; ">
          <thead>
          <tr>
              <th>Company Name</th>
              <th>Web Address</th>
              <th>Category</th>
              <th>Contact Person</th>
              <th>Designation</th>
              <th>Contact Number</th>
              <th>Email</th>
              <th>Country</th>
              <th>Status</th>
              <th>Details</th>

          </tr>
          </thead>
          <tbody>
          <tr>
              <td>Triple Aught</td>
              <td>http://tripleaught.com</td>
              <td>Brand</td>
              <td>Skylar Flax-Davidson</td>
              <td>Director of Sales</td>
              <td>0123554864</td>
              <td>gmail.com</td>
              <td>USA PST</td>
              <td>Client</td>
              <td><a href=""><i class="fa fa-plus-square-o" aria-hidden="true"></i></a></td>

          </tr>
          <tr>
              <td>Triple Aught</td>
              <td>http://tripleaught.com</td>
              <td>Brand</td>
              <td>Skylar Flax-Davidson</td>
              <td>Director of Sales</td>
              <td>0123554864</td>
              <td>gmail.com</td>
              <td>USA PST</td>
              <td>Client</td>
              <td><a href=""><i class="fa fa-plus-square-o" aria-hidden="true"></i></a></td>
          </tr>
          <tr>
              <td>Triple Aught</td>
              <td>http://tripleaught.com</td>
              <td>Brand</td>
              <td>Skylar Flax-Davidson</td>
              <td>Director of Sales</td>
              <td>0123554864</td>
              <td>gmail.com</td>
              <td>USA PST</td>
              <td>Client</td>
              <td><a href=""><i class="fa fa-plus-square-o" aria-hidden="true"></i></a></td>
          </tr>
          </tbody>
      </table>




  </div>
  <div id="tabs-2">
    <p>Morbi tincidunt, dui sit amet facilisis feugiat, odio metus gravida ante, ut pharetra massa metus id nunc. Duis scelerisque molestie turpis. Sed fringilla, massa eget luctus malesuada, metus eros molestie lectus, ut tempus eros massa ut dolor. Aenean aliquet fringilla sem. Suspendisse sed ligula in ligula suscipit aliquam. Praesent in eros vestibulum mi adipiscing adipiscing. Morbi facilisis. Curabitur ornare consequat nunc. Aenean vel metus. Ut posuere viverra nulla. Aliquam erat volutpat. Pellentesque convallis. Maecenas feugiat, tellus pellentesque pretium posuere, felis lorem euismod felis, eu ornare leo nisi vel felis. Mauris consectetur tortor et purus.</p>
  </div>
  <div id="tabs-3">
    <p>Mauris eleifend est et turpis. Duis id erat. Suspendisse potenti. Aliquam vulputate, pede vel vehicula accumsan, mi neque rutrum erat, eu congue orci lorem eget lorem. Vestibulum non ante. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Fusce sodales. Quisque eu urna vel enim commodo pellentesque. Praesent eu risus hendrerit ligula tempus pretium. Curabitur lorem enim, pretium nec, feugiat nec, luctus a, lacus.</p>
    <p>Duis cursus. Maecenas ligula eros, blandit nec, pharetra at, semper at, magna. Nullam ac lacus. Nulla facilisi. Praesent viverra justo vitae neque. Praesent blandit adipiscing velit. Suspendisse potenti. Donec mattis, pede vel pharetra blandit, magna ligula faucibus eros, id euismod lacus dolor eget odio. Nam scelerisque. Donec non libero sed nulla mattis commodo. Ut sagittis. Donec nisi lectus, feugiat porttitor, tempor ac, tempor vitae, pede. Aenean vehicula velit eu tellus interdum rutrum. Maecenas commodo. Pellentesque nec elit. Fusce in lacus. Vivamus a libero vitae lectus hendrerit hendrerit.</p>
  </div>
</div>


</div>



@endsection