
<form method="post" action="{{route('local.insertCallReport')}}">
    {{csrf_field()}}
<input type="hidden" name="local_leadId" value="{{$local_leadId}}">
<div class="row">
    <div class="col-md-6">

    <div class="row">

        <div class="form-group col-md-12">
            <label>Followup Date</label>
            <input class="form-control datepicker"   name="followup">
        </div>
        @if($count>0)
            <div class="form-group col-md-12">
                @if($followupId!="")
                    <input type="hidden" name="local_followupId" value="{{$followupId}}">
                @endif
                <label>Meeting</label>
                <input class="form-control datepicker" type="text"  name="meetingDate" placeholder="meeting date">
            </div>

        @endif
        @if($count>0)
            <div class="form-group col-md-12">
                @if($followupId!="")
                    <input type="hidden" name="local_followupId" value="{{$followupId}}">
                @endif
                <label>Meeting Time</label>
                    <input id="timepicker" class="form-control" type="time"  name="meetingTime" placeholder="meeting time" />
{{--                <input id="time" class="form-control" type="time"  name="meetingTime" placeholder="meeting time">--}}
            </div>

        @endif

        <div class="form-group col-md-12">
            <label>Comment</label>
            <textarea class="form-control" name="msg"></textarea>
        </div>


        <div class="form-group col-md-12">
            @if($followup !=null)
                <h4 align="center" style="color: #1e7e34">Next Followup Date Is :{{$followup->date}}</h4>
            @endif
        </div>



        @if($count>0)
        <div class="form-group col-md-12">
            <button type="submit" class="btn btn-success pull-right">Insert</button>

        </div>
        @endif

    </div>
    </div>

    <div class="col-md-6">

        <div class="row">

            <div class="col-md-11" style="border: solid 2px black; height: 400px;overflow-y: scroll;">
                @foreach($comments as $comment)
                    <hr>
                        {{$comment->msg}}
                        <br>
                        <span class="pull-right">-<b>{{$comment->firstName}}</b></span>
                @endforeach
            </div>

        </div>
    </div>


</div>

</form>

<script>
    $( function() {
        $( ".datepicker" ).datepicker();
        // $("#time").datetimepicker({format: 'HH:mm:ss', pickDate:false });

    } );
</script>

<script>
    $('#timepicker').timepicker({
        uiLibrary: 'bootstrap4'
    });
</script>