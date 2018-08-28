<form method="post" action="{{route('local.setUserTarget')}}">
    {{csrf_field()}}

    <input type="hidden" name="userId" value="{{$target->local_user_targetId}}">
<div class="row">

    <div class="col-md-12">
        <hr>
        <h6 align="center">{{$userName}}</h6>
        <hr>
    </div>

    <div class="col-md-4">
        <label>Revenue</label>
        <input type="number" class="form-control" name="earn" value="{{$target->earn}}">
    </div>

    <div class="col-md-4">
        <label>Meeting</label>
        <input type="number" class="form-control" name="meeting" value="{{$target->meeting}}">
    </div>

    <div class="col-md-4">
        <label>Follow-up</label>
        <input type="number" class="form-control" name="followup" value="{{$target->followup}}">
    </div>

    <div class="col-md-12">
    <button class="btn btn-success pull-right">Set</button>
    </div>
</div>
</form>