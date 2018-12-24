@extends('main')

@section('content')

<div style="text-align: center; margin-top: 5%;">

    <div class="avatar"><img src="img/avatar-1.jpg" alt="..." class="img-fluid rounded-circle"></div>

    <br><br>
    Name : <b>Test Name</b><br>

    Designation : <b>Employee</b><br>
    User Id : <b>12-5454-65</b>

    <br><br>
    <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#myModal" style="margin-left: 50%;">Change Password</button>


</div>



<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Modal Header</h4>
            </div>
            <div class="modal-body">
                <form>
                 Current Password :  <input type="text"><br>
                    Password :  <input type="text"><br>



                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>

    </div>
</div>



@endsection